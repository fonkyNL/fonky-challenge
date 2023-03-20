export interface Region {
  id: number;
  name: string;
}

export interface ApiResponse<T> {
  data: T;
}

const regionMetrics = [
  "total_sales",
  "region_sales_ratio",
  "region_rank",
] as const;

export type RegionMetricName = typeof regionMetrics[number];

export interface Metric {
  name: string;
  value: number;
}

export interface Seller {
  seller: string;
  sales: number;
}

export interface Product {
  product: string;
  sales: number;
}
