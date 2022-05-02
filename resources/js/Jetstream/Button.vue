<template>
    <button :type="type"
            class="inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-xs uppercase tracking-widest active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition"
            :class="themeClasses"
    >
        <slot></slot>
    </button>
</template>

<script>
import {defineComponent} from 'vue'

export default defineComponent({
    props: {
        type: {
            type: String,
            default: 'submit',
        },
        theme: {
            type: String,
            default: 'default'
        }
    },
    computed: {
        themeClasses() {
            if (this.theme === 'gray') {
                return 'text-gray-600 bg-gray-200 hover:bg-gray-100'
            }
            // Default
            return 'text-white bg-gray-800 hover:bg-gray-700'
        }
    }
})
</script>
