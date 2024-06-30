<script setup lang="ts">
import BasePage from "@/components/pages/BasePage.vue";
import {Product} from "@/models/product";
import {onMounted, ref} from "vue";
import {InputWorker} from "@/models/worker";
import {Pagination} from "@/models/pagination";
import Paginator from "@/components/layout/Paginator.vue";

const selectedProduct = ref({} as Product);

const props = defineProps<{
    products: Pagination<Product>
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

                    <div class="col-6 mb-3" v-for="p in products.data">
                        <div class="card" style="cursor: pointer" @click="selectedProduct = p">
                            <div class="card-body">
                                <h5 class="card-title">{{ p.name }}</h5>
                                <h6 class="card-subtitle" style="opacity: 0.7">{{ p.department.name }}</h6>
                                <p class="card-text mt-2">{{ p.price }} PLN</p>
                            </div>
                        </div>

                    </div>
                </div>

                <Paginator :items="products"/>


            </div>


            <div class="col-12 col-lg-6">

                <div class="card h-100">

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

                            <div class="text-end w-100 mt-3">
                                <button class="btn btn-primary me-1" v-if="true"
                                        data-bs-toggle="modal" data-bs-target="#updateModal"
                                        @click="() => {}">
                                    <i class="bi bi-pen"></i> Edit
                                </button>

                                <button class="btn btn-danger ms-1" v-if="true"
                                        data-bs-toggle="modal" data-bs-target="#deleteModal">
                                    <i class="bi bi-trash"></i> Delete
                                </button>
                            </div>
                        </template>

                        <p v-else>
                            Select product from list.
                        </p>

                    </div>

                    <div class="card-footer"></div>

                </div>

            </div>
        </div>

    </BasePage>
</template>
