<script setup lang="ts">
import {router, usePage} from "@inertiajs/vue3";
import {User} from "@/models/user";
import {onMounted, ref} from "vue";

const page = usePage();

// @ts-ignore
const user: User = page.props.user;

const manufactoryShow = ref("show" as string);
const systemShow = ref("show" as string);

const changeStateManufactory = () => {
    if (localStorage.getItem("manufactoryShow") === "") localStorage.setItem('manufactoryShow', "show")
    else localStorage.setItem('manufactoryShow', "");
}

const changeStateSystem = () => {
    if (localStorage.getItem("systemShow") === "") localStorage.setItem('systemShow', "show")
    else localStorage.setItem('systemShow', "");
}

const logout = () => {
    router.post("/logout");
}

onMounted(() => {
    const savedManufactoryShow = localStorage.getItem('manufactoryShow');
    if (savedManufactoryShow != null) {
        manufactoryShow.value = savedManufactoryShow;
    }

    const savedSystemShow = localStorage.getItem('systemShow');
    if (savedSystemShow != null) {
        systemShow.value = savedSystemShow;
    }
});

</script>

<template>
    <div class="d-flex flex-column flex-shrink-0 p-3 text-bg-dark" style="width: 280px; position:fixed; height: 100vh">
        <inertia-link href="/home"
                      class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
            <span class="fs-3"><i class="bi-buildings-fill"></i> Factory</span>
        </inertia-link>
        <hr>
        <ul class="nav nav-pills flex-column mb-auto">

            <li class="mb-1 nav-item">
                <inertia-link href="/home" class="btn btn-toggle align-items-center rounded text-white fs-5 move">
                    <i class="bi-house"></i> Home
                </inertia-link>
            </li>

            <li class="mb-1 nav-item">
                <a class="btn btn-toggle align-items-center rounded text-white fs-5" data-bs-toggle="collapse"
                   data-bs-target="#manufactory-collapse" aria-expanded="true" @click="changeStateManufactory">
                    <i class="bi-gear"></i> Manufactory
                </a>
                <div :class="'collapse ' + manufactoryShow" id="manufactory-collapse" style="padding-left: 15px">
                    <ul class="m-0 p-0" style="list-style-type: none">
                        <li class="nav-item">
                            <inertia-link href="/departments" class="nav-link text-white" aria-current="page">
                                <i class="bi-building"></i> Departments
                            </inertia-link>
                        </li>
                        <li class="nav-item">
                            <inertia-link href="/positions" class="nav-link text-white" aria-current="page">
                                <i class="bi-journal-bookmark"></i> Positions
                            </inertia-link>
                        </li>
                        <li class="nav-item">
                            <inertia-link href="/workers" class="nav-link text-white" aria-current="page">
                                <i class="bi-people"></i> Workers
                            </inertia-link>
                        </li>
                        <li>
                            <inertia-link href="/materials" class="nav-link text-white">
                                <i class="bi-box-seam"></i> Materials
                            </inertia-link>
                        </li>
                        <li>
                            <inertia-link href="#" class="nav-link text-white">
                                <i class="bi-file-bar-graph"></i> Products
                            </inertia-link>
                        </li>
                    </ul>
                </div>
            </li>


            <li class="mb-1 nav-item">
                <a class="btn btn-toggle align-items-center rounded text-white fs-5" data-bs-toggle="collapse"
                   data-bs-target="#system-collapse" aria-expanded="true" @click="changeStateSystem">
                    <i class="bi-device-ssd"></i> System
                </a>
                <div :class="'collapse ' + systemShow" id="system-collapse" style="padding-left: 15px">
                    <ul class="m-0 p-0" style="list-style-type: none">
                        <li class="nav-item">
                            <inertia-link href="/users" class="nav-link text-white" aria-current="page">
                                <i class="bi-file-earmark-person"></i> Users
                            </inertia-link>
                        </li>
                        <li>
                            <inertia-link href="/logs" class="nav-link text-white">
                                <i class="bi-list-columns-reverse"></i> Logs
                            </inertia-link>
                        </li>
                    </ul>
                </div>
            </li>

        </ul>
        <hr>
        <div class="dropdown">
            <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle"
               id="dropdown-user" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="bi bi-person display-6"></i>

                <strong>{{ user.first_name + " " + user.last_name }}</strong>
            </a>
            <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdown-user">
                <li class="dropdown-item">You are <strong>{{ user.role.name }}</strong>.</li>
                <li>
                    <hr class="dropdown-divider">
                </li>
                <li>
                    <form @submit.prevent="logout">
                        <input type="submit" class="dropdown-item" value="Logout">
                    </form>
                </li>
            </ul>
        </div>
    </div>
</template>

<style scoped>
.nav-link, .move {
    transition: 0.5s;
}

.nav-link:hover, .move:hover {
    margin-left: 10px;
}
</style>
