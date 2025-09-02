<template>
    <div v-if="isStart.valeur == false">
        <button v-on:click="setAllItemFalse()">
            Démarrer
        </button>
    </div>
    <div v-else>
        <circle-progress :percent="advancement.valeur">
            
        </circle-progress>
        {{ timer.valeur }}
        <div v-for="item in cardiac.cardiac_item" v-bind:key="item.id">
            <div v-if="isShown.valeur[item.index]">
                {{ item.type }}
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
import "vue3-circle-progress/dist/circle-progress.css";
import CircleProgress from "vue3-circle-progress";
import { reactive, ref, onMounted } from 'vue';
import axios from 'axios';

const isStart = reactive({
    valeur: false
});

const timer = reactive({
    valeur: 0
});

const advancement = reactive({
    valeur: 0
});

const cardiac = ref({
    id: '',
    name: '',
    description: '',
    cardiac_item: []
});

const isShown = reactive({
    valeur: []
});

onMounted(async () => {
    try {
        const url = window.location.pathname;
        let actualUrl = url.split('').reverse().join('');
        let id = '';
        while(actualUrl[0] != '/') {
            id += actualUrl[0];
            actualUrl = actualUrl.substring(1);
            console.log('id: ' + id + '/Url: '+ actualUrl);
        }
        cardiac.value.id = id.split('').reverse('').join('');
        const { data } = await axios.get('/cardiac/getLinkCardiacItem/'+cardiac.value.id , {
            headers: { 'Accept' : 'application/json'}
        });
        console.log(data);
        cardiac.value = data;
    } catch (e) {
        console.error(e);
    }
})

function setAllItemFalse() {
    for(let index = 0; index < cardiac.value.cardiac_item.length; index++){
        isShown.valeur[index] = false;
        cardiac.value.cardiac_item[index].index = index;
    }
    isStart.valeur = true;
    setTiming();
}

function setTiming() {
    let actualDuration = 0;
    let sound = ''
    for(let index = 0; index < cardiac.value.cardiac_item.length; index++){
        if(cardiac.value.cardiac_item[index].type == 'Inspire') {
            sound = 'Inspirer';
        } else if(cardiac.value.cardiac_item[index].type == 'Hold') {
            sound = 'Retenir';
        } else if(cardiac.value.cardiac_item[index].type == 'Expire') {
            sound = 'Expirer';
        }
        playSound(sound, actualDuration);
        setTimeout(() => {
            isShown.valeur[index] = true;
        }, actualDuration*1000);
        setWheelTiming(cardiac.value.cardiac_item[index].duration,actualDuration);
        actualDuration += cardiac.value.cardiac_item[index].duration;
        console.log(actualDuration);
        setTimeout(() => {
            isShown.valeur[index] = false;
        }, actualDuration*1000);
    }
}

function setWheelTiming(duration, gap)
{
    for(let index = 0; index < duration; index++) {
        setTimeout(() => {
            advancement.valeur = index/duration*100;
        }, (gap+index)*1000);
        console.log((index/duration)*100);
    }
    setTimeout(() => {
        advancement.valeur = 0;
        setTimer(duration, gap);
    }, (gap+duration)*1000);
}

function setTimer(duration, gap)
{
    setTimeout(() => {
            timer.valeur = duration;
        }, (gap)*1000);
    for(let index = 1; index < duration; index++) {
        setTimeout(() => {
            timer.valeur--;
        }, (gap+index)*1000);
    }
}

function playSound(sound, timing) {
    console.log(sound);
    const number = Math.floor(Math.random() * 3);
    const link = '/sounds/' + sound + number+'.mp3';
    const audio = new Audio(link);
    setTimeout(() => {
        audio.play();
    }, timing*1000);
}
</script>