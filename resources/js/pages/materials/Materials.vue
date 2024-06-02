<script setup lang="ts">
import BasePage from "@/components/pages/BasePage.vue";
import {Material} from "@/models/material";
import {onMounted} from "vue";

const props = defineProps<{
    materials: Material[],
    canCreateMaterials: boolean,
    canUpdateMaterials: boolean[],
    canDeleteMaterials: boolean[]
}>();

onMounted(() => {
    console.log(props);
});
</script>

<template>
    <inertia-head>
        <title>Factory | Materials</title>
    </inertia-head>


    <BasePage title="Materials">

        <p>
            Welcome to the factory warehouse, where efficiency meets organization. Our warehouse is the heart of our
            operations, storing a diverse range of materials essential for production. From raw materials like steel and
            plastics to finished products awaiting distribution, our shelves are stocked with everything needed to keep
            our assembly lines running smoothly. Upon entering our warehouse, you'll encounter a well-structured layout
            designed for easy navigation. Each section is meticulously labeled and organized, ensuring that every item
            has its designated place. This meticulous organization not only facilitates efficient inventory management
            but also minimizes the time spent searching for specific materials.
        </p>

        <p v-if="canUpdateMaterials.includes(true)">
            <strong>Material can only be removed if no product uses it.</strong>
        </p>

    </BasePage>
</template>
