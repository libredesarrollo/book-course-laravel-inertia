<template>
    <main class="mx-auto flex h-full w-full max-w-7xl flex-1 flex-col gap-4 rounded-xl">
        <slot />
    </main>
    <cart-count/>
</template>
<script>
import CartCount from "@/Fragment/CartCount.vue"
export default {
  components:{
    CartCount
  }
}
</script>
