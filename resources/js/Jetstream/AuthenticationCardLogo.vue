<template>
    <Link :href="'/'">
        <h1 class="font-['Arial'] text-2xl tracking-wide leading-7 text-gray-900 sm:text-3xl sm:truncate">
            Jutzu
        </h1>
    </Link>
</template>

<script>
import {defineComponent} from 'vue'
import {Link} from '@inertiajs/inertia-vue3';

export default defineComponent({
    components: {
        Link,
    },
})
</script>
