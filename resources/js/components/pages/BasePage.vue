<script setup lang="ts">
import Navigation from "../layout/Navigation.vue";
import {ref} from 'vue';

const date = ref("" as string);

defineProps<{
    title: string
}>();

setInterval(() => {
    time()
}, 1000)

const time = () => date.value = new Date().toLocaleString();

</script>

<template>
    <Navigation/>

    <div>
        <main style="margin-left: 280px" class="p-3">
            <div class="d-flex justify-content-between align-items-center">
                <h2>{{ title }}</h2>
                <div>{{ date }}</div>
            </div>
            <hr>
            <slot/>
        </main>
    </div>
</template>
