<script setup lang="ts">
import {type Pagination} from "@/models/pagination";

defineProps<{
    items: Pagination<any>
}>()
</script>

<template>
    <nav class="d-flex justify-content-center">
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

            <li v-if="items.current_page - 2 > 0" class="page-item">
                <inertia-link :href="items.links[items.current_page - 2].url" class="page-link"
                              preserve-scroll>
                    <span>{{ items.current_page - 2 }}</span>
                </inertia-link>
            </li>

            <li v-if="items.current_page - 1 > 0" class="page-item">
                <inertia-link :href="items.links[items.current_page - 1].url" class="page-link"
                              preserve-scroll>
                    <span>{{ items.current_page - 1 }}</span>
                </inertia-link>
            </li>

            <li class="page-item active">
                    <span class="page-link">
                        <span>{{ items.current_page }}</span>
                    </span>
            </li>

            <li v-if="items.current_page + 1 <= items.last_page" class="page-item">
                <inertia-link :href="items.links[items.current_page + 1].url" class="page-link"
                              preserve-scroll>
                    <span>{{ items.current_page + 1 }}</span>
                </inertia-link>
            </li>

            <li v-if="items.current_page + 2 <= items.last_page" class="page-item">
                <inertia-link :href="items.links[items.current_page + 2].url" class="page-link"
                              preserve-scroll>
                    <span>{{ items.current_page + 2 }}</span>
                </inertia-link>
            </li>

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
