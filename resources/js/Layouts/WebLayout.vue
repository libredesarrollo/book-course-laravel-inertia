<template>
    <header>
        <div v-if="$slots.header" class="mx-auto px-3">
            <slot name="header" />
        </div>
    </header>
    <div class="container">
        <slot />
        <cart-count/>
    </div>
</template>
<script>
import CartCount from "@/Fragment/CartCount.vue"
export default {
  components:{
    CartCount
  }
}
</script>
