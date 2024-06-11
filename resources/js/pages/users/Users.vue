<script setup lang="ts">
import BasePage from "@/components/pages/BasePage.vue";
import {InputUser, User} from "../../models/user";
import {onMounted, ref} from "vue";
import {router} from "@inertiajs/vue3";
import {useToast} from "vue-toastification";
import {Role} from "@/models/role";
import {Pagination} from "@/models/pagination";
import Paginator from "@/components/layout/Paginator.vue";

const userToDelete = ref({} as User);
const userToCreate = ref(new InputUser() as InputUser);
const localErrors = ref({} as InputUser);
const userToUpdate = ref(new InputUser() as InputUser);
const idToUpdate = ref(0 as number);

const toast = useToast();

const props = defineProps<{
    users: Pagination<User>,
    canCreateUsers: boolean,
    canUpdateUsers: boolean[],
    canDeleteUsers: boolean[],
    roles: Role[],
    errors: InputUser
}>();


const handleDelete = () => {
    router.delete(`/users/${userToDelete.value.id}`, {
        preserveScroll: true,
        onSuccess: () => toast.error(`Successfully ${userToDelete.value.first_name} ${userToDelete.value.last_name} deleted!`, {
            icon: false
        })
    })
}

const handleCreate = () => {
    router.post('/users', userToCreate.value, {
        preserveScroll: true,
        onSuccess: () => {
            const closeButton = document.getElementById("closeCreateModal");
            if (closeButton) closeButton.click();

            toast.success(`Successfully ${userToCreate.value.first_name} ${userToCreate.value.last_name} created!`, {
                icon: false,
            });

            localErrors.value = {} as InputUser;
            userToCreate.value = {} as InputUser;

            const select = document.querySelector('#role');
            // @ts-ignore
            if (select) select.value = "-1";
        },
        onError: () => {
            localErrors.value = props.errors
        }
    })
}

const handleUpdate = () => {
    router.put(`/users/${idToUpdate.value}`, userToUpdate.value, {
        preserveScroll: true,
        onSuccess: () => {
            const closeButton = document.getElementById("closeUpdateModal");
            if (closeButton) closeButton.click();

            toast.info(`Successfully ${userToUpdate.value.first_name} ${userToUpdate.value.last_name} updated!`, {
                icon: false,
            });

            localErrors.value = {} as InputUser;
        },
        onError: () => {
            localErrors.value = props.errors
        }
    })
}

onMounted(() => {
    console.log(props)
})
</script>

