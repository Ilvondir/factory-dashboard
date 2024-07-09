<script setup lang="ts">
import BasePage from "@/components/pages/BasePage.vue";
import {InputProduct, Product} from "@/models/product";
import {onMounted, ref} from "vue";
import {Pagination} from "@/models/pagination";
import Paginator from "@/components/layout/Paginator.vue";
import {router} from "@inertiajs/vue3";
import {Department} from "@/models/department";
import {Material} from "@/models/material";
import Multiselect from 'vue-multiselect';

const selectedProduct = ref({} as Product);
const productToCreate = ref(new InputProduct());
const options = ref([] as string[]);
const selected = ref([] as string[]);
const localErrors = ref({} as InputProduct);
const productToEdit = ref({} as Product);
const selectedProductOptions = ref([] as string[]);
const materialsIdsToUpdate = ref([] as number[]);
const departmentIdToUpdate = ref(0 as number);

const props = defineProps<{
    products: Pagination<Product>,
    canCreateProducts: boolean,
    canUpdateProducts: boolean[],
    canDeleteProducts: boolean[],
    departments: Department[],
    errors: InputProduct,
    materials: Material[]
}>();

const handleDelete = () => {
    router.delete(`/products/${selectedProduct.value.id}`, {
        preserveScroll: true,
        onSuccess: () => {
            selectedProduct.value = {} as Product;
        }
    });
}

const selectProduct = (p: Product) => {
    selectedProduct.value = p;
    productToEdit.value = {...p};
    departmentIdToUpdate.value = p.department.id;

    const tempTab: string[] = [];

    for (let i = 0; i < selectedProduct.value.materials.length; i++) {
        props.materials.forEach((m: Material) => {
            if (m.id === selectedProduct.value.materials[i].id) {
                tempTab.push(m.name);
            }
        });
    }

    selectedProductOptions.value = tempTab;
    changeNamesToIdsUpdate();
}

const changeNamesToIds = () => {
    const tempTab: number[] = [];

    for (let i = 0; i < selected.value.length; i++) {
        props.materials.forEach((m: Material) => {
            if (m.name === selected.value[i]) {
                tempTab.push(m.id);
            }
        });
    }

    productToCreate.value.materials_id = tempTab;
}

const changeNamesToIdsUpdate = () => {
    const tempTab: number[] = [];

    for (let i = 0; i < selectedProductOptions.value.length; i++) {
        props.materials.forEach((m: Material) => {
            if (m.name === selectedProductOptions.value[i]) {
                tempTab.push(m.id);
            }
        });
    }

    materialsIdsToUpdate.value = tempTab;
}

const handleCreate = () => {
    router.post("/products", productToCreate.value, {
        preserveScroll: true,
        onError: () => {
            localErrors.value = props.errors;
        },
        onSuccess: () => {
            localErrors.value = {} as InputProduct;
            productToCreate.value = new InputProduct();

            const closeButton = document.getElementById("closeCreateModal");
            if (closeButton) closeButton.click();

            const select = document.querySelector('#department');
            // @ts-ignore
            if (select) select.value = "-1";

            selected.value = [];
        }
    });
}


const handleUpdate = () => {
    router.put(`/products/${selectedProduct.value.id}`, {
        name: productToEdit.value.name,
        price: productToEdit.value.price,
        department_id: departmentIdToUpdate.value,
        materials_id: materialsIdsToUpdate.value
    }, {
        preserveScroll: true,
        onError: () => {
            localErrors.value = props.errors;
            console.log(selectedProduct.value);
        },
        onSuccess: () => {
            localErrors.value = {} as InputProduct;

            const closeButton = document.getElementById("closeUpdateModal");
            if (closeButton) closeButton.click();

            selectedProduct.value = {} as Product;
        }
    })
}

onMounted(() => {
    console.log(props);

    props.materials.forEach((m: Material) => {
        options.value.push(m.name)
    });
})
</script>

