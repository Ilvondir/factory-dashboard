<script setup lang="ts">
import BasePage from "@/components/pages/BasePage.vue";
import {onMounted, ref} from "vue";
import {InputWorker, type Worker} from "@/models/worker";
import {router} from "@inertiajs/vue3";
import Paginator from "@/components/layout/Paginator.vue";
import {Pagination} from "@/models/pagination";
import {Department} from "@/models/department";

const currentWorker = ref({} as Worker);
const isWorkerSelected = ref(false as boolean);
const indexOfCurrentWorker = ref(0 as number);
const workerToAdd = ref(new InputWorker() as InputWorker);
const localErrors = ref({} as InputWorker);
const workerToEdit = ref({} as InputWorker);

const searchInput = ref("" as string);
const url = ref(new URL(window.location.href).searchParams);

const props = defineProps<{
    workers: Pagination<Worker>,
    canCreateWorkers: boolean,
    canEditWorkers: boolean[],
    canDeleteWorkers: boolean[],
    departments: Department[],
    errors: InputWorker,
}>();

const handleDelete = () => {
    router.delete(`/workers/${currentWorker.value.id}`, {
        preserveScroll: true,
        onSuccess: () => {
            const offcanvasCloseButton = document.getElementById("closeOffcanvas");
            if (offcanvasCloseButton) {
                offcanvasCloseButton.click();
            }
        }
    });
}

const handleCreate = () => {
    router.post("/workers", workerToAdd.value, {
        preserveScroll: true,
        onSuccess: () => {
            localErrors.value = {} as InputWorker;
            const closeButton = document.getElementById("closeCreateModal");
            if (closeButton) {
                closeButton.click();
            }

            workerToAdd.value = new InputWorker();
        },
        onError: () => {
            localErrors.value = props.errors;
        }
    });
}


const handleUpdate = () => {
    router.put(`/workers/${currentWorker.value.id}`, workerToEdit.value, {
        preserveScroll: true,
        onSuccess: () => {
            const closeButton = document.getElementById("closeUpdateModal");
            if (closeButton) closeButton.click();

            for (let i = 0; i < props.workers.data.length; i++) {
                if (props.workers.data[i].id === currentWorker.value.id) currentWorker.value = props.workers.data[i];
            }
        },
        onError: () => {
            localErrors.value = props.errors;
        }
    })
}

const handleSearch = () => {
    if (searchInput.value.length > 0) {
        let url = new URL(window.location.href);
        url.searchParams.set('query', searchInput.value);
        url.searchParams.delete('page');

        router.get(url.toString(), {}, {preserveScroll: true});
    } else {
        let url = new URL(window.location.href);
        url.searchParams.delete('query');
        url.searchParams.delete('page');

        router.get(url.toString(), {}, {preserveScroll: true});
    }
}

onMounted(() => {
    console.log(props);
})
</script>

