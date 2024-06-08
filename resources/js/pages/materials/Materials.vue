<script setup lang="ts">
import BasePage from "@/components/pages/BasePage.vue";
import {type Material, InputMaterial} from "@/models/material";
import {onMounted, ref} from "vue";
import {router} from "@inertiajs/vue3";
import {Pagination} from "@/models/pagination";
import Paginator from "@/components/layout/Paginator.vue";
import {useToast} from "vue-toastification";

const toast = useToast();

const materialToDelete = ref({} as Material);
const materialToCreate = ref(new InputMaterial() as InputMaterial);
const materialToEdit = ref({} as Material);
const localErrors = ref({} as InputMaterial | Object);
const value = ref(0 as number);

const props = defineProps<{
    materials: Pagination<Material>,
    canCreateMaterials: boolean,
    canUpdateMaterials: boolean[],
    canDeleteMaterials: boolean[],
    canChangeAmount: boolean,
    errors: InputMaterial
}>();

const handleDelete = () => {
    router.delete(`/materials/${materialToDelete.value.id}`, {
        preserveScroll: true,
        onSuccess: () => {
            toast.error(`Successfully ${materialToDelete.value.name} deleted!`, {
                icon: false
            });
        }
    });
}

const handleCreate = () => {
    router.post("/materials", materialToCreate.value, {
        preserveScroll: true,
        onSuccess: () => {
            localErrors.value = {};
            const closeButton = document.getElementById("closeCreateModal");
            if (closeButton) closeButton.click();

            toast.success(`Successfully ${materialToCreate.value.name} created!`, {
                icon: false
            });

            materialToCreate.value = new InputMaterial();
        },
        onError: () => {
            localErrors.value = props.errors
        }
    })
}

const handleUpdate = () => {
    router.put(`/materials/${materialToEdit.value.id}`, {
        name: materialToEdit.value.name
    }, {
        preserveScroll: true,
        onSuccess: () => {
            localErrors.value = {};
            const closeButton = document.getElementById("closeUpdateModal");
            if (closeButton) closeButton.click();

            toast.info(`Successfully ${materialToEdit.value.name} updated!`, {
                icon: false
            });
        },
        onError: () => {
            localErrors.value = props.errors
        }
    })
}

const handleAddAmount = () => {
    router.put(`/materials/${materialToEdit.value.id}/add-amount`, {"value": value.value}, {
        preserveScroll: true,
        onSuccess: () => {
            const closeButton = document.getElementById("closeAddAmountModal");
            if (closeButton) closeButton.click();

            toast.warning(`Successfully ${value.value} item of ${materialToEdit.value.name} added!`, {
                icon: false
            });
        }
    })
}

const handleRemoveAmount = () => {
    router.put(`/materials/${materialToEdit.value.id}/remove-amount`, {"value": value.value}, {
        preserveScroll: true,
        onSuccess: () => {
            const closeButton = document.getElementById("closeRemoveAmountModal");
            if (closeButton) closeButton.click();

            toast.warning(`Successfully ${value.value} item of ${materialToEdit.value.name} removed!`, {
                icon: false
            });
        }
    })
}

onMounted(() => {
    console.log(props);
});
</script>

