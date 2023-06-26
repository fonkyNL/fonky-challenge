<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DonationSummaryResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'supplier' => $this->supplier,
            'amount' => $this->amount,
        ];
    }
}
