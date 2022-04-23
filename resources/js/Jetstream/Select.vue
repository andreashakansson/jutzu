<template>
    <select :value="modelValue" @input="$emit('update:modelValue', $event.target.value)" class="form-select appearance-none
      block
      w-full
      text-base
      font-normal
      text-gray-700
      bg-white bg-clip-padding bg-no-repeat
      border-300
      transition
      ease-in-out
      m-0
      border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
            aria-label="Default select example"
            ref="input">
        <option v-for="(label, value) in options" :value="value" :key="value">{{ label }}</option>
    </select>
</template>

<script>
import {defineComponent} from 'vue'

export default defineComponent({
    props: ['modelValue', 'options'],

    emits: ['update:modelValue'],

    methods: {
        focus() {
            this.$refs.input.focus()
        }
    }
})
</script>
