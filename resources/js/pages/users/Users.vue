<script setup lang="ts">
import BasePage from "@/components/pages/BasePage.vue";
import {User} from "../../models/user";
import {onMounted, ref} from "vue";
import {router} from "@inertiajs/vue3";
import {useToast} from "vue-toastification";

const userToDelete = ref({} as User);

const toast = useToast();

const props = defineProps<{
    users: User[],
    canCreateUsers: boolean,
    canUpdateUsers: boolean[],
    canDeleteUsers: boolean[]
}>();


const handleDelete = () => {
    router.delete(`/users/${userToDelete.value.id}`, {
        preserveScroll: true,
        onSuccess: () => toast.error(`Successfully ${userToDelete.value.first_name} ${userToDelete.value.last_name} deleted!`)
    })
}

onMounted(() => {
    console.log(props)
})
</script>

<template>
    <BasePage title="Users">

        <p>
            Below is the list of users who have access to our system, each playing a crucial role in ensuring the smooth
            operation and efficiency of our factory. From supervisors to machine operators, every user is equipped with
            the necessary tools and information to contribute effectively to our production goals. Use this directory to
            easily find and collaborate with your colleagues, ensuring seamless communication and coordination across
            all departments.
        </p>

        <strong v-if="canDeleteUsers.includes(true)">You cannot remove yourself!</strong>

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
                <tr v-for="(item, index) in users">
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


</template>
