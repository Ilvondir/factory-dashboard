<script setup lang="ts">
defineProps<{
    title: string,
    body: string,
    link: string
}>();
</script>

<template>
    <div class="col-12 col-md-6 col-lg-4 mt-3">
        <div class="self-card h-100 w-100">
            <h5>{{ title }}</h5>

            <hr class="mt-2 mb-3">

            <p class="card-text">
                {{ body }}
            </p>

            <inertia-link :href='link' class="btn btn-primary">{{ title }}</inertia-link>
        </div>
    </div>
</template>

<style scoped>
.self-card {
    transition: 1s;
    padding: .8vw;
    border: .1vmin solid #00000060;
    border-top: .6vw solid #0d6EFD;
    border-bottom: .3vw solid rgb(33, 37, 41);
    box-sizing: border-box;
    border-radius: 10px;
}

.self-card:hover {
    box-shadow: 0 0 13px #00000080;
    scale: 1.03;
}

hr {
    width: 100%
}
</style>
