<template>
  <div>
    <div class="fixed inset-0 flex z-40 md:hidden" role="dialog" aria-modal="true">
      <div class="fixed inset-0 bg-gray-600 bg-opacity-75" aria-hidden="true"></div>
      <div class="relative flex-1 flex flex-col max-w-xs w-full pt-5 pb-4 bg-gray-800">
        <div class="absolute top-0 right-0 -mr-12 pt-2">
          <button type="button" class="ml-1 flex items-center justify-center h-10 w-10 rounded-full focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white">
            <span class="sr-only">Close sidebar</span>
            <svg class="h-6 w-6 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
          </button>
        </div>
        <div class="flex-shrink-0 flex items-center px-4">
          <h1 class="text-white text-2xl font-semibold">Fonky</h1>
        </div>
        <div class="mt-5 flex-1 h-0 overflow-y-auto">
          <MainMenu class="px-2 space-y-1" />
        </div>
      </div>
      <div class="flex-shrink-0 w-14" aria-hidden="true">
      </div>
    </div>
    <div class="hidden md:flex md:w-64 md:flex-col md:fixed md:inset-y-0">
      <div class="flex-1 flex flex-col min-h-0 bg-white border-r-2 border-gray-200">
        <div class="flex items-center h-16 flex-shrink-0 px-4">
          <h1 class="text-sky-500 text-2xl font-semibold">Fonky</h1>
        </div>
        <div class="flex-1 flex flex-col overflow-y-auto">
          <MainMenu class="flex-1 px-2 py-4 space-y-1" />
        </div>
      </div>
    </div>
  </div>
</template>
