<template>
    <div class="mb-3" v-for="c in $page.props.cart" :key="c">
        <input :value="c[1]" type="number" class="w-20"> {{ c[0].title }}
    </div>
</template>