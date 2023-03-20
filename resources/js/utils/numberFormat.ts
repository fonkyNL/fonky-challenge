export function formatPercent(amount: number) {
  const formatter = new Intl.NumberFormat("en-US", { style: "percent" });

  return formatter.format(amount);
}
