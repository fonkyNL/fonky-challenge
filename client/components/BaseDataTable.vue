<template>
  <div class="flex flex-col">
    <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
      <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
        <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
          <table class="min-w-full divide-y divide-gray-300">
            <thead class="bg-gray-50">
              <tr>
                <th v-for="header in tableHeader" :key="header.label" scope="col"
                  class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                  {{ header.label }}
                </th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
              <tr v-for="tableRow in tableRows">
                <td v-for="header in tableHeader"
                  class="whitespace-nowrap py-4 pl-4 pr-3 text-sm text-gray-900">
                  {{ tableRow[header.name] }}
                </td>
              </tr>
            </tbody>
          </table>
          
          <div class="bg-gray-50 px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
            <div class="flex-1 flex justify-between sm:hidden">
              <a href="#"
                class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                Previous
              </a>
              <a href="#"
                class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                Next
              </a>
            </div>
            <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
              <div>
                <p class="text-sm text-gray-700">
                  Showing
                  <span class="font-medium">{{ showAmountRecordsFrom }}</span>
                  to
                  <span class="font-medium">{{ showAmountRecordsTo }}</span>
                  of
                  <span class="font-medium">{{ totalRecords }}</span>
                  results
                </p>
              </div>
              <div>
                <nav class="relative z-0 inline-flex rounded-md -space-x-px" aria-label="Pagination">
                  <div class="flex-1 flex">
                    <button
                      @click="onPrevious()"
                      class="relative inline-flex items-end px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                      Previous
                    </button>
                    <button
                      @click="onNext()"
                      class="ml-3 relative inline-flex items-end px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                      Next
                    </button>
                  </div>
                </nav>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import qs from 'qs'

export default {
  props: [
    'tableHeader', 
    'tableRows', 
    'showAmountRecordsFrom', 
    'showAmountRecordsTo', 
    'totalRecords', 
    'next', 
    'previous'
  ],

  methods: {
    fetchsRows(params = {}) {
      this.$emit('onFetchRows', qs.stringify(params))
    },
    fetchHeader() {
      this.$emit('onFetchHeader')
    },
    onNext() {
      if (this.next !== null) {
        this.fetchsRows({
          page: this.next
        })
      }
    },
    onPrevious() {
      if (this.previous !== null) {
        this.fetchsRows({
          page: this.previous
        })
      }
    },
  },

  mounted() {
    this.fetchsRows()
    this.fetchHeader()
  }
}
</script>