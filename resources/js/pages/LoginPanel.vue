<script setup lang="ts">

import {ref} from "vue";
import {InputLoginCredentials, LoginCredentials} from "@/models/loginCredentials";
import {router} from "@inertiajs/vue3";

const credentials = ref(new InputLoginCredentials() as LoginCredentials);

const submit = () => {
    router.post("/login", credentials.value);
}

defineProps<{
    errors: LoginCredentials
}>();

</script>

<template>
    <inertia-head>
        <title>Login</title>
    </inertia-head>

    <div class="col-12 col-md-4 offset-md-4 mt-5">
        <main class="form-signin w-100 m-auto">
            <form @submit.prevent="submit">
                <h1 class="h3 mb-3 fw-normal">Please login</h1>

                <div class="form-floating">
                    <input v-model="credentials.email" type="email" class="form-control" id="floatingInput"
                           placeholder="name@example.com" required>
                    <label for="floatingInput">Email address</label>
                </div>
                <div class="form-floating mt-3">
                    <input type="password" v-model="credentials.password" class="form-control" id="floatingPassword"
                           placeholder="Password" required>
                    <label for="floatingPassword">Password</label>
                </div>

                <div v-if="errors.email || errors.password || errors.error" class="alert-danger alert mt-3 mb-0">
                    <ul class="m-0">
                        <li v-for="er in errors">
                            {{ er }}
                        </li>
                    </ul>
                </div>

                <button class="btn btn-primary w-100 py-2 mt-4" type="submit">Login</button>
                <p class="mt-5 mb-3 text-body-secondary">© Factory Dashboard 2024</p>
            </form>
        </main>
    </div>
</template>
