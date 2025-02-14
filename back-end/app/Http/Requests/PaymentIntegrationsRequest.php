<?php

namespace App\Http\Requests;

use App\Services\PermissionsService;
use Illuminate\Foundation\Http\FormRequest;

class PaymentIntegrationsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return PermissionsService::UserAssociatedWithSupplier($this->user(), $this->input('supplier_id'));
    }

    public function rules(): array
    {
        return [
            'provider' => 'required|string',
            'secret_key' => 'nullable|string',
            'public_key' => 'nullable|string',
            'access_token' => 'nullable|string',
            'supplier_id' => 'required|integer|exists:suppliers,id',
            'user' => 'nullable|integer',
            'active' => 'required|boolean'
        ];
    }
}
