<?php

namespace App\Http\Requests\Trade;

use Illuminate\Foundation\Http\FormRequest;

class PayRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'auth' => 'required|string',
            'order_id' => 'required|string',
            'payway' => 'required|string',
            'item' => 'required|string',
            'amount' => 'required|integer|min:0',
            'customer_id' => 'required|integer',
            'currency' => 'required|in:TWD',
        ];
    }
}
