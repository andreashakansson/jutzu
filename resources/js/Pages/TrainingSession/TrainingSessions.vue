<template>

    <div v-for="trainingSession in trainingSessions" :key="trainingSession.id"
         class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="max-w-none mx-auto">
            <div class="bg-white overflow-hidden sm:rounded-lg sm:shadow" style="min-height: 145px;">

                <div :class="trainingSession.techniques.length > 0 ? 'border-b': ''"
                     class="bg-white px-4 py-5 border-gray-200 sm:px-6">
                    <div class="-ml-4 -mt-4 flex justify-between flex-wrap sm:flex-nowrap">
                        <div class="ml-4 mt-4">

                            <div class="flex">
                                <h3 class="text-lg font-medium text-gray-900">
                                    {{ trainingSession.dateHuman }}
                                </h3>

                                <Menu as="div" class="relative inline-block text-left ml-3 mr-3 mt-[1px]">
                                    <div>
                                        <MenuButton
                                            :class="getParticipatedButtonClasses(trainingSession.userIsParticipant)"
                                            class="inline-flex justify-center w-full rounded border px-2 py-1 text-xs font-semibold uppercase">
                                            <template v-if="trainingSession.userIsParticipant === null">
                                                <span>Did you train?</span>
                                                <ChevronDownIcon class="-mr-1 ml-1 h-4 w-4" aria-hidden="true"/>
                                            </template>
                                            <template v-else-if="trainingSession.userIsParticipant">
                                                <CheckIcon class="-ml-1 mr-1 h-4 w-4" aria-hidden="true"/>
                                                <span>You trained</span>
                                            </template>
                                            <template v-else>
                                                <XIcon class="-ml-1 mr-1 h-4 w-4" aria-hidden="true"/>
                                                <span>You missed</span>
                                            </template>
                                        </MenuButton>
                                    </div>

                                    <transition enter-active-class="transition ease-out duration-100"
                                                enter-from-class="transform opacity-0 scale-95"
                                                enter-to-class="transform opacity-100 scale-100"
                                                leave-active-class="transition ease-in duration-75"
                                                leave-from-class="transform opacity-100 scale-100"
                                                leave-to-class="transform opacity-0 scale-95">
                                        <MenuItems
                                            class="origin-top-right absolute left-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none z-50">
                                            <div class="py-1">
                                                <MenuItem v-slot="{ active }">
                                                    <a href="#"
                                                       @click.prevent="setParticipated(trainingSession.id, true)"
                                                       :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'flex px-4 py-2 text-sm']">
                                                        <CheckIcon class="mr-3 h-5 w-5 text-gray-400"
                                                                   aria-hidden="true"/>
                                                        <span>Yes</span>
                                                    </a>
                                                </MenuItem>
                                                <MenuItem v-slot="{ active }">
                                                    <a href="#"
                                                       @click.prevent="setParticipated(trainingSession.id, false)"
                                                       :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'flex px-4 py-2 text-sm']">
                                                        <XIcon class="mr-3 h-5 w-5 text-gray-400" aria-hidden="true"/>
                                                        <span>No</span>
                                                    </a>
                                                </MenuItem>
                                            </div>
                                        </MenuItems>
                                    </transition>
                                </Menu>

                                <img v-for="participant in trainingSession.participantUsers"
                                     class="rounded-full object-cover mr-2"
                                     style="width: 1.75rem; height: 1.75rem;"
                                     :src="participant.profile_photo_url"
                                     :alt="participant.name"
                                     :title="participant.name"/>

                            </div>

                            <p class="mt-1 text-sm text-gray-500">
                                {{ trainingSession.typeHuman }}
                            </p>
                            <div v-if="trainingSession.notes" class="mt-2 text-base font-medium text-gray-900">
                                <p>{{ trainingSession.notes }}</p>
                            </div>
                        </div>
                        <div class="ml-4 mt-5 flex-shrink-0 flex">
                            <Menu as="div" class="relative inline-block text-left">
                                <div>
                                    <MenuButton
                                        class="-m-2 p-2 rounded-full flex items-center text-gray-400 hover:text-gray-600">
                                        <span class="sr-only">Open options</span>
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
                                                <Link :href="route('trainingSession.edit', trainingSession.id)"
                                                      :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'flex px-4 py-2 text-sm']">
                                                    <PencilIcon class="mr-3 h-5 w-5 text-gray-400"
                                                                aria-hidden="true"/>
                                                    <span>Edit training session</span>
                                                </Link>
                                            </MenuItem>
                                        </div>
                                    </MenuItems>
                                </transition>
                            </Menu>

                        </div>
                    </div>
                </div>

                <techniques :techniques="trainingSession.techniques"></techniques>
            </div>
        </div>
    </div>
</template>

<script>
import {defineComponent} from 'vue'
import {BellIcon, MenuIcon, XIcon} from "@heroicons/vue/outline";
import {
    ChatAltIcon,
    CheckIcon,
    ChevronDownIcon,
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
} from "@heroicons/vue/solid";
import {Menu, MenuButton, MenuItem, MenuItems, Popover, PopoverButton, PopoverPanel} from '@headlessui/vue'

import Techniques from "./Techniques";
import {Link} from "@inertiajs/inertia-vue3";
import {Inertia} from "@inertiajs/inertia";

export default defineComponent({
    props: ['trainingSessions'],

    components: {
        Link,
        Menu,
        MenuButton,
        MenuItem,
        MenuItems,
        Popover,
        PopoverButton,
        PopoverPanel,
        CheckIcon,
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
        ChevronDownIcon,
        Techniques
    },
    methods: {
        setParticipated(id, is_participant) {
            Inertia.post(route('trainingSession.participant', id),
                {is_participant: is_participant},
                {preserveScroll: true})
        },
        getParticipatedButtonClasses(userIsParticipant) {
            if (userIsParticipant === null) {
                return 'text-orange-600 bg-orange-200 hover:bg-orange-100'
            } else if (userIsParticipant) {
                return 'text-green-600 bg-green-200 hover:bg-green-100'
            } else {
                return 'text-pink-600 bg-pink-200 hover:bg-pink-100'
            }
        }
    }
})
</script>
