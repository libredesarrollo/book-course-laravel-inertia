<template>
    <!-- <Link class="px-2 py-1" v-if="!l.active" :href="l.url">{{ l.label }}</Link>
        <span class="px-2 py-1 cursor-pointer text-gray-500" v-else>{{ l.label }}</span> -->

    <div class="flex mt-5">
         <Component v-for="l in links" :key="l" :is="!l.active ? 'Link' :'span'" class="px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 ml-2" :class="!l.active ? '' : 'text-gray-500 cursor-pointer'" :href="l.url ?? ''" v-html="l.label" />
    </div>

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