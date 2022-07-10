<template>

    <div class="col-span-6 sm:col-span-4">
        <strong @click="$emit('removeTechnique', index)" title="Remove"
                class="text-xl align-center cursor-pointer alert-del">
            &times;
        </strong>
    </div>

    <div class="col-span-6 sm:col-span-4">
        <jet-label :for="'name-' + index"
                   :value="'Name of technique ' + (index+1) + ' *'"/>
        <multiselect
            v-model="selectedTechnique"
            :options="allTechniques"
            track-by="id"
            label="name"
            :id="'name-' + index"
            placeholder="Search for an existing technique or enter the name of a new one"
            selectLabel="Press enter to select"
            selectedLabel="Selected"
            deselectLabel="Press enter to remove"
            :taggable="true"
            @tag="addTechniqueToList"
            @select="onSelectedTechnique"
            class="mt-1 block w-full"
            autocomplete="off"
        />
        <jet-input-error :message="techniqueErrors(index, 'name')" class="mt-2"/>
    </div>

    <template v-if="!technique.id && technique.name !== ''">
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
        Multiselect
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