<template>

    <inertia-head>
        <title>Factory | Users</title>
    </inertia-head>

    <BasePage title="Users">

        <p>
            Below is the list of users who have access to our system, each playing a crucial role in ensuring the smooth
            operation and efficiency of our factory. From supervisors to machine operators, every user is equipped with
            the necessary tools and information to contribute effectively to our production goals. Use this directory to
            easily find and collaborate with your colleagues, ensuring seamless communication and coordination across
            all departments.
        </p>

        <strong v-if="canDeleteUsers.includes(true)">You cannot remove yourself!</strong>

        <div v-if="canCreateUsers" class="d-flex justify-content-end mb-3 mt-3">
            <button class="btn btn-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#createModal"
                    @click="localErrors = {} as InputUser">
                <i class="bi bi-plus-lg"></i> Add new user
            </button>
        </div>

        <div class="overflow-x-scroll">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th v-if="canUpdateUsers.includes(true)">Action</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(item, index) in users.data">
                    <th>{{ index + 1 }}</th>
                    <td>{{ item.first_name }} {{ item.last_name }}</td>
                    <td>
                        <a :href="'mailto:' + item.email" class="text-decoration-none text-black">
                            {{ item.email }}
                        </a>
                    </td>
                    <td>
                        {{ item.role.name }}
                    </td>

                    <td v-if="canUpdateUsers.includes(true)">

                        <button class="btn btn-primary me-1" v-if="canUpdateUsers[index]"
                                data-bs-toggle="modal" data-bs-target="#updateModal"
                                @click="() => {
                                    userToUpdate.first_name = item.first_name
                                    userToUpdate.last_name = item.last_name
                                    userToUpdate.email = item.email
                                    userToUpdate.role_id = item.role.id
                                    localErrors = {} as InputUser
                                    idToUpdate = item.id
                                }">
                            <i class="bi bi-pen"></i>
                        </button>

                        <button class="btn btn-danger ms-1" v-if="canDeleteUsers[index]"
                                data-bs-toggle="modal" data-bs-target="#deleteModal"
                                @click="userToDelete = item">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <Paginator :items="users"/>
    </BasePage>


    <div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Confirm decision</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" v-if="userToDelete.role">
                    Are you sure you want to delete the {{ userToDelete.role.name }}
                    <strong>
                        {{ userToDelete.first_name }} {{ userToDelete.last_name }}?
                    </strong>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" @click="handleDelete" class="btn btn-danger" data-bs-dismiss="modal">Delete
                        user
                    </button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal modal-lg fade" id="createModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Create new user</h1>
                    <button type="button" class="btn-close" id="closeCreateModal" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <form @submit.prevent="handleCreate">
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <div class="mb-3">
                                    <label for="first_name" class="form-label">First name:</label>
                                    <input type="text" class="form-control" id="first_name"
                                           v-model="userToCreate.first_name"
                                           placeholder="First name" required>
                                </div>
                            </div>

                            <div class="col-12 col-lg-6">
                                <div class="mb-3">
                                    <label for="last_name" class="form-label">Last name:</label>
                                    <input type="text" class="form-control" id="last_name"
                                           v-model="userToCreate.last_name"
                                           placeholder="Last name" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email:</label>
                                    <input type="email" class="form-control" id="email"
                                           v-model="userToCreate.email"
                                           placeholder="Email" required>
                                </div>
                            </div>

                            <div class="col-12 col-lg-6">
                                <div class="mb-3">
                                    <label for="role" class="form-label">Role:</label>
                                    <select
                                        class="form-select" id="role" required
                                        @change="(event) => userToCreate.role_id = event.target ? event.target.selectedOptions[0].value : 0"
                                    >
                                        <option value="-1" disabled selected>Select role</option>
                                        <option v-for="r in roles" :value="r.id">
                                            {{ r.name }}
                                        </option>
                                    </select>
                                </div>
                            </div>
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
                            Create user
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
                    <h1 class="modal-title fs-5">Edit user</h1>
                    <button type="button" class="btn-close" id="closeUpdateModal" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                </div>
                <form @submit.prevent="handleUpdate">
                    <div class="modal-body">

                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <div class="mb-3">
                                    <label for="first_name" class="form-label">First name:</label>
                                    <input type="text" class="form-control" id="first_name"
                                           v-model="userToUpdate.first_name"
                                           placeholder="First name" required>
                                </div>
                            </div>

                            <div class="col-12 col-lg-6">
                                <div class="mb-3">
                                    <label for="last_name" class="form-label">Last name:</label>
                                    <input type="text" class="form-control" id="last_name"
                                           v-model="userToUpdate.last_name"
                                           placeholder="Last name" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <div class="mb-3">
                                    <label for="email" class="form-label">Email:</label>
                                    <input type="email" class="form-control" id="email"
                                           v-model="userToUpdate.email"
                                           placeholder="Email" required>
                                </div>
                            </div>

                            <div class="col-12 col-lg-6">
                                <div class="mb-3">
                                    <label for="role" class="form-label">Role:</label>
                                    <select
                                        class="form-select" id="role" required
                                        @change="(event) => userToCreate.role_id = event.target ? event.target.selectedOptions[0].value : 0"
                                    >
                                        <option value="-1" disabled>Select role</option>
                                        <option v-for="r in roles" :value="r.id"
                                                :selected="userToUpdate.role_id === r.id"
                                        >
                                            {{ r.name }}
                                        </option>
                                    </select>
                                </div>
                            </div>
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
                            Update user
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
