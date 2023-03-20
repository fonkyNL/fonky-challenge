<?php

namespace App\Http\Requests;

/**
 * @property-read string $metric
 */
class RegionMetricsRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'metric' => 'required',
        ];
    }
}
