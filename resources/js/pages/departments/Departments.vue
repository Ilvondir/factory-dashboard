<script setup lang="ts">

import {Department, InputDepartment} from "@/models/department";
import BasePage from "@/components/pages/BasePage.vue";
import {ref} from "vue";
import {router} from "@inertiajs/vue3";
import {useToast} from "vue-toastification";

const toast = useToast();

const departmentToDelete = ref({} as Department);
const departmentToUpdate = ref(new InputDepartment() as InputDepartment);
const idToUpdate = ref(0 as number);
const departmentToCreate = ref(new InputDepartment() as InputDepartment)
const localErrors = ref({} as InputDepartment);

const props = defineProps<{
    departments: Department[],
    positionsCounts: number[],
    canUpdateDepartments: boolean[],
    canDeleteDepartments: boolean[],
    canCreateDepartments: boolean,
    errors: InputDepartment
}>();

const handleDelete = () => {
    router.delete(`departments/${departmentToDelete.value.id}`, {
        preserveScroll: true,
        onSuccess: () => {
            toast.error(`Successfully ${departmentToDelete.value.name} deleted!`, {
                icon: false
            });
        }
    });
}

const handleUpdate = () => {
    router.put(`departments/${idToUpdate.value}`, departmentToUpdate.value, {
        preserveScroll: true,
        onSuccess: () => {
            const closeButton = document.getElementById("closeUpdateModal");
            if (closeButton) {
                closeButton.click();
            }
            localErrors.value = {} as InputDepartment;

            toast.info(`Successfully ${departmentToUpdate.value.name} updated!`, {
                icon: false
            });
        },
        onError: () => localErrors.value = props.errors,
    });
}

const handleCreate = () => {
    router.post(`departments`, departmentToCreate.value, {
        preserveScroll: true,
        onSuccess: () => {
            const closeButton = document.getElementById("closeCreateModal");
            if (closeButton) {
                closeButton.click();
            }

            toast.success(`Successfully ${departmentToCreate.value.name} created!`, {
                icon: false
            });

            departmentToCreate.value = new InputDepartment();
            localErrors.value = {} as InputDepartment;
        },
        onError: () => localErrors.value = props.errors,
    })
}

</script>

<template>
    <inertia-head>
        <title>Factory | Departments</title>
    </inertia-head>

    <BasePage title="Departments">
        <p>
            This page provides a comprehensive list of departments operating within the factory, encompassing various
            functions such as production, quality control, logistics, and administration. Each department plays a
            crucial role in ensuring the smooth operation of the facility, with specialized teams focusing on specific
            tasks to optimize efficiency and productivity. Whether it's manufacturing, inspection, warehousing, or
            managerial duties, these departments collaborate synergistically to meet production targets and maintain
            high standards of quality.
        </p>

        <p v-if="canUpdateDepartments.includes(true)">
            <strong>A department can only be deleted if no position is assigned to it.</strong>
        </p>

        <div v-if="canCreateDepartments" class="d-flex mt-3 mb-3 justify-content-end">
            <button class="btn btn-primary" data-bs-toggle="modal"
                    data-bs-target="#createModal"
                    @click="localErrors = {} as InputDepartment">
                <i class="bi bi-plus-lg"></i> Create department
            </button>
        </div>

        <div class="overflow-x-scroll">
            <table class="table table-hover table-striped">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Positions</th>
                    <th scope="col" v-if="canUpdateDepartments.includes(true)">Actions</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(item, index) in departments">
                    <th scope="row">{{ index + 1 }}</th>
                    <td>{{ item.name }}</td>
                    <td>{{ positionsCounts[index] }} positions</td>
                    <td>
                        <button class="btn btn-primary me-1" v-if="canUpdateDepartments[index]" data-bs-toggle="modal"
                                data-bs-target="#updateModal" @click="() => {
                                departmentToUpdate = {...item}
                                idToUpdate = item.id
                                localErrors = {} as InputDepartment
                            }">
                            <i class="bi bi-pen"></i>
                        </button>
                        <button v-if="canDeleteDepartments[index]" class="btn btn-danger ms-1" data-bs-toggle="modal"
                                data-bs-target="#deleteModal"
                                @click="departmentToDelete = item">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
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
                    Are you sure you want to delete the <strong>{{ departmentToDelete.name }}</strong> department?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" @click="handleDelete" class="btn btn-danger" data-bs-dismiss="modal">Delete
                        department
                    </button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="updateModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Update department</h1>
                    <button type="button" class="btn-close" id="closeUpdateModal" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <form @submit.prevent="handleUpdate">
                    <div class="modal-body">

                        <div class="mb-3">
                            <label for="title" class="form-label">Name:</label>
                            <input type="text" class="form-control" id="title" v-model="departmentToUpdate.name"
                                   placeholder="Department name" required>
                        </div>

                        <div v-if="Object.keys(localErrors).length > 0" class="alert-danger alert">
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
                            Update department
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Create new department</h1>
                    <button type="button" class="btn-close" id="closeCreateModal" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <form @submit.prevent="handleCreate">
                    <div class="modal-body">

                        <div class="mb-3">
                            <label for="title" class="form-label">Name:</label>
                            <input type="text" class="form-control" id="title" v-model="departmentToCreate.name"
                                   placeholder="Department name" required>
                        </div>

                        <div v-if="Object.keys(localErrors).length > 0" class="alert-danger alert">
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
                            Create department
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</template>
