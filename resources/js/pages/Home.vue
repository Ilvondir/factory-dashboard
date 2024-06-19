<script setup lang="ts">
import BasePage from "../components/pages/BasePage.vue";
import {usePage} from "@inertiajs/vue3";
import {User} from "@/models/user";
import StandardBsCard from "../components/cards/StandardCard.vue";
import {onMounted} from "vue";
import {connectToLogs, getEcho, initializeEcho} from "@/echo";

const page = usePage();

// @ts-ignore
const user: User = page.props.user;

defineProps<{
    departments: number,
    positions: number,
    workers: number,
    materials: number,
    products: number,
    users: number,
    logs: number,
}>();

onMounted(() => {
})
</script>

<template>
    <inertia-head>
        <title>Factory | Home</title>
    </inertia-head>

    <BasePage title="Home">
        <div class="p-5 text-center bg-body-tertiary rounded-3 jumbotron">
            <h1 class="text-body-emphasis">Welcome, {{ user.first_name + " " + user.last_name }}!</h1>
            <p class="col-lg-9 mx-auto fs-5 text-muted">
                This is a factory management panel. Within this system, you can manage company resources, view
                application users and system change logs.
            </p>
        </div>

        <div class="row d-flex justify-content-center">

            <standard-bs-card title="Departments" :link="'/departments'"
                              :body="'The manufactory is divided into ' + departments + ' departments.'"></standard-bs-card>

            <standard-bs-card title="Positions" link="/positions"
                              :body="'There are ' + positions + ' positions created in ' + departments + ' departments.'"></standard-bs-card>

            <standard-bs-card title="Workers" link="/workers"
                              :body="'There are ' + workers + ' employees employed in the factory.'"></standard-bs-card>

            <standard-bs-card title="Materials" link="/materials"
                              :body="'Factory warehouses have ' + materials + ' production materials.'"></standard-bs-card>

            <standard-bs-card title="Products" link="/products"
                              :body="'The factory produces ' + products + ' kinds of products.'"></standard-bs-card>

            <standard-bs-card title="System users" link="/users"
                              :body="'Only registered users have access to the system. There are currently ' + users + ' of them.'"></standard-bs-card>

            <standard-bs-card title="System logs" link="/logs"
                              :body="'The system saves logs of operations performed by users. There are currently ' + logs + ' logs saved.'"></standard-bs-card>

        </div>

    </BasePage>
</template>

<style scoped>
.jumbotron {
    animation-name: animate;
    animation-duration: 4s;
    animation-iteration-count: infinite;
    animation-direction: alternate;
}

@keyframes animate {
    0% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.015);
    }
    100% {
        transform: scale(1);
    }
}
</style>
