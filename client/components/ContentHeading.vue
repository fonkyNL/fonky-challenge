<template>
  <div class="flex-no-shrink">
    <h1 class="text-2xl font-semibold text-gray-900">
      <NuxtLink 
        v-if="breadCrumbShown"
        class="text-primary"
        :to="backLink"
      >
        {{ backTitle }} /
      </NuxtLink>
      {{ title }}
    </h1>
  </div>
</template>

<script>
import { Vue, Component, Prop } from 'nuxt-property-decorator'

export default {
  props: ['title', 'backTitle', 'backLink'],

  computed: {
    breadCrumbShown() {
      return this.backTitle && this.backLink
    }
  }
}
</script>
