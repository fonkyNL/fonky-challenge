import { useQuery } from "@tanstack/vue-query";
import axios from "axios";
import type { ApiResponse, Region } from "../types";

export function useRegionsQuery() {
  return useQuery(["regions"], () =>
    axios
      .get<ApiResponse<Region[]>>("/api/regions")
      .then((response) => response.data.data)
  );
}
