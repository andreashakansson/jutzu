<template>
    <app-layout title="Guide">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Guide
            </h2>
        </template>

        <div class="py-10">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mb-2">
                <div class="text-2xl">
                    Lägg till träningspass med tekniker
                </div>
                <p class="mt-4">1. Gå till
                    <a href="https://www.youtube.com/" target="_blank" class="underline">
                        Youtube
                    </a> och hitta en video som passar tekniken som tränades så bra som möjligt.</p>
                <p class="mt-4">2. Pausa videon där tekniken börjar så vi slipper förpratet och tekniken visas
                    direkt.</p>
                <p class="mt-4">3. Klicka på Dela/Share:</p>
                <img class="mt-2" src="/img/guide/1.png" style="max-width:800px;"/>
                <p class="mt-4">4. Klicka i "Starta vid: x" för att få videon att starta där du
                    pausat:</p>
                <img class="mt-4" src="/img/guide/2.png" style="max-width:500px;"/>
                <p class="mt-4">5. Klicka på "Kopiera"</p>
                <img class="mt-4" src="/img/guide/3.png" style="max-width:500px;"/>
                <p class="mt-4">6. Klicka sedan på "Nytt träningspass" uppe i högerhörnet när du är inloggad på
                    <a href="/" target="_blank" class="underline">Jutzu</a>.</p>
                <p class="mt-4">7. Fyll i information om första tekniken. Klistra in Youtube-länken du kopierade i steg
                    5.</p>
                <p class="mt-4">8. Klicka på "+ Teknik" och lägga till hur många tekniker du vill.</p>
                <p class="mt-4">9. Klicka på "Spara träningspass" så dyker passet upp på förstasidan.</p>

            </div>

        </div>
    </app-layout>
</template>

<script>
import {defineComponent} from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import {Head} from '@inertiajs/inertia-vue3';
import JetAuthenticationCardLogo from '@/Jetstream/AuthenticationCardLogo.vue'

export default defineComponent({
    components: {
        AppLayout,
        Head,
        JetAuthenticationCardLogo,
    },
})
</script>
