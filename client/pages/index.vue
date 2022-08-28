<template>

</template>

<script>
export default {
  middleware({ store, redirect }) {
    return redirect('/orders')
  }
}
</script>
