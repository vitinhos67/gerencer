<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_address_id' => 'nullable|integer|exists:user_addresses,id',
            'delivery_type' => 'required|string|max:255|in:pickup,delivery',
            'status_id' => 'required|integer|exists:order_statuses,id',
            'products' => 'required|array',
            'products.*.product_id' => 'required|exists:products,id',
            'products.*.quantity' => 'required|integer|min:1',
        
            // 'address' é obrigatório se 'user_address_id' não for enviado e 'delivery_type' for 'delivery'
            'address' => 'required_if:delivery_type,delivery|required_without:user_address_id|array',
            'address.street' => 'required_with:address|string',
            'address.number' => 'required_with:address|string',
            'address.complement' => 'nullable|string',
            'address.neighborhood' => 'required_with:address|string',
            'address.city' => 'required_with:address|string',
            'address.state' => 'required_with:address|string',
            'address.zip_code' => 'required_with:address|string',
        ];
    }
}
