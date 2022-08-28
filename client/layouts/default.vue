<template>
  <div class="md:flex md:flex-col">
    <AppMainContainer>
      <transition name="page" mode="out-in">
        <Nuxt/>
      </transition>
    </AppMainContainer>
  </div>
</template>