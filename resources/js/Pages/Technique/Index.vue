<template>
    <app-layout :title="__('Techniques')">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Techniques') }}
            </h2>
        </template>

        <div class="py-10">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex flex-wrap justify-between mb-2">
                <div class="text-2xl">
                    {{ __('All techniques at :academy', { academy: academy.name }) }}
                </div>

                <div class="flex-shrink-0 flex">
                    <Link :href="route('technique.create')" as="button" type="button"
                          class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                        {{ __('New technique') }}
                    </Link>
                </div>
            </div>

            <div v-for="technique in techniques" :key="technique.id"
                 class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
                <div class="max-w-none mx-auto">
                    <div class="bg-white overflow-hidden sm:rounded-lg sm:shadow" style="min-height: 145px;">

                        <div class="bg-white px-4 py-5 border-gray-200 sm:px-6">

                            <div class="-ml-4 -mt-4 flex justify-between flex-wrap sm:flex-nowrap">
                                <div class="ml-4 mt-4">

                                    <div class="flex">
                                        <h3 class="text-lg font-medium text-gray-900">
                                            {{ technique.name }}
                                        </h3>
                                    </div>

                                    <div v-if="technique.description" class="mt-1 text-sm text-gray-500">
                                        <p>{{ technique.description }}</p>
                                    </div>
                                </div>
                                <div class="ml-4 mt-5 flex-shrink-0 flex">
                                    <Menu as="div" class="relative inline-block text-left">
                                        <div>
                                            <MenuButton
                                                class="-m-2 p-2 rounded-full flex items-center text-gray-400 hover:text-gray-600">
                                                <span class="sr-only">{{ __('Open options') }}</span>
                                                <DotsVerticalIcon class="h-5 w-5" aria-hidden="true"/>
                                            </MenuButton>
                                        </div>

                                        <transition enter-active-class="transition ease-out duration-100"
                                                    enter-from-class="transform opacity-0 scale-95"
                                                    enter-to-class="transform opacity-100 scale-100"
                                                    leave-active-class="transition ease-in duration-75"
                                                    leave-from-class="transform opacity-100 scale-100"
                                                    leave-to-class="transform opacity-0 scale-95">
                                            <MenuItems
                                                class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-10">
                                                <div class="py-1">
                                                    <MenuItem v-slot="{ active }">
                                                        <Link :href="route('technique.edit', technique.id)"
                                                              :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'flex px-4 py-2 text-sm']">
                                                            <PencilIcon class="mr-3 h-5 w-5 text-gray-400"
                                                                        aria-hidden="true"/>
                                                            <span>{{ __('Edit technique') }}</span>
                                                        </Link>
                                                    </MenuItem>
                                                </div>
                                            </MenuItems>
                                        </transition>
                                    </Menu>

                                </div>
                            </div>

                            <div class="max-w-full lg:max-w-[60%]">
                                <div v-if="technique.youtube_embed_url" class="video-container mt-4 mb-4">
                                    <iframe width="560" height="315" :src="technique.youtube_embed_url"
                                            title="YouTube video player" frameborder="0"
                                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                            allowfullscreen></iframe>
                                </div>
                                <div v-else class="mt-1 text-sm text-gray-500">
                                    {{ __('No video added yet.') }}
                                    <Link :href="route('technique.edit', technique.id)" class="underline">
                                        {{ __('Click here to add.') }}
                                    </Link>
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
