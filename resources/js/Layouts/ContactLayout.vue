<template>
    <header>
        <div v-if="$slots.header" class="mx-auto px-3">
            <slot name="header" />
        </div>
    </header>
    <div class="container">
        <slot />
    </div>
</template>