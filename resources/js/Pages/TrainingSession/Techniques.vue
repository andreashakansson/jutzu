<template>
    <ul role="list" class="">

        <li v-for="technique in techniques" :key="technique.id"
            class="odd:bg-white even:bg-gray-50 hover:bg-slate-100">
            <technique :technique="technique"></technique>
        </li>

    </ul>
</template>

<script>
import Technique from "./Technique";
import {defineComponent} from "vue";

export default defineComponent({
    props: [
        'techniques'
    ],
    components: {
        Technique
    },
    data: function () {
        return {
            display: false
        }
    }
})
</script>
