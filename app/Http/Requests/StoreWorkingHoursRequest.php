<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreWorkingHoursRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'open_start' => 'nullable|date',
            'close_start' => 'required|date', 
            'supplier_id' => 'required|exists:suppliers,id',
            'is_active' => 'required|boolean', 
            'average_time' => 'nullable|integer|min:0',
            'delivery_fee' => 'nullable|numeric|min:0|max:999999.99', 
            'coverage_area' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255',
            'average_rating' => 'nullable|numeric|min:0|max:5', 
            'order_limit' => 'nullable|integer|min:1',
        
            'working_hours' => 'required|array|size:7',
            'working_hours.*.day_of_week' => 'required|string|in:Monday,Tuesday,Wednesday,Thursday,Friday,Saturday,Sunday',
            'working_hours.*.is_closed' => 'required|boolean',
            'working_hours.*.opening_time' => 'required|date_format:H:i:s', 
            'working_hours.*.closing_time' => 'required|date_format:H:i:s',
        ];
    }
}
