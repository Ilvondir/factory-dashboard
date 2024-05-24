<script setup lang="ts">
defineProps<{
    title: string,
    body: string,
    link: string
}>();
</script>

<template>
    <div class="col-12 col-md-6 col-lg-4">
        <div class="card w-100 mt-3">
            <div class="card-header">
                <h5 class="m-0">{{ title }}</h5>
            </div>
            <div class="card-body">
                <p class="card-text">
                    {{ body }}
                </p>
                <inertia-link :href='link' class="btn btn-primary">{{ title }}</inertia-link>
            </div>
        </div>
    </div>
</template>

<style scoped>
.card {
    transition: 1s;
    box-shadow: 0 0 5px #00000040;
}

.card:hover {
    box-shadow: 0 0 13px #00000080;
    scale: 1.03;
}
</style>
