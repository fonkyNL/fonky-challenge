<template>
  <div class="entities">
    <div class="px-4 sm:px-6 md:px-8">
      <ContentHeading title="My Orders" />
    </div>
    <div class="pt-10 pb-10 sm:px-6 md:px-8">
      <BaseDataTable 
        :tableHeader="tableHeader" 
        :tableRows="tableRowsData.data"
        :showAmountRecordsFrom="tableRowsData.from"
        :showAmountRecordsTo="tableRowsData.to"
        :totalRecords="tableRowsData.total"
        :next="tableRowsData.next"
        :previous="tableRowsData.previous"
        @onFetchHeader="fetchTableHeader"
        @onFetchRows="fetchTableRows"
      />
    </div>
  </div>
</template>

<script>
import PageMixin from "@/mixins/page";
import axios, { AxiosError } from "axios";
import { UserService } from "@/services/user";

export default {
  name: "orders",
  mixins: [PageMixin],

  data() {
    return {
      tableHeader: [],
      tableRowsData: {
        data: [],
        showAmountRecordsFrom: 0,
        showAmountRecordsTo: 0,
        totalRecords: 0,  
        next: null,
        previous: null
      }
    };
  },

  methods: {
    async fetchTableHeader() {
      try {
        const { data } = await UserService.orders.getTableHeader();
        
        this.tableHeader = data;
      } catch (err) {
        const error = err;

        if (! axios.isAxiosError(error)){
          throw err
        }
      }
    },
    async fetchTableRows(query) {
      try {
        const { data } = await UserService.orders.getTableRows(query)
        
        this.tableRowsData = data
      } catch (err) {
        const error = err 

        if (! axios.isAxiosError(error)){
          throw err
        }
      }
    }
  },
};
</script>
