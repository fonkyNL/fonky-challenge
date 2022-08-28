<template>
  <button 
    :disabled="loading" 
    v-bind="$attrs" 
    @click="onClick" 
    class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-sky-500 hover:bg-sky-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-sky-600"
  >
    <div v-if="loading" class="btn-spinner mr-2" />
    <slot />
  </button>
</template>

<script>
export default {
  props: ['loading'],

  methods: {
    onClick(event) {
      this.$emit('click', event)
    }
  }
}
</script>
