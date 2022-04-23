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
                        Latest training sessions at {{ academy.name }}
                    </div>

                    <div class="flex-shrink-0 flex">
                        <Link :href="route('trainingSession.create')" as="button" type="button"
                              class="inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition">
                            New training session
                        </Link>
                    </div>
                </div>

                <training-sessions :trainingSessions="trainingSessions"></training-sessions>

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
import Techniques from "./TrainingSession/Techniques";
import TrainingSessions from "./TrainingSession/TrainingSessions";

export default defineComponent({
    props: [
        'academy',
        'trainingSessions'
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
        PencilIcon,
        TrainingSessions,
        Techniques
    },
})
</script>
