<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import navBar from '../../components/HomePage/navBar.vue';
import cardiacList from '@/components/Cardiac/cardiacListe.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Accueil">
        <link rel="preconnect" href="https://rsms.me/" />
        <link rel="stylesheet" href="https://rsms.me/inter/inter.css" />
    </Head>
    <navBar />
    <div>
        <Link :href="route('cardiac.form')">
            <button type="button">
                Créer un jeu
            </button>
        </Link>
    </div>
    <div class="flex min-h-screen flex-col items-center bg-[#FDFDFC] p-6 text-[#1b1b18] lg:justify-center lg:p-8 dark:bg-[#0a0a0a]">
        <header class="mb-6 w-full max-w-[335px] text-sm not-has-[nav]:hidden lg:max-w-4xl">
            <nav class="flex items-center justify-end gap-4">
                <cardiacList />
            </nav>
        </header>
    </div>
</template>
