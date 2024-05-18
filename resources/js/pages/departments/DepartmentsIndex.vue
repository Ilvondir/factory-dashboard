<script setup lang="ts">

import {Department} from "@/models/department";
import BasePage from "@/components/pages/BasePage.vue";
import {ref} from "vue";
import {router} from "@inertiajs/vue3";

const departmentToDelete = ref({} as Department);
const departmentToUpdate = ref({} as Department);

defineProps<{
    departments: Department[],
    positionsCounts: number[],
    canUpdateDepartments: boolean[],
    canDeleteDepartments: boolean[],
    canCreateDepartments: boolean
}>();

const handleDelete = () => {
    router.delete(`departments/${departmentToDelete.value.id}`, {});
}
</script>

<template>
    <inertia-head>
        <title>Departments</title>
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

        <p>
            <strong>A department can only be deleted if no position is assigned to it.</strong>
        </p>

        <table class="table table-hover table-striped">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Name</th>
                <th scope="col">Positions</th>
                <th scope="col">Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(item, index) in departments">
                <th scope="row">{{ index + 1 }}</th>
                <td>{{ item.name }}</td>
                <td>{{ positionsCounts[index] }} positions</td>
                <td>
                    <button class="btn btn-primary me-1" v-if="canUpdateDepartments[index]">
                        <i class="bi bi-pen"></i>
                    </button>
                    <button v-if="canDeleteDepartments[index]" class="btn btn-danger ms-1" data-bs-toggle="modal"
                            data-bs-target="#deleteModal" @click="departmentToDelete = item">
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
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Confirm decision</h1>
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

</template>
