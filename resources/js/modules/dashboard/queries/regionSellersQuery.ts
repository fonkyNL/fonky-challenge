import { useQuery } from "@tanstack/vue-query";
import axios from "axios";
import { computed, Ref } from "vue";
import type { ApiResponse, Seller } from "../types";

export function useRegionSellersQuery(regionId: Ref<number | undefined>) {
  const enabled = computed(() => !!regionId.value);

  return useQuery({
    queryKey: ["region_sellers", regionId],
    queryFn: () =>
      axios
        .get<ApiResponse<Seller[]>>(`/api/regions/${regionId.value}/sellers`)
        .then((response) => response.data.data),
    enabled,
  });
}
