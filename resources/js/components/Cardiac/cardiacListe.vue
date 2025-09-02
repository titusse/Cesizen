<template>
    <div v-if="loading.isEnd">
        <table>
            <tr>
                <th class="p-2 border">Nom</th>
                <th class="p-2 border">Description</th>
                <th class="p-2 border">Difficulté</th>
                <th class="p-2 border">Nombre d'étape</th>
                <th class="p-2 border">Durée</th>
            </tr>
            <tr v-for="data in cardiac" :key="data.id">
                <Link :href="route('cardiac.exercice', data.id)">
                    <td class="p-2 border">{{ data.name }}</td>
                </Link>     
                <td class="p-2 border">{{ data.description }}</td>
                <td class="p-2 border">{{ data.difficulty }}</td>
                <td class="p-2 border">{{ data.cardiac_item.length }}</td>
                <td class="p-2 border">{{ calculateDuration(data.cardiac_item) }}</td>       
            </tr>
        </table>
    </div>
    <div v-else>
        <circle-progress :percent="loading.valeur"></circle-progress>
    </div>
</template>

<script setup lang="ts">
import { reactive, ref, onMounted } from 'vue'
import { Link } from '@inertiajs/vue3';
import CircleProgress from "vue3-circle-progress";
import axios from 'axios'

const cardiac = ref([]);
const loading = reactive({
    valeur: 0,
    isEnd: false
});

onMounted(async () => {
    try {
        const {data} = await axios.get('/cardiac/getAll', {
            headers: {'Accept' : 'application/json'}
        });
        cardiac.value = data;
        cardiac.value.forEach((item) => {
            getCardiacItem(item);
        })
    } catch(e) {
        console.error(e);
    } finally {
        loading.isEnd = true;
    }
})

function calculateDuration(stepList) {
    let counter = 0;
    stepList.forEach((item) => {
        counter += item.duration;
    });
    return counter;
}

async function getCardiacItem(cardiac) {
    try {
        const { data } = await axios.get('/cardiac/getLinkCardiacItem/'+ cardiac.id, {
            headers: {'Accept' : 'application/json'}
        });
        cardiac.cardiac_item = data.cardiac_item;
        console.log(data);
    } catch(e) {
        console.error(e);
    }
}

</script>