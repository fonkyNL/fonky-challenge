<script setup lang="ts">
import { computed, ref, watch } from "vue";
import { useRegionsQuery } from "../queries/regionsQuery";
import {
  Listbox,
  ListboxButton,
  ListboxOptions,
  ListboxOption,
} from "@headlessui/vue";
import { Region } from "../types";
import RegionMetric from "../components/RegionMetric.vue";
import { formatPercent } from "@/utils/numberFormat";
import AppListItem from "../components/AppListItem.vue";
import AppList from "../components/AppList.vue";
import { useRegionSellersQuery } from "../queries/regionSellersQuery";
import { useRegionProductsQuery } from "../queries/regionProductsQuery";
import { Icon } from "@iconify/vue";

const selectedRegion = ref<Region | undefined>();

const { data: regions, isFetched } = useRegionsQuery();

watch(isFetched, () => {
  if (regions.value) {
    selectedRegion.value = regions.value[0];
  }
});

const regionId = computed(() => selectedRegion.value?.id);

const { data: topSellers } = useRegionSellersQuery(regionId);
const { data: topProducts } = useRegionProductsQuery(regionId);
</script>

<template>
  <div class="w-72 relative">
    <Listbox v-model="selectedRegion">
      <ListboxButton>
        <h1 class="relative text-3xl font-semibold pr-8 mt-10">
          {{ selectedRegion?.name }}

          <Icon icon="mdi:chevron-down" class="absolute top-[6px] right-0" />
        </h1>
      </ListboxButton>

      <ListboxOptions
        class="absolute mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm"
      >
        <ListboxOption
          v-for="region in regions"
          :key="region.id"
          :value="region"
          v-slot="{ active, selected }"
        >
          <li
            :class="[
              active ? 'bg-amber-100 text-amber-900' : 'text-gray-900',
              'relative cursor-default select-none py-2 px-4',
              selected ? 'font-bold' : 'font-normal',
            ]"
          >
            {{ region.name }}
          </li>
        </ListboxOption>
      </ListboxOptions>
    </Listbox>
  </div>

  <section class="flex gap-6 mt-6">
    <RegionMetric
      :region-id="selectedRegion?.id"
      label="Total Sales"
      metric-name="total_sales"
    />
    <RegionMetric
      :region-id="selectedRegion?.id"
      label="% In Total"
      metric-name="region_sales_ratio"
      v-slot="{ value }"
    >
      {{ formatPercent(value || 0) }}
    </RegionMetric>
    <RegionMetric
      :region-id="selectedRegion?.id"
      label="Rankings"
      metric-name="region_rank"
    />
  </section>

  <section class="mt-6 flex items-start gap-6">
    <section class="flex-1">
      <h3 class="mb-2 font-bold">Top Sellers</h3>

      <AppList>
        <AppListItem v-for="(seller, index) in topSellers" :key="index">
          <p>{{ index + 1 }}. {{ seller.seller }}</p>
          <p class="font-bold">{{ seller.sales }}</p>
        </AppListItem>
      </AppList>
    </section>
    <section class="flex-1">
      <h3 class="mb-2 font-bold">Top Products</h3>

      <AppList>
        <AppListItem v-for="(product, index) in topProducts" :key="index">
          <p>{{ index + 1 }}. {{ product.product }}</p>
          <p class="font-bold">{{ product.sales }}</p>
        </AppListItem>
      </AppList>
    </section>
  </section>
</template>
