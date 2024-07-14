<script setup lang="ts">
import Navigation from "../layout/Navigation.vue";
import {onMounted, ref} from 'vue';
import Echo from "laravel-echo";

const date = ref(new Date().toLocaleTimeString() + "<br>" + new Date().toLocaleDateString() as string);

defineProps<{
    title: string
}>();

setInterval(() => {
    time()
}, 1000)
const time = () => date.value = new Date().toLocaleTimeString() + "<br>" + new Date().toLocaleDateString();

onMounted(() => {
    // Echo.channel('test')
    //     .listen('message', (event: any) => {
    //         console.log('Log created:', event.log);
    //         // Możesz tutaj dodać kod, który wyświetli powiadomienie użytkownikom
    //     });
})

</script>

<template>
    <Navigation/>

    <div>
        <main style="margin-left: 280px" class="p-4">
            <div class="d-flex justify-content-between align-items-center">
                <h2>{{ title }}</h2>
                <div v-html="date" class="text-end"></div>
            </div>
            <hr>
            <slot/>
        </main>
    </div>
</template>

<style scoped>
h2, .text-end {
    transition: 0.8s;
}

h2:hover, .text-end:hover {
    letter-spacing: 0.5px;
}

</style>
