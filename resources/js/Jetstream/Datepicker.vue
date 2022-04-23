<template>
    <flat-pickr v-model="value" :config="config"
                class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                ref="input"></flat-pickr>
</template>

<script>
import flatPickr from 'vue-flatpickr-component';
import 'flatpickr/dist/flatpickr.css';
import {Swedish} from 'flatpickr/dist/l10n/sv.js';

export default {
    props: ['value'],
    components: {
        flatPickr
    },
    data() {
        return {
            config: {
                altFormat: 'D d M Y',
                altInput: true,
                dateFormat: 'Y-m-d',
                locale: Swedish, // locale for this instance only
            },
        }
    },
    methods: {
        focus() {
            this.$refs.input.focus()
        }
    }
}
</script>
