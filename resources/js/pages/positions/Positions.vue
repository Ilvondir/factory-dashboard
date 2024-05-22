<script setup lang="ts">

import BasePage from "@/components/pages/BasePage.vue";
import {InputPosition, type Position} from "@/models/position";
import {onMounted, ref} from 'vue';
import {router} from "@inertiajs/vue3";
import {Department} from "@/models/department";
import {Pagination} from "@/models/pagination";

const itemToDelete = ref({} as Position);
const positionToCreate = ref(new InputPosition() as InputPosition);
const localErrors = ref(new InputPosition() as InputPosition);
const idToUpdate = ref(0 as number);
const positionToUpdate = ref(new InputPosition() as InputPosition);

const props = defineProps<{
    positions: Pagination<Position>,
    canCreatePositions: boolean,
    canUpdatePositions: boolean[],
    canDeletePositions: boolean[],
    departments: Department[],
    errors: InputPosition
}>();

const handleDelete = () => {
    router.delete(`positions/${itemToDelete.value.id}`);
}

const handleCreate = () => {
    router.post("positions", positionToCreate.value, {
        onSuccess: () => {
            const closeButton = document.getElementById("closeCreateModal");
            if (closeButton) {
                closeButton.click();
            }
        },
        onError: () => localErrors.value = props.errors
    })
}

const handleUpdate = () => {
    router.put(`positions/${idToUpdate.value}`, positionToUpdate.value, {
        onSuccess: () => {
            const closeButton = document.getElementById("closeUpdateModal");
            if (closeButton) {
                closeButton.click();
            }
        },
        onError: () => localErrors.value = props.errors
    })
}

onMounted(() => {
    console.log(props);
})
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
            <button class="btn btn-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#createModal">
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
                <th v-if="canUpdatePositions.includes(true)" style="min-width: 130px">
                    Actions
                </th>
            </tr>
            </thead>
            <tbody>

            <template v-for="(item, index) in positions.data">

                <tr class="details-row">
                    <th scope="row">{{ index + 1 + (positions.current_page - 1) * positions.per_page }}</th>
                    <td>{{ item.name }}</td>
                    <td>{{ item.workers.length }} workers</td>
                    <td>{{ item.department.name }}</td>
                    <td v-if="canUpdatePositions.includes(true)">
                        <button class="btn btn-primary me-1" v-if="canUpdatePositions[index]"
                                data-bs-toggle="modal" data-bs-target="#updateModal"
                                @click="() => {
                                idToUpdate = item.id;
                                positionToUpdate.responsibilities = item.responsibilities;
                                positionToUpdate.name = item.name;
                                positionToUpdate.department_id = item.department.id;
                            }">
                            <i class="bi bi-pen"></i>
                        </button>

                        <button class="btn btn-danger ms-1" v-if="canDeletePositions[index]"
                                data-bs-toggle="modal" data-bs-target="#deleteModal"
                                @click="itemToDelete = item">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>

                </tr>

                <tr>
                    <td :colspan="canUpdatePositions.includes(true) ? 5 : 4">
                        {{ item.responsibilities }}
                    </td>
                </tr>

            </template>


            </tbody>
        </table>

        <nav class="d-flex justify-content-center">
            <ul class="pagination">
                <li class="page-item">
                    <inertia-link class="page-link" :href="positions.first_page_url"
                                  preserve-scroll>
                        <span><i class="bi bi-chevron-double-left"></i></span>
                    </inertia-link>
                </li>

                <li v-if="positions.current_page - 2 > 0" class="page-item">
                    <inertia-link :href="positions.links[positions.current_page - 2].url" class="page-link"
                                  preserve-scroll>
                        <span>{{ positions.current_page - 2 }}</span>
                    </inertia-link>
                </li>

                <li v-if="positions.current_page - 1 > 0" class="page-item">
                    <inertia-link :href="positions.links[positions.current_page - 1].url" class="page-link"
                                  preserve-scroll>
                        <span>{{ positions.current_page - 1 }}</span>
                    </inertia-link>
                </li>

                <li class="page-item active">
                    <span class="page-link">
                        <span>{{ positions.current_page }}</span>
                    </span>
                </li>

                <li v-if="positions.current_page + 1 <= positions.last_page" class="page-item">
                    <inertia-link :href="positions.links[positions.current_page + 1].url" class="page-link"
                                  preserve-scroll>
                        <span>{{ positions.current_page + 1 }}</span>
                    </inertia-link>
                </li>

                <li v-if="positions.current_page + 2 <= positions.last_page" class="page-item">
                    <inertia-link :href="positions.links[positions.current_page + 2].url" class="page-link"
                                  preserve-scroll>
                        <span>{{ positions.current_page + 2 }}</span>
                    </inertia-link>
                </li>

                <li class="page-item">
                    <inertia-link class="page-link" :href="positions.last_page_url"
                                  preserve-scroll>
                        <span><i class="bi bi-chevron-double-right"></i></span>
                    </inertia-link>
                </li>
            </ul>
        </nav>

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
                        position
                    </button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="createModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Create new position</h1>
                    <button type="button" class="btn-close" id="closeCreateModal" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <form @submit.prevent="handleCreate">
                    <div class="modal-body">

                        <div class="mb-3">
                            <label for="title" class="form-label">Name:</label>
                            <input type="text" class="form-control" id="title" v-model="positionToCreate.name"
                                   placeholder="Position name" required>
                        </div>

                        <div class="mb-3">
                            <label for="responsibilities" class="form-label">Responsibilities:</label>
                            <textarea v-model="positionToCreate.responsibilities" class="form-control"
                                      id="responsibilities"
                                      placeholder="Position responsibilities" rows="6" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="department" class="form-label">Department:</label>
                            <select
                                class="form-select" id="department" required
                                @change="(event) => positionToCreate.department_id = event.target.selectedOptions[0].value"
                            >
                                <option value="" disabled selected>Select department</option>
                                <option v-for="d in departments" :value="d.id">
                                    {{ d.name }}
                                </option>
                            </select>
                        </div>

                        <div v-if="localErrors.name || localErrors.responsibilities || localErrors.department_id"
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
                            Create position
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
                    <h1 class="modal-title fs-5">Edit position</h1>
                    <button type="button" class="btn-close" id="closeUpdateModal" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <form @submit.prevent="handleUpdate">
                    <div class="modal-body">

                        <div class="mb-3">
                            <label for="title" class="form-label">Name:</label>
                            <input type="text" class="form-control" id="title" v-model="positionToUpdate.name"
                                   placeholder="Position name" required>
                        </div>

                        <div class="mb-3">
                            <label for="responsibilities" class="form-label">Responsibilities:</label>
                            <textarea v-model="positionToUpdate.responsibilities" class="form-control"
                                      id="responsibilities"
                                      placeholder="Position responsibilities" rows="6" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="department" class="form-label">Department:</label>
                            <select
                                class="form-select" id="department" required
                                @change="(event) => positionToUpdate.department_id = event.target.selectedOptions[0].value"
                            >
                                <option value="" disabled>Select department</option>
                                <option v-for="d in departments" :value="d.id"
                                        :selected="positionToUpdate.department_id === d.id">
                                    {{ d.name }}
                                </option>
                            </select>
                        </div>

                        <div v-if="localErrors.name || localErrors.responsibilities || localErrors.department_id"
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
                            Update position
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
