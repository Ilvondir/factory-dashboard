<script setup lang="ts">
import BasePage from "@/components/pages/BasePage.vue";
import {User} from "@/models/user";
import {onMounted} from "vue";
import {Session} from "@/models/session";


const props = defineProps<{
    user: User,
    sessions: Session[]
}>();

onMounted(() => {
    console.log(props);
})
</script>

<template>
    <inertia-head>
        <title>Factory | Profile</title>
    </inertia-head>

    <BasePage title="Profile">

        <h4>Sessions</h4>

        <div class="overflow-x-scroll">
            <ul class="list-group">
                <li class="list-group-item" v-for="session in sessions">
                    <div class="d-flex align-items-center">

                        <div class="me-4">
                            <i class="bi bi-pc-display-horizontal" v-if="!session.user_agent.includes('Mobile')"></i>
                            <i class="bi bi-phone" v-else></i>
                        </div>

                        <div>
                            <h5>
                                {{ session.ip_address }} (Last activity:
                                {{ new Date(1000 * session.last_activity).toLocaleString() }})
                            </h5>
                            <p>
                                {{ session.user_agent }}
                            </p>
                        </div>

                    </div>

                </li>
            </ul>
        </div>
    </BasePage>
</template>

<style scoped>
.bi {
    color: rgb(var(--bs-primary-rgb));
    font-size: 250%;
}

p {
    margin: 0;
}
</style>
