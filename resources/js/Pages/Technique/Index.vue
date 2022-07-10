<template>
    <app-layout title="Training session">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <template v-if="academy">
            <div class="py-10">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-wrap justify-between mb-2">
                    <div class="text-2xl">
                        All techniques
                    </div>

                    <!--
                    @todo
                    <div class="flex-shrink-0 flex">
                        <Link :href="route('trainingSession.create')" as="button" type="button"
                              class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                            New technique
                        </Link>
                    </div>
                    -->
                </div>

                <div v-for="technique in techniques" :key="technique.id"
                     class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
                    <div class="max-w-none mx-auto">
                        <div class="bg-white overflow-hidden sm:rounded-lg sm:shadow" style="min-height: 145px;">
                            <ul role="list" class="">

                                <li class="odd:bg-white even:bg-gray-50 hover:bg-slate-100">
                                    <a href="#" class="block">
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
                                            <div class="max-w-full lg:max-w-[60%]">
                                                <div v-if="technique.youtube_embed_url" class="video-container mt-4 mb-4">
                                                    <iframe width="560" height="315" :src="technique.youtube_embed_url"
                                                            title="YouTube video player" frameborder="0"
                                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                                            allowfullscreen></iframe>
                                                </div>
                                                <div v-else>
                                                    No video added yet.
                                                </div>
                                            </div>
                                        </div>
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </template>
        <template v-else>
            <div class="py-10">
                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-wrap justify-between mb-2">
                    <div class="text-2xl">
                        You don't belong to any academy yet.
                    </div>
                </div>
            </div>
        </template>
    </app-layout>
</template>

<script>
import {defineComponent} from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import {Link} from "@inertiajs/inertia-vue3";
import {Menu, MenuButton, MenuItem, MenuItems, Popover, PopoverButton, PopoverPanel} from '@headlessui/vue'
import {
    ChatAltIcon,
    CodeIcon,
    DotsVerticalIcon,
    EyeIcon,
    FlagIcon,
    PencilIcon,
    PlusSmIcon,
    SearchIcon,
    ShareIcon,
    StarIcon,
    ThumbUpIcon
} from '@heroicons/vue/solid'
import {BellIcon, MenuIcon, XIcon} from '@heroicons/vue/outline'

export default defineComponent({
    props: [
        'academy',
        'techniques'
    ],
    components: {
        AppLayout,
        Link,
        Menu,
        MenuButton,
        MenuItem,
        MenuItems,
        Popover,
        PopoverButton,
        PopoverPanel,
        BellIcon,
        ChatAltIcon,
        CodeIcon,
        DotsVerticalIcon,
        EyeIcon,
        FlagIcon,
        MenuIcon,
        PlusSmIcon,
        SearchIcon,
        ShareIcon,
        StarIcon,
        ThumbUpIcon,
        XIcon,
        PencilIcon
    },
})
</script>
