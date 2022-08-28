<template>
  <div>
    <AppSidebar />      
    <div class="md:pl-64 flex flex-col">
      <main class="flex-1">
        <div class="py-6">
          <slot/>
        </div>
      </main>
    </div>
  </div>
</template>