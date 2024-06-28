<script setup lang="ts">
import BasePage from "@/components/pages/BasePage.vue";
import {Product} from "@/models/product";
import {onMounted, ref} from "vue";

const selectedProduct = ref({} as Product);

const props = defineProps<{
    products: Product[]
}>();

onMounted(() => {
    console.log(props)
})
</script>

<template>
    <inertia-head>
        <title>Factory | Products</title>
    </inertia-head>
    <BasePage title="Products">

        <div class="row">
            <div class="col-12 col-lg-6">

                <div class="row">

                    <div class="col-6 mb-3" v-for="p in products">
                        <div class="card" style="cursor: pointer" @click="selectedProduct = p">
                            <div class="card-body">
                                <h5 class="card-title">{{ p.name }}</h5>
                                <h6 class="card-subtitle" style="opacity: 0.7">{{ p.department.name }}</h6>
                                <p class="card-text mt-2">{{ p.price }} PLN</p>
                            </div>
                        </div>

                    </div>
                </div>


            </div>


            <div class="col-12 col-lg-6">

                <div class="card">

                    <div class="card-header">
                        Product
                    </div>

                    <div class="card-body">

                        <template v-if="Object.keys(selectedProduct).length > 0">

                            <h1>{{ selectedProduct.name }}</h1>

                            <h5>{{ selectedProduct.price }} PLN</h5>

                            <h5 class="mb-4">{{ selectedProduct.department.name }}</h5>

                            <h6>Materials:</h6>
                            <ul class="list-group">
                                <li class="list-group-item" v-for="material in selectedProduct.materials">
                                    {{ material.name }}
                                </li>

                            </ul>

                        </template>

                    </div>

                    <div class="card-footer"></div>

                </div>

            </div>
        </div>

    </BasePage>
</template>
