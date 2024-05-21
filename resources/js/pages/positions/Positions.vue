<script setup lang="ts">

import BasePage from "@/components/pages/BasePage.vue";
import {type Position} from "@/models/position";
import {onMounted, ref} from 'vue';
import {router} from "@inertiajs/vue3";

const itemToDelete = ref({} as Position);

const props = defineProps<{
    positions: {
        data: Position[]
    },
    canCreatePositions: boolean,
    canUpdatePositions: boolean[]
    canDeletePositions: boolean[]
}>();

const handleDelete = () => {
    router.delete(`positions/${itemToDelete.value.id}`);
}

onMounted(() => {
    console.log(props);
});
</script>

<template>

    <inertia-head>
        <title>Positions</title>
    </inertia-head>

    <BasePage title="Positions">
        <p>
            Our factory management platform encompasses a comprehensive suite of roles designed to streamline and
            optimize production processes. Key positions include Production Managers, who oversee daily operations and
            ensure efficiency; Quality Assurance Managers, dedicated to maintaining the highest standards of product
            quality; and Supply Chain Coordinators, who manage the seamless flow of materials and products. Maintenance
            Supervisors ensure all equipment operates at peak performance, while Health and Safety Officers uphold a
            secure working environment. Additionally, roles such as HR Managers, Financial Analysts, and IT Support
            Specialists contribute to the overall functionality and continuous improvement of our manufacturing
            operations. Together, these positions form an integrated team focused on driving excellence and innovation
            in factory management.
        </p>

        <p v-if="canUpdatePositions.includes(true)">
            <strong>A position can only be deleted if no worker is assigned to it.</strong>
        </p>

        <div v-if="canCreatePositions" class="d-flex justify-content-end mb-3 mt-3">
            <button class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Add new position
            </button>
        </div>


        <table class="table table-hover table-striped">
            <thead>
            <tr>
                <th scope="col">#</th>
                <th>Name</th>
                <th>Workers</th>
                <th>Department</th>
                <th v-if="canUpdatePositions.includes(true)">Actions</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(item, index) in positions.data" class="details-row">
                <th scope="row">{{ index + 1 }}</th>
                <td>{{ item.name }}</td>
                <td>{{ item.workers.length }} workers</td>
                <td>{{ item.department.name }}</td>
                <td v-if="canUpdatePositions.includes(true)">
                    <button class="btn btn-primary me-1" v-if="canUpdatePositions[index]">
                        <i class="bi bi-pen"></i>
                    </button>

                    <button class="btn btn-danger ms-1" v-if="canDeletePositions[index]"
                            data-bs-toggle="modal" data-bs-target="#deleteModal"
                            @click="itemToDelete = item">
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
                    Are you sure you want to delete the <strong>{{ itemToDelete.name }}</strong> position?
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
