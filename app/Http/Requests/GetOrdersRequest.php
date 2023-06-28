<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetOrdersRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'supplier' => 'required|string|in:seller,branch',
            'type' => 'required|string|in:SUM,AVG,COUNT',
            'where' => 'sometimes|string',
            'dateFrom' => 'sometimes|string',
            'dateTo' => 'sometimes|string|after_or_equal:start_date'
        ];
    }
}
