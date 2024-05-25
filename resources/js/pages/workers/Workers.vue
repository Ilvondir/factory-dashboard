<script setup lang="ts">
import BasePage from "@/components/pages/BasePage.vue";
import {onMounted} from "vue";


const props = defineProps<{
    workers: Worker[]
}>();

onMounted(() => {
    console.log(props);
})
</script>

<template>
    <BasePage title="Workers">

    </BasePage>
</template>
