<script setup lang="ts">
import Navigation from "../layout/Navigation.vue";
import {ref} from 'vue';

const date = ref(new Date().toLocaleTimeString() + "<br>" + new Date().toLocaleDateString() as string);

defineProps<{
    title: string
}>();

setInterval(() => {
    time()
}, 1000)

const time = () => date.value = new Date().toLocaleTimeString() + "<br>" + new Date().toLocaleDateString();

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
h2 {
    transition: 1s;
}

h2:hover {
    letter-spacing: 0.5px;
}
</style>
