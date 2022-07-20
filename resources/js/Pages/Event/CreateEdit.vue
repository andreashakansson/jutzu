<template>
    <app-layout :title="__('Calendar')">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Calendar') }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div>
                        <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                            <div class="mt-8 mb-8 text-2xl">
                                <template v-if="event.id">
                                    {{ __('Edit event') }}
                                </template>
                                <template v-else>
                                    {{ __('New event') }}
                                </template>
                            </div>

                            <jet-form>

                                <template #form>
                                    <div class="col-span-6 sm:col-span-4">
                                        <jet-label for="name" :value="__('Name') + ' *'"/>
                                        <jet-input id="name" type="text"
                                                   class="mt-1 block w-full"
                                                   v-model="form.name" autocomplete="off"/>
                                        <jet-input-error
                                            :message="form.errors.name"
                                            class="mt-2"/>
                                    </div>

                                    <div class="col-span-6 sm:col-span-4">
                                        <jet-label for="start-date" :value="__('Starts') + ' *'"/>
                                        <jet-datepicker id="start-date" class="mt-1 w-1/2 inline"
                                                        v-model="form.start_date" autocomplete="off" rows="3"/>
                                        <jet-input-error :message="form.errors.start_date" class="mt-2"/>

                                        <div class="float-right w-1/2 text-right">
                                            <jet-select id="start-hour" class="mt-1 w-1/4 inline" v-model="form.start_hour"
                                                        :options="hours"
                                                        autocomplete="off"/>
                                            <jet-input-error :message="form.errors.start_hour" class="mt-2"/>

                                            <div class="my-3 mx-2 inline">:</div>

                                            <jet-select id="start-minute" class="mt-1 w-1/4 inline" v-model="form.start_minute"
                                                        :options="minutes"
                                                        autocomplete="off"/>
                                            <jet-input-error :message="form.errors.start_minute" class="mt-2"/>
                                        </div>
                                    </div>

                                    <div class="col-span-6 sm:col-span-4">
                                        <jet-label for="end-date" :value="__('Ends') + ' *'"/>
                                        <jet-datepicker id="end-date" class="mt-1 w-1/2 inline"
                                                        v-model="form.end_date" autocomplete="off" rows="3"/>
                                        <jet-input-error :message="form.errors.end_date" class="mt-2"/>

                                        <div class="float-right w-1/2 text-right">
                                            <jet-select id="end-hour" class="mt-1 w-1/4 inline" v-model="form.end_hour"
                                                        :options="hours"
                                                        autocomplete="off"/>
                                            <jet-input-error :message="form.errors.end_hour" class="mt-2"/>

                                            <div class="my-3 mx-2 inline">:</div>

                                            <jet-select id="end-minute" class="mt-1 w-1/4 inline" v-model="form.end_minute"
                                                        :options="minutes"
                                                        autocomplete="off"/>
                                            <jet-input-error :message="form.errors.end_minute" class="mt-2"/>
                                        </div>
                                    </div>

                                    <div class="col-span-6 sm:col-span-4">
                                        <jet-label for="description" :value="__('Description of the event')"/>
                                        <jet-textarea for="description" class="mt-1 block w-full"
                                                      v-model="form.description" autocomplete="off" rows="3"/>
                                        <jet-input-error :message="form.errors.description"
                                                         class="mt-2"/>
                                    </div>
                                </template>
                            </jet-form>

                            <div class="md:grid md:grid-cols-3 md:gap-6 mt-8">
                                <div class="mt-5 md:mt-0 md:col-span-2">

                                    <form @submit.prevent="submit">
                                        <div
                                            class="flex items-center justify-end px-4 py-3 text-right sm:px-6 sm:rounded-bl-md sm:rounded-br-md">
                                            <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                                                {{ __('Saved.') }}
                                            </jet-action-message>

                                            <jet-danger-button v-if="event.id" @click="confirmDeletion" class="mr-2">
                                                {{ __('Delete event') }}
                                            </jet-danger-button>

                                            <!-- Delete Technique Confirmation Modal -->
                                            <jet-dialog-modal :show="confirmingDeletion" @close="closeModal">
                                                <template #title>
                                                    {{ __('Delete event') }}
                                                </template>

                                                <template #content>
                                                    <template v-if="event.has_training_sessions">
                                                        {{ __('Technique can not be deleted as it exists on a training session.') }}
                                                        {{ __('Please fix this first.') }}
                                                    </template>
                                                    <template v-else>
                                                        {{ __('Are you sure you want to delete this event?') }}
                                                    </template>
                                                </template>

                                                <template #footer>
                                                    <jet-secondary-button @click="closeModal">
                                                        {{ __('Cancel') }}
                                                    </jet-secondary-button>

                                                    <jet-danger-button
                                                        v-if="!event.has_training_sessions"
                                                        class="ml-3"
                                                        @click="deleteTechnique"
                                                        :class="{ 'opacity-25': deleteTechniqueForm.processing }"
                                                        :disabled="deleteTechniqueForm.processing">
                                                        {{ __('Delete event') }}
                                                    </jet-danger-button>
                                                </template>
                                            </jet-dialog-modal>

                                            <jet-button :class="{ 'opacity-25': form.processing }"
                                                        :disabled="form.processing">
                                                {{ __('Save event') }}
                                            </jet-button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import {defineComponent} from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import JetActionMessage from '@/Jetstream/ActionMessage.vue'
