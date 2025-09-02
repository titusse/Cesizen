<template>
    <form method="post" @submit.prevent="submit">
        <div style="display: flex; flex-direction: row;">
            <label for="name">Nom de l'exercice: </label>
            <input required type="text" name="name" id="name" v-model="form.name">
        </div>
        <div style="display: flex; flex-direction: row;">
            <label for="description">Description de l'exercice: </label>
            <input required type="text" name="description" id="description" v-model="form.description">
        </div>
        <div style="display: flex; flex-direction: row;">
            <label for="difficulty">Difficulté: </label>
            <select required name="difficulty" id="difficulty" v-model="form.difficulty">
                <option value="First">Première experience</option>
                <option value="Beginner" selected>Débutant</option>
                <option value="Advanced">Avancé</option>
                <option value="Expert">Expert</option>
                <option value="Master">Maitre</option>
            </select>
        </div>
        <button type="submit" :disabled="loading">
            {{ loading ? 'Envoi...' : 'Valider' }}
        </button>
        <p v-if="message" class="text-green-700">{{ message }}</p>
    </form>
</template>
<script setup lang="ts">

import { reactive, ref } from 'vue';
import axios from 'axios';

const form = reactive({
    name: '',
    description: '',
    difficulty: 'Beginner'
});

const loading = ref(false);
const message = ref('');

async function submit() {
    loading.value = true;
    console.log(form);
    try {
        const url = 'create';
        const { data } = await axios.post(url, form, {
            headers: { 'Accept': 'application/json'}
        });

        message.value = data?.message || 'Exercice créé avec succès.';
    } catch (e) {
        message.value = 'Quelque chose s\'est mal passé.' + e.response?.status;
    } finally {
        loading.value = true;
        window.location.href = '/cardiac/formulaireEtape';
    }
}
</script>