<script setup lang="ts">
import BasePage from "@/components/pages/BasePage.vue";
import {type Material, InputMaterial} from "@/models/material";
import {onMounted, ref} from "vue";
import {router} from "@inertiajs/vue3";
import {InputPosition} from "@/models/position";

const materialToDelete = ref({} as Material);
const materialToCreate = ref(new InputMaterial() as InputMaterial);
const localErrors = ref({} as InputMaterial | Object);

const props = defineProps<{
    materials: Material[],
    canCreateMaterials: boolean,
    canUpdateMaterials: boolean[],
    canDeleteMaterials: boolean[],
    canChangeAmount: boolean,
    errors: InputMaterial
}>();

const handleDelete = () => {
    router.delete(`/materials/${materialToDelete.value.id}`, {
        preserveScroll: true
    });
}

const handleCreate = () => {
    router.post("/materials", materialToCreate.value, {
        preserveScroll: true,
        onSuccess: () => {
            localErrors.value = {};
            const closeButton = document.getElementById("closeCreateModal");
            if (closeButton) closeButton.click();
        },
        onError: () => {
            localErrors.value = props.errors
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
            <strong>Material can only be deleted if no product uses it.</strong>
        </p>

        <div v-if="canCreateMaterials" class="d-flex justify-content-end mb-3 mt-3">
            <button class="btn btn-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#createModal"
                    @click="">
                <i class="bi bi-plus-lg"></i> Add new material
            </button>
        </div>

        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Added</th>
                <th>Amount</th>
                <th v-if="canUpdateMaterials.includes(true)">Action</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(item, index) in materials">
                <th>{{ index + 1 }}</th>
                <td>{{ item.name }}</td>
                <td>{{ item.added }}</td>
                <td>
                    <button class="btn btn-warning me-1">
                        <i class="bi bi-bag-dash"></i>
                    </button>

                    <div style="width:50px; display: inline-block; text-align:center">
                        {{ item.amount }}
                    </div>


                    <button class="btn btn-warning ms-1">
                        <i class="bi bi-bag-plus"></i>
                    </button>
                </td>
                <td v-if="canUpdateMaterials.includes(true)">
                    <button class="btn btn-primary me-1" v-if="canUpdateMaterials[index]"
                            data-bs-toggle="modal" data-bs-target="#updateModal"
                            @click="() => {}">
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
                            <label for="title" class="form-label">Amount:</label>
                            <input type="number" min="0" step="1" class="form-control" id="title"
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


</template>
