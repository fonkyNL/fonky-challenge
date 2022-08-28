<template>
  <input
    ref="input"
    :type="type"
    :id="inputId"
    v-bind="$attrs"
    autofocus="autofocus" 
    autocapitalize="off"
    @input="update"
    class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-sky-500 focus:border-sky-500 sm:text-sm"
  />
</template>

<script>
import cuid from 'cuid'

export default {
  props: ['type', 'id'],

  computed: {
    inputId() {
      return this.id ? this.id : cuid()
    }
  },

  methods: {
    update() {
      return this.input.value
    }
  }
}
</script>
