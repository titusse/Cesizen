 <template>
    <div style="display: flex; flex-direction: column;">
        <div style="display: flex; flex-direction: column; background-color: greenyellow;">
            <p>
                Informations du questionnaires: 
            </p>
            <ul>
                <li>
                    Nom: {{ cardiac.name }}
                </li>
                <li>
                    Description: {{ cardiac.description }}
                </li>
                <li>
                    Difficulté: {{ cardiac.difficulty }}
                </li>
            </ul>
        </div>

        <label for="steps">Nombre d'étape</label>
        <div style="display: flex; flex-direction: row;">
            <button type="button" style="background-color: green; font-size: large;" v-on:click="addSteps()">+</button>
            <button type="button" style="background-color: red; font-size: large;" v-on:click="removeSteps()">-</button>
        </div>
        <form method="post" @submit.prevent="submit">
            <div v-for="index in step.steps" v-bind:key="index" style="display: flex; flex-wrap: wrap; flex-direction: row;">
                <h3>étape n°{{ index }}</h3>
                <div style="display: flex; flex-direction: row;">
                    <label for="name">Nom: </label>
                    <input required type="text" name="name" id="name" v-model="form[index-1].name">
                </div>
                <div style="display: flex; flex-direction: row;">
                    <label for="type">Type: </label>
                    <select required name="type" id="type" v-model="form[index-1].type">
                        <option value="Inspire">Inspirer</option>
                        <option value="Hold">Retenir</option>
                        <option value="Expire">Expirer</option>    
                    </select>
                </div>
                <div style="display: flex; flex-direction: row;">
                    <label for="duration">Durée: </label>
                    <input required type="number" name="duration" id="duration" v-model="form[index-1].duration">
                </div>
            </div>
            <button type="submit" :disabled="loading">
                {{ loading ? 'Envoi...' : 'Valider' }}
            </button>
            <p v-if="message" class="text-green-700">{{ message }}</p>
        </form>
    </div>
 </template>
 <script setup lang="ts">
import { reactive, ref, onMounted } from 'vue';
import axios from 'axios';

const cardiac = ref({
    id: 0,
    name: '',
    description: '',
    difficulty: ''
});

const step = reactive({
    steps: 0
});

const form = reactive([{
    name: '',
    type: '',
    duration: 0,
    cardiac_id: cardiac.value.id
}]);

const loading = ref(false);
const message = ref('');

function addSteps() {
    step.steps += 1;
    reDefineForm();
}

function removeSteps() {
    step.steps -= 1;
    reDefineForm();
}

async function reDefineForm() {
    if (form[step.steps] != undefined) {
        form[step.steps].name = '';
        form[step.steps].type = '';
        form[step.steps].duration = 0;
        form[step.steps].cardiac_id = cardiac.value.id;
    }
    else if (form[step.steps-1] == undefined) {
        const temp = {
            name: '',
            type: '',
            duration: 0,
            cardiac_id: cardiac.value.id
        };
        form[step.steps-1] = temp;
    }
}

onMounted(async () => {
    try {
        const { data } = await axios.get('/cardiac/getLast', {
            headers: { 'Accept' : 'application/json'}
        });
        console.log(data);
        cardiac.value = data;
    } catch (e) {
        console.error(e);
    }
})

async function submit() {
    loading.value = true;
    console.log(form);
    for(let index = 0; index < form.length; index++)
    {
        form[index].cardiac_id = cardiac.value.id;
    }
    try {
        const url = 'createItem';
        const { data } = await axios.post(url, form, {
            headers: { 'Accept': 'application/json'}
        });

        message.value = data?.message || 'Item créé avec succès.';
    } catch (e) {
        message.value = 'Quelque chose s\'est mal passé.' + e.response?.status;
    } finally {
        loading.value = true;
        window.location.href = '/cardiac/liste';
    }
}
</script>