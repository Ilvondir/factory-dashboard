<script setup lang="ts">
import BasePage from "@/components/pages/BasePage.vue";
import {onMounted, ref} from "vue";
import {type Worker} from "@/models/worker";

const currentWorker = ref({} as Worker);
const isWorkerSelected = ref(false as boolean);
const indexOfCurrentWorker = ref(0 as number);


const props = defineProps<{
    workers: Worker[],
    canCreateWorkers: boolean,
    canEditWorkers: boolean[],
    canDeleteWorkers: boolean[],
}>();

onMounted(() => {
    console.log(props);
})
</script>

<template>

    <inertia-head>
        <title>Workers</title>
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

        <div class="d-flex justify-content-end mb-3 mt-3">
            <button class="btn btn-success">
                <i class="bi bi-filetype-csv"></i> Download workers data
            </button>


            <button class="btn btn-primary ms-2"
                    data-bs-toggle="modal"
                    v-if="canCreateWorkers"
                    data-bs-target="#createModal">
                <i class="bi bi-plus-lg"></i> Add new worker
            </button>
        </div>

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
            <tr v-for="(item, index) in workers" data-bs-toggle="offcanvas" data-bs-target="#workerOffcanvas"
                aria-controls="offcanvasRight"
                @click="() => {currentWorker = item; isWorkerSelected = true; indexOfCurrentWorker = index}">
                <th>{{ index + 1 }}</th>
                <td>{{ item.first_name + " " + item.last_name }}</td>
                <td>{{ item.position.name }}</td>
                <td>{{ item.hired }}</td>
            </tr>
            </tbody>
        </table>

    </BasePage>

    <div class="offcanvas offcanvas-end w-50" tabindex="-1" id="workerOffcanvas"
         aria-labelledby="offcanvasRightLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasRightLabel">{{ currentWorker.first_name }}
                {{ currentWorker.last_name }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
            <p class="opacity-50" style="margin-top: -20px">#{{ currentWorker.id }}</p>

            <ul class="list-group mb-3">
                <li class="list-group-item fw-bold">Contact</li>
                <li class="list-group-item"><strong>Phone number:</strong> {{ currentWorker.phone_number }}</li>
                <li class="list-group-item"><strong>Email:</strong> {{ currentWorker.email }}</li>
                <li class="list-group-item"><strong>Address:</strong>: {{ currentWorker.address }}</li>
            </ul>

            <ul class="list-group" v-if="isWorkerSelected">
                <li class="list-group-item fw-bold">Job</li>
                <li class="list-group-item"><strong>Department:</strong> {{ currentWorker.position.department.name }}
                </li>
                <li class="list-group-item"><strong>Position:</strong> {{ currentWorker.position.name }}</li>
                <li class="list-group-item"><strong>Salary:</strong> {{ currentWorker.salary }} per month</li>
                <li class="list-group-item"><strong>Hired:</strong> {{ currentWorker.hired }}</li>
                <li class="list-group-item"><strong>Responsibilities:</strong>
                    {{ currentWorker.position.responsibilities }}
                </li>
            </ul>

            <div class="text-end w-100 mt-3">
                <button class="btn btn-primary me-1" v-if="canEditWorkers[indexOfCurrentWorker]"
                        data-bs-toggle="modal" data-bs-target="#updateModal">
                    <i class="bi bi-pen"></i> Edit
                </button>

                <button class="btn btn-danger ms-1" v-if="canDeleteWorkers[indexOfCurrentWorker]"
                        data-bs-toggle="modal" data-bs-target="#deleteModal">
                    <i class="bi bi-trash"></i> Delete
                </button>
            </div>
        </div>
    </div>


</template>
