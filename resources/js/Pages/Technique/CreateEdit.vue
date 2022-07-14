<template>
    <app-layout title="Technique">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Technique
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div>
                        <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                            <div class="mt-8 mb-8 text-2xl">
                                <template v-if="technique.id">
                                    Edit technique
                                </template>
                                <template v-else>
                                    New technique
                                </template>
                            </div>

                            <jet-form>

                                <template #form>
                                    <div class="col-span-6 sm:col-span-4">
                                        <jet-label for="name" value="Name *"/>
                                        <jet-input id="name" type="text"
                                                   class="mt-1 block w-full"
                                                   v-model="form.name" autocomplete="off"/>
                                        <jet-input-error
                                            :message="form.errors.name"
                                            class="mt-2"/>
                                    </div>

                                    <div class="col-span-6 sm:col-span-4">
                                        <jet-label for="description" value="Description of technique"/>
                                        <jet-textarea for="description" class="mt-1 block w-full"
                                                      v-model="form.description" autocomplete="off" rows="3"/>
                                        <jet-input-error :message="form.errors.description"
                                                         class="mt-2"/>
                                    </div>

                                    <div class="col-span-6 sm:col-span-4">
                                        <jet-label for="youtube-url" value="Youtube link"/>
                                        <jet-input id="youtube-url" type="text"
                                                   class="mt-1 block w-full"
                                                   v-model="form.youtube_url" autocomplete="off"/>
                                        <jet-input-error
                                            :message="form.errors.youtube_url"
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
                                                Saved.
                                            </jet-action-message>

                                            <jet-danger-button v-if="technique.id" @click="confirmDeletion" class="mr-2">
                                                Delete technique
                                            </jet-danger-button>

                                            <!-- Delete Technique Confirmation Modal -->
                                            <jet-dialog-modal :show="confirmingDeletion" @close="closeModal">
                                                <template #title>
                                                    Delete technique
                                                </template>

                                                <template #content>
                                                    <template v-if="technique.has_training_sessions">
                                                        You can not delete this technique as it exists on training sessions. Please fix this first.
                                                    </template>
                                                    <template v-else>
                                                        Are you sure you want to delete this technique?
                                                    </template>
                                                </template>

                                                <template #footer>
                                                    <jet-secondary-button @click="closeModal">
                                                        Cancel
                                                    </jet-secondary-button>

                                                    <jet-danger-button
                                                        v-if="!technique.has_training_sessions"
                                                        class="ml-3"
                                                        @click="deleteTechnique"
                                                        :class="{ 'opacity-25': deleteTechniqueForm.processing }"
                                                        :disabled="deleteTechniqueForm.processing">
                                                        Delete technique
                                                    </jet-danger-button>
                                                </template>
                                            </jet-dialog-modal>

                                            <jet-button :class="{ 'opacity-25': form.processing }"
                                                        :disabled="form.processing">
                                                Save technique
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

export default defineComponent({
    props: [
        'technique'
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
        JetSecondaryButton
    },
    data() {
        return {
            form: this.$inertia.form(this.technique),
            deleteTechniqueForm: this.$inertia.form(),
            confirmingDeletion: false,
        }
    },
    methods: {
        submit() {
            this.form.post(route('technique.submit'), {
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
            this.deleteTechniqueForm.delete(route('technique.delete', this.technique.id), {
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
