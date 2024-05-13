<script setup>

import Navigation from "../layout/Navigation.vue";
</script>

<template>
    <Navigation/>

    <div class="pusher">
        <main style="margin-left: 280px">
            <slot></slot>
        </main>
    </div>
</template>