<template>
    <inertia-head>
        <title>Factory | Products</title>
    </inertia-head>

    <BasePage title="Products">

        <div class="row">
            <div class="col-12 col-lg-6">

                <div v-if="canCreateProducts" class="mb-3 ">
                    <button class="btn btn-primary"
                            data-bs-toggle="modal"
                            data-bs-target="#createModal"
                            @click="localErrors = {} as InputProduct">
                        <i class="bi bi-plus-lg"></i> Add new product
                    </button>
                </div>

                <div class="row">

                    <div class="col-6 mb-3" v-for="p in products.data">
                        <div class="card" style="cursor: pointer"
                             @click="() => selectProduct(p)">
                            <div class="card-body">
                                <h5 class="card-title">{{ p.name }}</h5>
                                <h6 class="card-subtitle" style="color: rgba(13, 110, 253, 0.7)">
                                    {{ p.department.name }}
                                </h6>
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

                            <h5 class="mb-4 text-primary">{{ selectedProduct.department.name }}</h5>

                            <h6>Materials:</h6>
                            <ul class="list-group">
                                <li class="list-group-item" v-for="material in selectedProduct.materials">
                                    {{ material.name }}
                                </li>

                            </ul>


                        </template>

                        <p v-else>
                            Select product from list.
                        </p>

                    </div>

                    <div class="card-footer">
                        <div class="text-end w-100">
                            <a :href="'products/' + selectedProduct.id + '/pdf'"
                               v-if="Object.keys(selectedProduct).length > 0"
                               class="btn btn-success me-2">
                                <i class="bi bi-filetype-pdf"></i> Download report
                            </a>

                            <button class="btn btn-primary me-1"
                                    v-if="canUpdateProducts[products.data.indexOf(selectedProduct)]"
                                    data-bs-toggle="modal" data-bs-target="#updateModal"
                                    @click="localErrors = {} as InputProduct">
                                <i class="bi bi-pen"></i> Edit
                            </button>

                            <button class="btn btn-danger ms-1"
                                    v-if="canDeleteProducts[products.data.indexOf(selectedProduct)]"
                                    data-bs-toggle="modal" data-bs-target="#deleteModal">
                                <i class="bi bi-trash"></i> Delete
                            </button>
                        </div>
                    </div>

                </div>

            </div>
        </div>

    </BasePage>


    <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Confirm decision</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete the <strong>{{ selectedProduct.name }}</strong> product?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" @click="handleDelete" class="btn btn-danger" data-bs-dismiss="modal">Delete
                        product
                    </button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Create new product</h1>
                    <button type="button" class="btn-close" id="closeCreateModal" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <form @submit.prevent="handleCreate">
                    <div class="modal-body">

                        <div class="mb-3">
                            <label for="title" class="form-label">Name:</label>
                            <input type="text" class="form-control" id="title" v-model="productToCreate.name"
                                   placeholder="Product name" required>
                        </div>

                        <div class="mb-3">
                            <label for="price" class="form-label">Price:</label>
                            <input type="number" class="form-control" min="0" step="0.01" id="price"
                                   v-model="productToCreate.price"
                                   placeholder="Product price" required>
                        </div>


                        <div class="mb-3">
                            <label for="department" class="form-label">Department:</label>
                            <select
                                class="form-select" id="department" required
                                @change="(event) => productToCreate.department_id = event.target ? event.target.selectedOptions[0].value : 0"
                            >
                                <option value="-1" disabled selected>Select department</option>
                                <option v-for="d in departments" :value="d.id">
                                    {{ d.name }}
                                </option>
                            </select>
                        </div>


                        <div class="mb-3" v-if="options.length > 0">
                            <label for="materials" class="form-label">Materials:</label>
                            <multiselect v-model="selected" :options="options"
                                         :searchable="true" :multiple="true" :close-on-select="false"
                                         placeholder="Select materials" id="materials"
                                         @select="()=>changeNamesToIds()">
                            </multiselect>
                        </div>


                        <div v-if="Object.keys(localErrors).length > 0"
                             class="alert-danger alert">
                            <ul class="m-0">
                                <li v-for="er in localErrors">
                                    {{ er }}
                                </li>
                            </ul>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">
                            Create product
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="updateModal" tabindex="-1" aria-hidden="true"
         v-if="Object.keys(selectedProduct).length > 0">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Edit product</h1>
                    <button type="button" class="btn-close" id="closeUpdateModal" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <form @submit.prevent="handleUpdate">
                    <div class="modal-body">

                        <div class="mb-3">
                            <label for="title" class="form-label">Name:</label>
                            <input type="text" class="form-control" id="title" v-model="productToEdit.name"
                                   placeholder="Product name" required>
                        </div>

                        <div class="mb-3">
                            <label for="price" class="form-label">Price:</label>
                            <input type="number" class="form-control" min="0" step="0.01" id="price"
                                   v-model="productToEdit.price"
                                   placeholder="Product price" required>
                        </div>


                        <div class="mb-3">
                            <label for="department2" class="form-label">Department:</label>
                            <select
                                class="form-select" id="department2" required
                                @change="(event) => departmentIdToUpdate = event.target ? event.target.selectedOptions[0].value : 0"
                            >
                                <option value="-1" disabled selected>Select department</option>
                                <option v-for="d in departments" :value="d.id"
                                        :selected="productToEdit.department.id === d.id"
                                >
                                    {{ d.name }}
                                </option>
                            </select>
                        </div>


                        <div class="mb-3" v-if="options.length > 0">
                            <label for="materials" class="form-label">Materials:</label>
                            <multiselect v-model="selectedProductOptions" :options="options"
                                         :searchable="true" :multiple="true" :close-on-select="false"
                                         placeholder="Select materials" id="materials"
                                         @select="() => changeNamesToIdsUpdate()">
                            </multiselect>
                        </div>


                        <div v-if="Object.keys(localErrors).length > 0"
                             class="alert-danger alert">
                            <ul class="m-0">
                                <li v-for="er in localErrors">
                                    {{ er }}
                                </li>
                            </ul>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">
                            Update product
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</template>

<style>
.multiselect__tag {
    background: #0d6efd !important;
}

.multiselect__tag-icon::after {
    color: white !important;
}
</style>
