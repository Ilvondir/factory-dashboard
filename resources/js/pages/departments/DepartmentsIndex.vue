<script setup lang="ts">

import {Department} from "@/models/department";
import BasePage from "@/components/pages/BasePage.vue";

defineProps<{
    departments: Department[]
    positionsCounts: number[]
}>();
</script>

<template>
    <inertia-head>
        <title>Departments</title>
    </inertia-head>

    <BasePage title="Departments">
        <ul>
            <li v-for="(item, index) in departments">{{ item.name }} :: {{ positionsCounts[index] }} positions</li>
        </ul>
    </BasePage>
</template>
