<template>
    <!-- <Link class="px-2 py-1" v-if="!l.active" :href="l.url">{{ l.label }}</Link>
        <span class="px-2 py-1 cursor-pointer text-gray-500" v-else>{{ l.label }}</span> -->
    <template v-for="l in links" v-bind:key="l">
        <Component
            class="px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white ml-2 hover:bg-gray-50"
            :is="!l.active ? 'Link' : 'span'" :href="l.url == null ? '#' : l.url"
            :class="!l.active ? '' : 'cursor-pointer text-gray-500'">{{ l.label }}</Component>
    </template>
</template>
<script>
import { Link } from '@inertiajs/vue3';
export default {
    components: {
        Link
    },
    props: {
        links: Array
    }
}
</script>