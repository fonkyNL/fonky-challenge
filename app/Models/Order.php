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
    ): Collection
    {
        $query = $this->select("$groupBy as supplier", DB::raw("$type(donation) as amount"));

        if ($dateFrom && $dateTo) {
            $query->whereBetween('date_sold', [$dateFrom, $dateTo]);
        } elseif ($dateFrom) {
            $query->where('date_sold', '>=', $dateFrom);
        } elseif ($dateTo) {
            $query->where('date_sold', '<=', $dateTo);
        }

        if ($where !== "") {
            $query->where($groupBy === 'branch' ? 'seller' : 'branch', $where);
        }

        $query->groupBy($groupBy)
            ->orderBy("amount", $order);

        return $query->get();
    }
}