import JetButton from '@/Jetstream/Button.vue'
import JetForm from '@/Jetstream/Form.vue'
import JetDatepicker from '@/Jetstream/Datepicker.vue'
import JetInput from '@/Jetstream/Input.vue'
import JetTextarea from '@/Jetstream/Textarea.vue'
import JetInputError from '@/Jetstream/InputError.vue'
import JetLabel from '@/Jetstream/Label.vue'
import JetDangerButton from '@/Jetstream/DangerButton.vue'
import JetDialogModal from '@/Jetstream/DialogModal.vue'
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'
import JetSelect from '@/Jetstream/Select.vue'

export default defineComponent({
    props: [
        'event',
        'hours',
        'minutes'
    ],
    components: {
        AppLayout,
        JetActionMessage,
        JetButton,
        JetForm,
        JetDatepicker,
        JetInput,
        JetTextarea,
        JetInputError,
        JetLabel,
        JetDangerButton,
        JetDialogModal,
        JetSecondaryButton,
        JetSelect
    },
    data() {
        return {
            form: this.$inertia.form(this.event),
            deleteTechniqueForm: this.$inertia.form(),
            confirmingDeletion: false,
        }
    },
    methods: {
        submit() {
            this.form.post(route('event.submit'), {
                errorBag: 'submit',
                preserveScroll: true,
                onSuccess: () => this.form.reset(),
                onError: () => {
                    /*
                    if (this.form.errors.password) {
                        this.form.reset('password', 'password_confirmation')
                        this.$refs.password.focus()
                    }

                    if (this.form.errors.current_password) {
                        this.form.reset('current_password')
                        this.$refs.current_password.focus()
                    }*/
                }
            })
        },
        deleteTechnique() {
            this.deleteTechniqueForm.delete(route('event.delete', this.event.id), {
                preserveScroll: false,
                onSuccess: () => this.closeModal(),
                // onError: () => this.$refs.password.focus(),
                onFinish: () => this.deleteTechniqueForm.reset(),
            })
        },
        confirmDeletion() {
            this.confirmingDeletion = true
        },
        closeModal() {
            this.confirmingDeletion = false
        }
    }
})
</script>

<style>
.multiselect__tags {
    border-color: rgb(209 213 219 / var(--tw-border-opacity)) !important;
}

.multiselect__tags input[type="text"]:focus {
    --tw-ring-color: 0;
}
</style>
