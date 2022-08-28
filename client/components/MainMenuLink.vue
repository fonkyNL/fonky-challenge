<template>
  <NuxtLink
    :to="to"
    custom
    v-slot="{ href, navigate, isActive }"
  >
    <a 
      :active="isActive" 
      :href="href" 
      @click="navigate"
      class="text-white group flex items-center px-2 py-2 text-base md:text-sm font-medium rounded-md"
      :class="{ 
        'bg-sky-500 text-white': isActive,
        'text-gray-700': !isActive
      }"
    >
      <slot />
    </a>
  </NuxtLink>
</template>

<script>
import { Vue, Component, Prop } from 'nuxt-property-decorator'

export default {
  props: ['to']
}

</script>
