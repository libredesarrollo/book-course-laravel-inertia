<script setup lang="ts">
import AppLayout from '@/layouts/app/AppSidebarLayout.vue';
import type { BreadcrumbItemType } from '@/types';

import { ref } from 'vue';

interface Props {
    breadcrumbs?: BreadcrumbItemType[];
}

// flash message
const visibleFlashContainer = ref(true);


const hideFlashMessage = () => {
    setTimeout(() => (visibleFlashContainer.value = false), 4000);
    return true;
};

withDefaults(defineProps<Props>(), {
    breadcrumbs: () => [],
});

</script>

<template>

    <AppLayout :breadcrumbs="breadcrumbs">
        <transition>
            <div v-if="visibleFlashContainer" class="mx-3">
                <div v-if="$page.props.flash.message && hideFlashMessage()" class="
                        container
                        my-2
                        bg-purple-300
                        text-purple-800
                        px-4
                        py-3
                        rounded
                        shadow-sm
                    ">
                    {{ $page.props.flash.message }}
                </div>
            </div>
        </transition>
        <slot />
    </AppLayout>
</template>
