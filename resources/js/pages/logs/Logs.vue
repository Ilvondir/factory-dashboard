<script setup lang="ts">
import BasePage from "@/components/pages/BasePage.vue";
import {Log} from "@/models/log";
import {onMounted} from "vue";
import {Pagination} from "@/models/pagination";
import Paginator from "@/components/layout/Paginator.vue";
import {InputWorker} from "@/models/worker";


const props = defineProps<{
    logs: Pagination<Log>
    canDownloadLogs: boolean
}>();

onMounted(() => {
    console.log(props)
})
</script>

<template>
    <inertia-head>
        <title>Factory | Logs</title>
    </inertia-head>

    <BasePage title="Logs">

        <p>In the bustling environment of a factory management system, logs serve as the backbone of operations,
            providing a comprehensive record of every activity and transaction. These logs meticulously document the
            flow of materials, the performance of machinery, and the actions of personnel, ensuring accountability and
            facilitating efficient troubleshooting. With each entry, a narrative of productivity unfolds, detailing the
            rhythm of production and the intricacies of the manufacturing process. From raw material intake to finished
            product dispatch, every step is meticulously recorded, creating a trail of data essential for quality
            control and process optimization. As the heartbeat of the factory, these logs not only track progress but
            also pave the way for continuous improvement and innovation in manufacturing practices.
        </p>

        <div class="d-flex justify-content-end mb-3 mt-3">
            <a href="/logs/json" class="btn btn-success" download v-if="canDownloadLogs">
                <i class="bi bi-filetype-json"></i> Download logs
            </a>
        </div>

        <div class="font-courier overflow-x-scroll mb-3">
            <p v-for="item in logs.data" style="white-space: nowrap;">
                {{ item.user.first_name }} {{ item.user.last_name }} ({{ item.user.email }})
                [<span :style="'color: ' + item.action.color">{{ item.action.name.toUpperCase() }}</span>]
                {{ item.occured }} |
                {{ item.operation }}
            </p>
        </div>

        <Paginator :items="logs"/>

    </BasePage>
</template>

<style scoped>
.font-courier {
    font-family: Menlo, Monaco, Consolas, Liberation Mono, Courier New, monospace;
}

.font-courier p {
    margin: 0;
}

.font-courier p:hover {
    font-weight: 700;
}
</style>
