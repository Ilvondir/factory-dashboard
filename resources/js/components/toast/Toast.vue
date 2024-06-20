<script setup lang="ts">
import {User} from "@/models/user";

const emit = defineEmits(['closeToast']);

defineProps<{
    operation: string,
    user: User,
    toastId: number,
}>();
</script>

<template>
    <p style="font-weight: 700">{{ user.first_name }} {{ user.last_name }} ({{ user.email }})</p>
    <p>
        {{ operation }}
    </p>
</template>

<style scoped>
p {
    margin: 0;
}
</style>
