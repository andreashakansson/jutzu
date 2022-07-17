<template>

    <div class="col-span-6 sm:col-span-4">
        <strong @click="$emit('removeTechnique', index)" title="Remove"
                class="text-xl align-center cursor-pointer alert-del">
            &times;
        </strong>
    </div>

    <div class="col-span-6 sm:col-span-4">
        <jet-label :for="'name-' + index"
                   :value="__('Name of technique :num', { num: (index+1) }) + ' *'"/>
        <multiselect
            v-model="selectedTechnique"
            :options="allTechniques"
            track-by="id"
            label="name"
            :id="'name-' + index"
            :placeholder="__('Search for an existing technique or enter the name of a new one that you want to add')"
            :select-label="__('Press enter to select')"
            :selected-label="__('Selected')"
            :deselect-label="__('Press enter to remove')"
            :tag-placeholder="__('Add this as a new technique')"
            :taggable="true"
            @tag="addTechniqueToList"
            @select="onSelectedTechnique"
            class="mt-1 block w-full"
            autocomplete="off"
        />
        <jet-input-error :message="techniqueErrors(index, 'name')" class="mt-2"/>

        <div v-if="technique.id" class="mt-1">
            <a :href="route('technique.edit', technique.id)" target="_blank"
               class="underline text-sm text-gray-600 hover:text-gray-900">
                {{ __('Edit technique (opens in new tab)') }}
            </a>
        </div>
    </div>

    <template v-if="!technique.id && technique.name !== ''">
        <div class="col-span-6 sm:col-span-4">
            <jet-label :for="'description-' + index" :value="__('Description of technique')"/>
            <jet-textarea :for="'description-' + index" class="mt-1 block w-full"
                          v-model="technique.description" autocomplete="off" rows="3"/>
            <jet-input-error :message="techniqueErrors(index, 'description')"
                             class="mt-2"/>
        </div>

        <div class="col-span-6 sm:col-span-4">
            <jet-label :for="'youtube-url-' + index" :value="__('Youtube link')"/>
            <jet-input :id="'youtube-url-' + index" type="text"
                       class="mt-1 block w-full"
                       v-model="technique.youtube_url" autocomplete="off"/>
            <div class="text-sm font-medium text-gray-600 mt-1">
                {{ __('Unsure about how to add a new technique with a Youtube video?') }}
                <a :href="route('guide')" target="_blank" class="underline">
                    {{ __('Click here to read the guide.') }}
                </a>
            </div>
            <jet-input-error
                :message="techniqueErrors(index, 'youtube_url')"
                class="mt-2"/>
        </div>
    </template>
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
import {Link} from '@inertiajs/inertia-vue3';

export default defineComponent({
    props: [
        'formErrors',
        'technique',
        'allTechniques',
        'index'
    ],
    emits: [
      'removeTechnique'
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
        JetLabel,
        Multiselect,
        Link
    },
    data() {
        return {
            selectedTechnique: ''
        }
    },
    mounted() {
        if (this.technique.id) {
            this.selectedTechnique = this.technique
        }
    },
    methods: {
        onSelectedTechnique(technique) {
            this.technique.id = technique.id
            this.technique.name = technique.name
        },
        addTechniqueToList(newTechnique) {
            const technique = {
                id: null,
                name: newTechnique
            }
            this.allTechniques.push(technique)
            this.selectedTechnique = technique
            this.onSelectedTechnique(technique)
        },
        techniqueErrors(index, field) {
            const errorKey = 'techniques.' + index + '.' + field;
            return this.formErrors[errorKey];
        }
    }
})
</script>
