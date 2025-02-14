<?php

namespace App\Http\Requests;

use App\Services\PermissionsService;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return PermissionsService::UserAssociatedWithSupplier($this->user(), $this->input('supplier_id'));
    }

    public function rules(): array
    {
        return [
            'name'           => 'required|string|max:255',
            'description'    => 'nullable|string',
            'price'          => 'required|numeric|min:0|max:999999.99',
            'stock_quantity' => 'required|integer|min:0',
            'sku'            => 'required|string|max:100|unique:products,sku',
            'image_url'      => 'nullable|string|max:255|url',
            'weight'         => 'nullable|numeric|min:0|max:9999.99',
            'additional'     => 'nullable|array',
            'status'         => 'nullable|string|max:50|in:active,inactive,draft',
            'rating'         => 'nullable|numeric|min:0|max:5',
            'supplier_id'    => 'required|integer'
        ];
    }
}
