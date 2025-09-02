<script setup lang="ts">
    import { Link } from '@inertiajs/vue3';
</script>
<template>
    <div style="width: 100%; 
                height:4em; 
                background-color: green;
                display: flex;
                justify-content: space-between;">
        <div>
            <img src="/images/historicPicto.png"
                alt="Historique"
                style="height: 90%;"> 
        </div>
        <div>
            <Link :href="route('home')">
                <img src="/images/logo.png"
                    alt="Accueil"
                    style=" height: 90%; 
                    margin-left: 2%;">
            </Link>
        </div>
        <div style="display: flex;
                    justify-content: space-around;
                    margin-right: 2%;">
            <Link
                v-if="!$page.props.auth.user"
                :href="route('login')"
                style=" background-color: whitesmoke;
                        border-color: black;
                        border-radius: 15px;
                        margin-right: 10%;
                        margin-bottom: 1em;
                        margin-top: 1em;
                        padding-left: 0.5em;
                        padding-right: 0.5em;
                        display: flex;
                        justify-content: center;
                        align-items: center;">
                <p>
                    Connexion
                </p>
            </Link>
            <Link
                v-if="!$page.props.auth.user"
                :href="route('register')"                
                style=" background-color: whitesmoke;
                        border-color: black;
                        border-radius: 15px;
                        margin-bottom: 1em;
                        margin-top: 1em;
                        padding-left: 0.5em;
                        padding-right: 0.5em;
                        display: flex;
                        justify-content: center;
                        align-items: center;">
                <p>
                    Inscription
                </p>
            </Link>
        </div>
    </div>

</template>