<template>
    <inertia-head>
        <title>Factory | Materials</title>
    </inertia-head>


    <BasePage title="Materials">

        <p>
            Welcome to the factory warehouse, where efficiency meets organization. Our warehouse is the heart of our
            operations, storing a diverse range of materials essential for production. From raw materials like steel and
            plastics to finished products awaiting distribution, our shelves are stocked with everything needed to keep
            our assembly lines running smoothly. Upon entering our warehouse, you'll encounter a well-structured layout
            designed for easy navigation. Each section is meticulously labeled and organized, ensuring that every item
            has its designated place. This meticulous organization not only facilitates efficient inventory management
            but also minimizes the time spent searching for specific materials.
        </p>

        <p v-if="canUpdateMaterials.includes(true)">
            <strong>Material can only be removed if it is not used by any product and there are no pieces of it in
                stock.</strong>
        </p>

        <div v-if="canCreateMaterials" class="d-flex justify-content-end mb-3 mt-3">
            <button class="btn btn-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#createModal"
                    @click="localErrors = {}">
                <i class="bi bi-plus-lg"></i> Add new material
            </button>
        </div>

        <div class="overflow-x-scroll">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Last update</th>
                    <th>Amount</th>
                    <th v-if="canUpdateMaterials.includes(true)">Action</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(item, index) in materials.data">
                    <th>{{ index + 1 + (materials.current_page - 1) * 10 }}</th>
                    <td>{{ item.name }}</td>
                    <td>
                        {{ item.updated_at }}
                    </td>
                    <td>
                        <button class="btn btn-warning" v-if="canChangeAmount"
                                data-bs-toggle="modal" data-bs-target="#removeAmountModal"
                                @click="() => {
                                    materialToEdit = { ...item };
                                    value = 0;
                                }">
                            <i class="bi bi-bag-dash"></i>
                        </button>

                        <div style="min-width: 30%; display: inline-block; text-align:center">
                            {{ item.amount }}
                        </div>

                        <button class="btn btn-warning" v-if="canChangeAmount"
                                data-bs-toggle="modal" data-bs-target="#addAmountModal"
                                @click="() => {
                                    materialToEdit = { ...item };
                                    value = 0;
                                }">
                            <i class="bi bi-bag-plus"></i>
                        </button>
                    </td>
                    <td v-if="canUpdateMaterials.includes(true)">
                        <button class="btn btn-primary me-1" v-if="canUpdateMaterials[index]"
                                data-bs-toggle="modal" data-bs-target="#updateModal"
                                @click="materialToEdit = { ...item }">
                            <i class="bi bi-pen"></i>
                        </button>

                        <button class="btn btn-danger ms-1" v-if="canDeleteMaterials[index]"
                                data-bs-toggle="modal" data-bs-target="#deleteModal"
                                @click="materialToDelete = item">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>

            <Paginator :items="materials"/>

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
                    Are you sure you want to delete the <strong>{{ materialToDelete.name }}</strong> material from
                    warehouse?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" @click="handleDelete" class="btn btn-danger" data-bs-dismiss="modal">Delete
                        material
                    </button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Create new material</h1>
                    <button type="button" class="btn-close" id="closeCreateModal" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <form @submit.prevent="handleCreate">
                    <div class="modal-body">

                        <div class="mb-3">
                            <label for="title" class="form-label">Name:</label>
                            <input type="text" class="form-control" id="title" v-model="materialToCreate.name"
                                   placeholder="Material name" required>
                        </div>


                        <div class="mb-3">
                            <label for="amount" class="form-label">Amount:</label>
                            <input type="number" min="0" step="1" class="form-control" id="amount"
                                   v-model="materialToCreate.amount"
                                   placeholder="0" required>
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
                            Create material
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="updateModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Update material</h1>
                    <button type="button" class="btn-close" id="closeUpdateModal" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <form @submit.prevent="handleUpdate">
                    <div class="modal-body">

                        <div class="mb-3">
                            <label for="title" class="form-label">Name:</label>
                            <input type="text" class="form-control" id="title" v-model="materialToEdit.name"
                                   placeholder="Material name" required>
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
                            Update material
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="addAmountModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Add {{ materialToEdit.name }} to warehouse</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            id="closeAddAmountModal"></button>
                </div>

                <form @submit.prevent="handleAddAmount">

                    <div class="modal-body">

                        <div class="mb-3">
                            <label for="value" class="form-label">Value:</label>
                            <input type="number" min="0" step="1"
                                   class="form-control" id="value"
                                   v-model="value"
                                   placeholder="Enter amount to add"
                                   required>
                        </div>

                    </div>


                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-warning">Add
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="removeAmountModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Remove {{ materialToEdit.name }} from warehouse</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            id="closeRemoveAmountModal"></button>
                </div>

                <form @submit.prevent="handleRemoveAmount">

                    <div class="modal-body">

                        <div class="mb-3">
                            <label for="value" class="form-label">Value:</label>
                            <input type="number" min="0" :max="materialToEdit.amount" step="1"
                                   class="form-control" id="value"
                                   v-model="value"
                                   placeholder="Enter amount to remove"
                                   required>
                        </div>

                    </div>


                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-warning">Remove
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
