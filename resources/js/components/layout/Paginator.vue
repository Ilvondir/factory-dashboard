<script setup lang="ts">
import {type Pagination} from "@/models/pagination";

defineProps<{
    items: Pagination<any>
}>()
</script>

<template>
    <nav class="d-flex justify-content-center mt-3">
        <ul class="pagination">
            <li class="page-item">
                <inertia-link class="page-link" :href="items.first_page_url"
                              preserve-scroll>
                    <span><i class="bi bi-chevron-double-left"></i></span>
                </inertia-link>
            </li>

            <li class="page-item" v-if="items.prev_page_url">
                <inertia-link class="page-link" :href="items.prev_page_url"
                              preserve-scroll>
                    <span><i class="bi bi-chevron-left"></i></span>
                </inertia-link>
            </li>

            <template v-for="i in [5,4,3,2,1]">
                <li v-if="items.current_page - i > 0" class="page-item">
                    <inertia-link :href="items.links[items.current_page - i].url" class="page-link"
                                  preserve-scroll>
                        <span>{{ items.current_page - i }}</span>
                    </inertia-link>
                </li>
            </template>

            <li class="page-item active">
                    <span class="page-link">
                        <span>{{ items.current_page }}</span>
                    </span>
            </li>

            <template v-for="i in [1,2,3,4,5]">
                <li v-if="items.current_page + i <= items.last_page" class="page-item">
                    <inertia-link :href="items.links[items.current_page + i].url" class="page-link"
                                  preserve-scroll>
                        <span>{{ items.current_page + i }}</span>
                    </inertia-link>
                </li>
            </template>

            <li class="page-item" v-if="items.next_page_url">
                <inertia-link class="page-link" :href="items.next_page_url"
                              preserve-scroll>
                    <span><i class="bi bi-chevron-right"></i></span>
                </inertia-link>
            </li>

            <li class="page-item">
                <inertia-link class="page-link" :href="items.last_page_url"
                              preserve-scroll>
                    <span><i class="bi bi-chevron-double-right"></i></span>
                </inertia-link>
            </li>
        </ul>
    </nav>
</template>
