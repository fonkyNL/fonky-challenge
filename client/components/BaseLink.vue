<template>
  <NuxtLink
    :to="to"
    class="font-medium text-sky-600 hover:text-sky-500"
  >
    <slot />
  </NuxtLink>
</template>

<script>
export default {
  props: ['to']
}
</script>