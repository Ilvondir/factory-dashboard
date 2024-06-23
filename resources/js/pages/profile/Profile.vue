<script setup lang="ts">
import BasePage from "@/components/pages/BasePage.vue";
import {User} from "@/models/user";
import {onMounted, ref} from "vue";
import {Session, UAParsed} from "@/models/session";
// @ts-ignore
import UAParser from "ua-parser-js";
import {router} from "@inertiajs/vue3";
import {useToast} from "vue-toastification";

const uaInfos = ref([] as UAParsed[]);
const sessionToDelete = ref({} as Session);

const toast = useToast();

const props = defineProps<{
    user: User,
    sessions: Session[],
    canDeleteSessions: boolean[]
}>();

const handleDelete = () => {
    router.delete(`/sessions/${sessionToDelete.value.id}`, {
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

    router.post('/sessions', {sessions_id: sessions_id});
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