<template>

    <inertia-head>
        <title>Factory | Workers</title>
    </inertia-head>

    <BasePage title="Workers">
        <p>
            As we navigate the complexities of our industry, it's essential to acknowledge the invaluable contributions
            of each member of our workforce. You are the driving force behind our operations, and your dedication is
            paramount to our success. In this factory, we hold a profound respect for the skill, commitment, and
            integrity that each one of you brings to the table. We understand that the foundation of a thriving
            workplace lies in fostering an environment of mutual respect, safety, and support. Your well-being is not
            just a priority, but a fundamental principle that guides our every decision. As we move forward, let us
            continue to uphold these values and work together seamlessly towards our collective objectives.
        </p>

        <strong>You can click on the worker you are interested in to read more details.</strong>

        <div class="d-flex mb-3 mt-3 justify-content-between">

            <div class="input-group w-25">
                <input type="text" class="form-control" v-model="searchInput" placeholder="Search...">
                <button @click="handleSearch" class="input-group-text btn btn-primary"
                        id="btnGroupAddon">
                    <i class="bi bi-search"></i>
                </button>
            </div>

            <div>
                <a href="/workers/csv" class="btn btn-success" download>
                    <i class="bi bi-filetype-csv"></i> Download workers data
                </a>


                <button class="btn btn-primary ms-2"
                        data-bs-toggle="modal"
                        v-if="canCreateWorkers"
                        data-bs-target="#createModal"
                        @click="() => localErrors = {} as InputWorker">
                    <i class="bi bi-plus-lg"></i> Add new worker
                </button>
            </div>
        </div>

        <div class="overflow-x-scroll">
            <table class="table table-hover table-striped">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th>Name</th>
                    <th>Position</th>
                    <th>Hired</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(item, index) in workers.data" data-bs-toggle="offcanvas" data-bs-target="#workerOffcanvas"
                    aria-controls="offcanvasRight"
                    @click="() => {currentWorker = item; isWorkerSelected = true; indexOfCurrentWorker = index}">
                    <th>{{ index + 1 + 10 * (workers.current_page - 1) }}</th>
                    <td>{{ item.first_name + " " + item.last_name }}</td>
                    <td>{{ item.position.name }}</td>
                    <td>{{ item.hired }}</td>
                </tr>
                </tbody>
            </table>
        </div>

        <Paginator :items="workers"
                   :query="url.get('query') !== null ? url.get('query').toString() : ''"/>

    </BasePage>


    <div class="offcanvas offcanvas-end w-50" tabindex="-1" id="workerOffcanvas"
         aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasRightLabel">{{ currentWorker.first_name }}
                {{ currentWorker.last_name }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" id="closeOffcanvas"
                    aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <p class="opacity-50" style="margin-top: -20px">#{{ currentWorker.id }}</p>

            <ul class="list-group mb-3">
                <li class="list-group-item fw-bold">Contact</li>
                <li class="list-group-item"><strong>Phone number:</strong> {{ currentWorker.phone_number }}</li>
                <li class="list-group-item"><strong>Email:</strong> {{ currentWorker.email }}</li>
                <li class="list-group-item"><strong>Address:</strong>: {{ currentWorker.address }}</li>
            </ul>

            <ul class="list-group">
                <li class="list-group-item fw-bold">
                    Job
                </li>
                <li class="list-group-item" v-if="isWorkerSelected">
                    <strong>Department:</strong> {{ currentWorker.position.department.name }}
                </li>
                <li class="list-group-item" v-if="isWorkerSelected">
                    <strong>Position:</strong> {{ currentWorker.position.name }}
                </li>
                <li class="list-group-item">
                    <strong>Salary:</strong> {{ currentWorker.salary }} per month
                </li>
                <li class="list-group-item">
                    <strong>Hired:</strong> {{ currentWorker.hired }}
                </li>
                <li class="list-group-item" v-if="isWorkerSelected">
                    <strong>Responsibilities:</strong>
                    {{ currentWorker.position.responsibilities }}
                </li>
            </ul>

            <div class="text-end w-100 mt-3">
                <button class="btn btn-primary me-1" v-if="canEditWorkers[indexOfCurrentWorker]"
                        data-bs-toggle="modal" data-bs-target="#updateModal"
                        @click="() => {
                            localErrors = {} as InputWorker;
                            workerToEdit.first_name = workers.data[indexOfCurrentWorker].first_name
                            workerToEdit.last_name = workers.data[indexOfCurrentWorker].last_name
                            workerToEdit.email = workers.data[indexOfCurrentWorker].email
                            workerToEdit.phone_number = workers.data[indexOfCurrentWorker].phone_number
                            workerToEdit.address = workers.data[indexOfCurrentWorker].address
                            workerToEdit.hired = workers.data[indexOfCurrentWorker].hired
                            workerToEdit.salary = workers.data[indexOfCurrentWorker].salary
                            workerToEdit.position_id = workers.data[indexOfCurrentWorker].position.id
                        }">
                    <i class="bi bi-pen"></i> Edit
                </button>

                <button class="btn btn-danger ms-1" v-if="canDeleteWorkers[indexOfCurrentWorker]"
                        data-bs-toggle="modal" data-bs-target="#deleteModal">
                    <i class="bi bi-trash"></i> Delete
                </button>
            </div>
        </div>
    </div>


    <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true" v-if="isWorkerSelected">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Confirm decision</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete the <strong>{{ currentWorker.first_name }}
                    {{ currentWorker.last_name }} ({{ currentWorker.position.name }})</strong> worker?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" @click="handleDelete" class="btn btn-danger" data-bs-dismiss="modal">Delete
                        worker
                    </button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade modal-lg" id="createModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Add new worker</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" id="closeCreateModal"
                            aria-label="Close"></button>
                </div>
                <form @submit.prevent="handleCreate">

                    <div class="modal-body">

                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <div class="mb-3">
                                    <label for="first_name" class="form-label">First name:</label>
                                    <input type="text" class="form-control" id="first_name"
                                           v-model="workerToAdd.first_name"
                                           placeholder="First name" required>
                                </div>
                            </div>

                            <div class="col-12 col-lg-6">
                                <div class="mb-3">
                                    <label for="last_name" class="form-label">Last name:</label>
                                    <input type="text" class="form-control" id="last_name"
                                           v-model="workerToAdd.last_name"
                                           placeholder="Last name" required>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email:</label>
                                    <input type="email" class="form-control" id="email" v-model="workerToAdd.email"
                                           placeholder="Email" required>
                                </div>
                            </div>

                            <div class="col-12 col-lg-6">
                                <div class="mb-3">
                                    <label for="phone_number" class="form-label">Phone number:</label>
                                    <input type="tel" class="form-control" id="phone_number"
                                           v-model="workerToAdd.phone_number"
                                           placeholder="Phone number" required>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="address" class="form-label">Address:</label>
                                    <input type="text" class="form-control" id="address" v-model="workerToAdd.address"
                                           placeholder="Address" required>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <div class="mb-3">
                                    <label for="salary" class="form-label">Salary:</label>
                                    <input type="number" class="form-control" id="salary" min="0" step="0.01"
                                           v-model="workerToAdd.salary"
                                           placeholder="Salary" required>
                                </div>
                            </div>

                            <div class="col-12 col-lg-6">
                                <div class="mb-3">
                                    <label for="position" class="form-label">Position:</label>
                                    <select class="form-select" id="position" required
                                            @change="(event) => {workerToAdd.position_id = event.target ? event.target.selectedOptions[0].value : 0 ; console.log(workerToAdd)}"
                                    >}
                                        <option disabled selected>Select position</option>

                                        <template v-for="d in departments">
                                            <optgroup :label="d.name"></optgroup>

                                            <option v-for="p in d.positions" :value="p.id">
                                                {{ p.name }}
                                            </option>

                                        </template>

                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="hired" class="form-label">Hired date:</label>
                                    <input type="date" class="form-control" id="hired" v-model="workerToAdd.hired"
                                           required>
                                </div>
                            </div>
                        </div>

                        <div
                            v-if="Object.keys(localErrors).length > 0"
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
                        <button type="submit" class="btn btn-primary">Add worker
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade modal-lg" id="updateModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Update worker</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" id="closeUpdateModal"
                            aria-label="Close"></button>
                </div>
                <form @submit.prevent="handleUpdate">

                    <div class="modal-body">

                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <div class="mb-3">
                                    <label for="first_name" class="form-label">First name:</label>
                                    <input type="text" class="form-control" id="first_name"
                                           v-model="workerToEdit.first_name"
                                           placeholder="First name" required>
                                </div>
                            </div>

                            <div class="col-12 col-lg-6">
                                <div class="mb-3">
                                    <label for="last_name" class="form-label">Last name:</label>
                                    <input type="text" class="form-control" id="last_name"
                                           v-model="workerToEdit.last_name"
                                           placeholder="Last name" required>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email:</label>
                                    <input type="email" class="form-control" id="email" v-model="workerToEdit.email"
                                           placeholder="Email" required>
                                </div>
                            </div>

                            <div class="col-12 col-lg-6">
                                <div class="mb-3">
                                    <label for="phone_number" class="form-label">Phone number:</label>
                                    <input type="tel" class="form-control" id="phone_number"
                                           v-model="workerToEdit.phone_number"
                                           placeholder="Phone number" required>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="address" class="form-label">Address:</label>
                                    <input type="text" class="form-control" id="address" v-model="workerToEdit.address"
                                           placeholder="Address" required>
                                </div>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <div class="mb-3">
                                    <label for="salary" class="form-label">Salary:</label>
                                    <input type="number" class="form-control" id="salary" min="0" step="0.01"
                                           v-model="workerToEdit.salary"
                                           placeholder="Salary" required>
                                </div>
                            </div>

                            <div class="col-12 col-lg-6">
                                <div class="mb-3">
                                    <label for="position" class="form-label">Position:</label>
                                    <select class="form-select" id="position" required
                                            @change="(event) => {workerToEdit.position_id = event.target ? event.target.selectedOptions[0].value : 0 ; console.log(workerToAdd)}"
                                    >}
                                        <option disabled>Select position</option>


                                        <template v-for="d in departments">
                                            <optgroup :label="d.name"></optgroup>

                                            <template v-for="p in d.positions">
                                                <option :value="p.id" :selected="p.id === workerToEdit.position_id">
                                                    {{ p.name }}
                                                </option>
                                            </template>

                                        </template>

                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label for="hired" class="form-label">Hired date:</label>
                                    <input type="date" class="form-control" id="hired" v-model="workerToEdit.hired"
                                           required>
                                </div>
                            </div>
                        </div>

                        <div
                            v-if="Object.keys(localErrors).length > 0"
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
                            Update worker
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


</template>


<style scoped>
tr {
    cursor: pointer;
}
</style>
