<script setup lang="ts">
import { PropType, toRef } from "vue";
import { RegionMetricName } from "../types";
import { useRegionMetricsQuery } from "../queries/regionMetricsQuery";

const props = defineProps({
  regionId: Number,
  metricName: {
    type: String as PropType<RegionMetricName>,
    required: true,
  },
  label: {
    type: String,
    required: true,
  },
});

const regionId = toRef(props, "regionId");

const { data } = useRegionMetricsQuery(regionId, props.metricName);
</script>

<template>
  <article
    class="bg-white p-4 rounded-md shadow-2xl shadow-gray-200 min-w-[240px]"
  >
    <p class="font-semibold text-gray-500">{{ label }}</p>
    <p class="text-[48px] font-semibold">
      <slot :value="data?.value">{{ data?.value }}</slot>
    </p>
  </article>
</template>
