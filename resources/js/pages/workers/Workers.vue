<script setup lang="ts">
import BasePage from "@/components/pages/BasePage.vue";
import {onMounted} from "vue";
import {type Worker} from "@/models/worker";


const props = defineProps<{
    workers: Worker[],
    canCreateWorkers: boolean
}>();

onMounted(() => {
    console.log(props);
})
</script>

<template>
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
            <tr v-for="(item, index) in workers">
                <th>{{ index + 1 }}</th>
                <td>{{ item.first_name + " " + item.last_name }}</td>
                <td>{{ item.position.name }}</td>
                <td>{{ item.hired }}</td>
            </tr>
            </tbody>
        </table>

    </BasePage>
</template>
