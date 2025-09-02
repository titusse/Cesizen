<script setup lang="ts">
    import { Link } from '@inertiajs/vue3';
</script>
<template>
    <div>
        <Link :href="route('cardiac.liste')">
            <img src="/images/cardiacPicto.png"
                alt="Historique"
                style="height: 90%;"> 
        </Link>
    </div>
</template>