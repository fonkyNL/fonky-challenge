import { useQuery } from "@tanstack/vue-query";
import axios from "axios";
import { computed, Ref } from "vue";
import type { ApiResponse, Metric, RegionMetricName } from "../types";

export function useRegionMetricsQuery(
  regionId: Ref<number | undefined>,
  metricName: RegionMetricName
) {
  const enabled = computed(() => !!regionId.value);

  return useQuery({
    queryKey: ["region_metrics", regionId, metricName],
    queryFn: () =>
      axios
        .get<ApiResponse<Metric>>(`/api/regions/${regionId.value}/metrics`, {
          params: { metric: metricName },
        })
        .then((response) => response.data.data),
    enabled,
  });
}
