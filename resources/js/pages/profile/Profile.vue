<script setup lang="ts">
import BasePage from "@/components/pages/BasePage.vue";
import {InputPasswordChange, User} from "@/models/user";
import {onMounted, ref} from "vue";
import {Session, UAParsed} from "@/models/session";
// @ts-ignore
import UAParser from "ua-parser-js";
import {router} from "@inertiajs/vue3";
import {useToast} from "vue-toastification";

const uaInfos = ref([] as UAParsed[]);
const sessionToDelete = ref({} as Session);
const passwordChangeData = ref(new InputPasswordChange() as InputPasswordChange);

const toast = useToast();

const props = defineProps<{
    user: User,
    sessions: Session[],
    canDeleteSessions: boolean[],
    actionsNumber: number,
    errors: InputPasswordChange
}>();

const handleDelete = () => {
    router.delete(`/sessions/${sessionToDelete.value.id}`, {
        preserveScroll: true,
        onSuccess: () => {
            toast.error("Session deleted successfully!", {icon: false});
        }
    })
}

const handleDeleteAllSessions = () => {
    const sessions_id: string[] = [];

    props.sessions.forEach((session: Session, index: number) => {
        if (props.canDeleteSessions[index]) sessions_id.push(session.id)
    });

    router.post('/sessions', {sessions_id: sessions_id}, {
        preserveScroll: true,
        onSuccess: () => {
            toast.error("All other sessions deleted successfully!", {icon: false});
        }
    });
}

const handleChangePassword = () => {
    router.patch(`/profile/${props.user.id}/password`, passwordChangeData.value, {
        preserveScroll: true,
        onSuccess: () => {
            passwordChangeData.value = new InputPasswordChange();
            toast.info("Password changed successfully!")
        }
    });
}

onMounted(() => {
    console.log(props);

    const temp: any[] = [];

    props.sessions.map((session: Session) => {
        const result = new UAParser(session.user_agent).getResult();
        temp.push(result);
    });

    uaInfos.value = temp;
})
</script>

<template>
    <inertia-head>
        <title>Factory | Profile</title>
    </inertia-head>

    <BasePage title="Profile">


        <div class="row">

            <div class="col-lg-3 col-12 text-center">
                <i class="bi bi-person-circle"></i>
            </div>

            <div class="col-lg-9 col-12 d-flex justify-content-center align-items-center">

                <div class="mh-100">
                    <p class="display-3 text-center">
                        {{ user.first_name + " " + user.last_name }}
                    </p>
                    <p class="display-6 text-center">
                        {{ user.role.name }}
                    </p>

                    <p class="mt-5 text-center display-6 mb-5 mb-lg-0" v-if="user.role.id === 1">
                        {{ actionsNumber }} actions performed
                    </p>
                </div>

            </div>

        </div>


        <h4 class="mt-4">Change password</h4>

        <div class="row mb-5">

            <form @submit.prevent="handleChangePassword">
                <div class="card col-lg-6 col-12 offset-lg-3" style="padding: 0">
                    <div class="card-header">
                        Change your password
                    </div>
                    <div class="card-body">


                        <div class="mb-3">
                            <label for="old_password" class="form-label">Old password:</label>
                            <input type="password" class="form-control" id="old_password"
                                   placeholder="Enter old password"
                                   required v-model="passwordChangeData.old_password">
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">New password:</label>
                            <input type="password" min="8" class="form-control" id="password"
                                   placeholder="Enter new password" required
                                   v-model="passwordChangeData.password">
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirm password:</label>
                            <input type="password" class="form-control" id="password_confirmation" required
                                   placeholder="Confirm new password"
                                   v-model="passwordChangeData.password_confirmation">
                        </div>

                        <div v-if="Object.keys(errors).length > 0"
                             class="alert-danger alert">
                            <ul class="m-0">
                                <li v-for="er in errors">
                                    {{ er }}
                                </li>
                            </ul>
                        </div>


                    </div>

                    <div class="card-footer text-end">
                        <button class="btn btn-primary">Change password</button>
                    </div>

                </div>

            </form>

        </div>


        <h4>Sessions</h4>

        <div class="d-flex justify-content-end">
            <button class="btn btn-danger mb-2"
                    data-bs-toggle="modal" data-bs-target="#deleteAllModal">
                <i class="bi bi-trash3-fill text-white"></i>
                Delete all other sessions
            </button>
        </div>

        <div class="overflow-x-scroll">
            <ul class="list-group">
                <li class="list-group-item" v-for="(session, index) in sessions">
                    <div class="d-flex align-items-center row">

                        <div class="col-1 text-center">
                            <i class="bi bi-pc-display-horizontal" v-if="!session.user_agent.includes('Mobile')"></i>
                            <i class="bi bi-phone" v-else></i>
                        </div>

                        <div v-if="uaInfos[index]" class="col-10">
                            <h5 class="animate">
                                {{ uaInfos[index].os.name + " " + uaInfos[index].os.version }}
                                ({{ uaInfos[index].browser.name + " " + uaInfos[index].browser.version }})
                            </h5>

                            <p class="animate">
                                {{ session.ip_address }}
                                (Last activity: {{ new Date(session.last_activity * 1000).toLocaleString() }})
                            </p>
                        </div>

                        <div class="col-1">

                            <button class="btn btn-danger" v-if="canDeleteSessions[index]"
                                    @click="sessionToDelete = session"
                                    data-bs-toggle="modal" data-bs-target="#deleteModal">
                                <i class="bi bi-trash" style="font-size: 110%"></i>
                            </button>

                        </div>
                    </div>

                </li>
            </ul>
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
                    Are you sure you want to delete this session?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" @click="handleDelete" class="btn btn-danger" data-bs-dismiss="modal">Delete
                        session
                    </button>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="deleteAllModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5">Confirm decision</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete all other session?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" @click="handleDeleteAllSessions" class="btn btn-danger"
                            data-bs-dismiss="modal">
                        Delete sessions
                    </button>
                </div>
            </div>
        </div>
    </div>

</template>

<style scoped>
.bi-pc-display-horizontal, .bi-phone {
    color: rgb(var(--bs-primary-rgb));
    font-size: 250%;
}

.bi-person-circle {
    color: rgb(var(--bs-primary-rgb));
    font-size: 1300%;
}

p {
    margin: 0;
}

.animate {
    transition: 0.3s;
}

.list-group-item:hover .animate {
    margin-left: 5px;
}
</style>
