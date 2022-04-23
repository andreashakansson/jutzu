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

                            <div v-if="form.type === 'normal'">
                                <jet-form v-for="(technique, index) in form.techniques" :key="index" class="mt-8">
                                    <template #form>

                                        <div class="col-span-6 sm:col-span-4">
                                            <strong @click="removeTechnique(index)" title="Remove"
                                                    class="text-xl align-center cursor-pointer alert-del">
                                                &times;
                                            </strong>
                                        </div>

                                        <div class="col-span-6 sm:col-span-4">
                                            <jet-label :for="'name-' + index"
                                                       :value="'Name of technique ' + (index+1) + ' *'"/>
                                            <jet-input :id="'name-' + index" type="text" class="mt-1 block w-full"
                                                       v-model="technique.name" autocomplete="off"/>
                                            <jet-input-error :message="techniqueErrors(index, 'name')" class="mt-2"/>
                                        </div>

                                        <div class="col-span-6 sm:col-span-4">
                                            <jet-label :for="'description-' + index" value="Description of technique"/>
                                            <jet-textarea :for="'description-' + index" class="mt-1 block w-full"
                                                          v-model="technique.description" autocomplete="off" rows="3"/>
                                            <jet-input-error :message="techniqueErrors(index, 'description')"
                                                             class="mt-2"/>
                                        </div>

                                        <div class="col-span-6 sm:col-span-4">
                                            <jet-label :for="'youtube-url-' + index" value="Youtube link"/>
                                            <jet-input :id="'youtube-url-' + index" type="text"
                                                       class="mt-1 block w-full"
                                                       v-model="technique.youtube_url" autocomplete="off"/>
                                            <jet-input-error
                                                :message="techniqueErrors(index, 'youtube_url')"
                                                class="mt-2"/>
                                        </div>

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

export default defineComponent({
    props: [
        'trainingSession',
        'types'
    ],
    components: {
        AppLayout,
        JetActionMessage,
        JetButton,
        JetForm,
        JetDatepicker,
        JetInput,
        JetTextarea,
        JetSelect,
        JetInputError,
        JetLabel
    },
    data() {
        return {
            form: this.$inertia.form(this.trainingSession),
        }
    },
    methods: {
        addTechnique() {
            this.form.techniques.push({
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
        techniqueErrors(index, field) {
            const errorKey = 'techniques.' + index + '.' + field;
            return this.form.errors[errorKey];
        }
    }
})
</script>
