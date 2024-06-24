<script setup lang="ts">
import BasePage from "@/components/pages/BasePage.vue";
import {Product} from "@/models/product";

defineProps<{
    products: Product[]
}>();
</script>

<template>
    <inertia-head>
        <title>Factory | Products</title>
    </inertia-head>
    <BasePage title="Products">

        <div class="row">
            <div class="col-12 col-lg-6">
                <p v-for="p in products">
                    {{ p.name }}
                </p>
            </div>

            <div class="col-12 col-lg-6">

                <div class="card">

                    <div class="card-header">
                        Product
                    </div>

                    <div class="card-body">


                    </div>

                    <div class="card-footer"></div>

                </div>

            </div>
        </div>

    </BasePage>
</template>
