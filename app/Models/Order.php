<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    protected $fillable = [
        'buyer',
        'date_sold',
        'donation',
        'branch',
        'seller'
    ];

    const ORDER_DIRECTION = 'DESC';
    const GROUP_BY = 'branch';
    const TYPE = 'SUM';

    public function getDonationMetric(
        string $groupBy = self::GROUP_BY,
        string $type = self::TYPE,
        string $where = "",
        string $dateFrom = null,
        string $dateTo = null,
        string $order = self::ORDER_DIRECTION,
    ): Collection {
        $query = $this->buildQuery($groupBy, $type, $where, $dateFrom, $dateTo, $order);

        return $query->get();
    }

    protected function buildQuery(
        string $groupBy,
        string $type,
        string $where,
        ?string $dateFrom,
        ?string $dateTo,
        string $order
    ) {
        $query = $this->select("$groupBy as supplier", DB::raw("$type(donation) as amount"));

        $this->applyDateFilters($query, $dateFrom, $dateTo);
        $this->applyWhereCondition($query, $groupBy, $where);

        $query->groupBy($groupBy)
            ->orderBy("amount", $order);

        return $query;
    }

    protected function applyDateFilters($query, ?string $dateFrom, ?string $dateTo): void
    {
        if ($dateFrom && $dateTo) {
            $query->whereBetween('date_sold', [$dateFrom, $dateTo]);
        } elseif ($dateFrom) {
            $query->where('date_sold', '>=', $dateFrom);
        } elseif ($dateTo) {
            $query->where('date_sold', '<=', $dateTo);
        }
    }

    protected function applyWhereCondition($query, string $groupBy, string $where): void
    {
        if ($where !== "") {
            $field = $groupBy === 'branch' ? 'seller' : 'branch';
            $query->where($field, $where);
        }
    }
}
