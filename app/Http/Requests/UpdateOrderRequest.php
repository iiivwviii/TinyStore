<?php

namespace App\Http\Requests\Admin;

use App\Models\Order;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateOrderRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'status' => ['required', Rule::in([Order::STATUS_CONFIRMED, Order::STATUS_CANCELLED])],
        ];
    }
}
