<template>
    <app-layout title="Training session">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Training session
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div>
                        <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
                            <div class="mt-8 mb-8 text-2xl">
                                <template v-if="trainingSession.id">
                                    Edit training session
                                </template>
                                <template v-else>
                                    New training session
                                </template>
                            </div>

                            <jet-form>

                                <template #form>
                                    <div class="col-span-6 sm:col-span-4">

                                        <jet-label for="date" value="Date *"/>
                                        <jet-datepicker id="date" class="mt-1 block w-full"
                                                        v-model="form.date" autocomplete="off" rows="3"/>
                                        <jet-input-error :message="form.errors.date" class="mt-2"/>

                                    </div>

                                    <div class="col-span-6 sm:col-span-4">
                                        <jet-label for="type" value="Type *"/>
                                        <jet-select id="type" class="mt-1 block w-full" v-model="form.type"
                                                    :options="types"
                                                    autocomplete="off"/>
                                        <jet-input-error :message="form.errors.type" class="mt-2"/>
                                    </div>

                                    <div class="col-span-6 sm:col-span-4">
                                        <jet-label for="notes" value="Notes for training session"/>
                                        <jet-textarea id="notes" class="mt-1 block w-full"
                                                      v-model="form.notes" autocomplete="off" rows="3"/>
                                        <jet-input-error :message="form.errors.notes" class="mt-2"/>
                                    </div>
                                </template>
                            </jet-form>

                            <div v-if="form.type === 'regular'">
                                <jet-form v-for="(technique, index) in form.techniques" :key="index" class="mt-8">
                                    <template #form>
                                        <edit-technique
                                            :form-errors="form.errors"
                                            :technique="technique"
                                            :all-techniques="allTechniques"
                                            :index="index"
                                            @remove-technique="removeTechnique(index)"
                                        >
                                        </edit-technique>
                                    </template>
                                </jet-form>

                                <div class="col-span-6 sm:col-span-4 mt-8">
                                    <jet-button type="button" @click="addTechnique()">+ Technique</jet-button>
                                </div>
                            </div>


                            <div class="md:grid md:grid-cols-3 md:gap-6 mt-8">
                                <div class="mt-5 md:mt-0 md:col-span-2">

                                    <form @submit.prevent="submit">
                                        <div
                                            class="flex items-center justify-end px-4 py-3 text-right sm:px-6 sm:rounded-bl-md sm:rounded-br-md">
                                            <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                                                Saved.
                                            </jet-action-message>

                                            <jet-danger-button v-if="trainingSession.id" @click="confirmDeletion" class="mr-2">
                                                Delete training session
                                            </jet-danger-button>

                                            <!-- Delete Training Session Confirmation Modal -->
                                            <jet-dialog-modal :show="confirmingDeletion" @close="closeModal">
                                                <template #title>
                                                    Delete training session
                                                </template>

                                                <template #content>
                                                    Are you sure you want to delete this training session?
                                                </template>

                                                <template #footer>
                                                    <jet-secondary-button @click="closeModal">
                                                        Cancel
                                                    </jet-secondary-button>

                                                    <jet-danger-button
                                                        class="ml-3"
                                                        @click="deleteTrainingSession"
                                                        :class="{ 'opacity-25': deleteForm.processing }"
                                                        :disabled="deleteForm.processing">
                                                        Delete training session
                                                    </jet-danger-button>
                                                </template>
                                            </jet-dialog-modal>

                                            <jet-button :class="{ 'opacity-25': form.processing }"
                                                        :disabled="form.processing">
                                                Save training session
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
import JetSelect from '@/Jetstream/Select.vue'
import JetInputError from '@/Jetstream/InputError.vue'
import JetLabel from '@/Jetstream/Label.vue'
import Multiselect from 'vue-multiselect'
import EditTechnique from './Partials/EditTechnique'
import JetDangerButton from '@/Jetstream/DangerButton.vue'
import JetDialogModal from '@/Jetstream/DialogModal.vue'
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'

export default defineComponent({
    props: [
        'trainingSession',
        'types',
        'allTechniques'
    ],
    components: {
        EditTechnique,
        AppLayout,
        JetActionMessage,
        JetButton,
        JetForm,
        JetDatepicker,
        JetInput,
        JetTextarea,
        JetSelect,
        JetInputError,
        JetLabel,
        Multiselect,
        JetDangerButton,
        JetDialogModal,
        JetSecondaryButton
    },
    data() {
        return {
            form: this.$inertia.form(this.trainingSession),
            deleteForm: this.$inertia.form(),
            confirmingDeletion: false,
        }
    },
    methods: {
        addTechnique() {
            this.form.techniques.push({
                'id': null,
                'name': '',
                'description': '',
                'youtube_url': ''
            })
        },
        removeTechnique(index) {
            this.form.techniques.splice(index, 1)
        },
        submit() {
            this.form.post(route('trainingSession.submit'), {
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
        deleteTrainingSession() {
            this.deleteForm.delete(route('trainingSession.delete', this.trainingSession.id), {
                preserveScroll: false,
                onSuccess: () => this.closeModal(),
                // onError: () => this.$refs.password.focus(),
                onFinish: () => this.deleteForm.reset(),
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
