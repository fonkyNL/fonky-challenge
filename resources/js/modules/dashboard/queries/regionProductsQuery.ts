import { useQuery } from "@tanstack/vue-query";
import axios from "axios";
import { computed, Ref } from "vue";
import type { ApiResponse, Product } from "../types";

export function useRegionProductsQuery(regionId: Ref<number | undefined>) {
  const enabled = computed(() => !!regionId.value);

  return useQuery({
    queryKey: ["region_products", regionId],
    queryFn: () =>
      axios
        .get<ApiResponse<Product[]>>(`/api/regions/${regionId.value}/products`)
        .then((response) => response.data.data),
    enabled,
  });
}
