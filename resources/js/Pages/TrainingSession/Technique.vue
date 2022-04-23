<template>
    <a href="#" @click.prevent="display = !display" class="block">
        <div class="px-4 py-4 sm:px-6">
            <div class="flex items-center justify-between">
                <div class="text-m font-medium text-indigo-600 truncate">
                    {{ technique.name }}
                </div>
            </div>
            <div v-if="technique.description" class="mt-2 flex justify-between">
                <div class="sm:flex">
                    <div class="flex items-center text-sm text-gray-500">
                        {{ technique.description }}
                    </div>
                </div>
            </div>
            <div v-show="display" class="max-w-full lg:max-w-[60%]">
                <div v-show="technique.youtube_embed_url" class="video-container mt-4 mb-4">
                    <iframe width="560" height="315" :src="technique.youtube_embed_url"
                            title="YouTube video player" frameborder="0"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                            allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </a>
</template>

<script>
import {defineComponent} from "vue";

export default defineComponent({
    props: [
        'technique'
    ],
    data: function () {
        return {
            display: false
        }
    }
})
</script>

<style>
.video-container {
    position: relative;
    padding-bottom: 56.25%;
    padding-top: 30px;
    height: 0;
    overflow: hidden;
}

.video-container iframe, .video-container object, .video-container embed {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}

</style>
