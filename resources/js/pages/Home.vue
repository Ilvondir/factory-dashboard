<script setup lang="ts">
import BasePage from "../components/pages/BasePage.vue";
import {usePage} from "@inertiajs/vue3";
import {User} from "@/models/user";

const page = usePage();

// @ts-ignore
const user: User = page.props.user;
</script>

<template>
    <inertia-head>
        <title>Home</title>
    </inertia-head>

    <BasePage title="Home">
        <div class="p-5 text-center bg-body-tertiary rounded-3">
            <h1 class="text-body-emphasis">Welcome, {{ user.first_name + " " + user.last_name }}!</h1>
            <p class="col-lg-9 mx-auto fs-5 text-muted">
                This is a factory management panel. Within this system, you can manage company resources, view
                application users and system change logs.
            </p>
        </div>
    </BasePage>


</template>
