<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrderRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'send_to_kitchen_time' => [
                'required', 
                'date', 
                'after_or_equal:now'
            ],
            'concessions' => [
                'required', 
                'array', 
                'min:1'
            ],
            'concessions.*' => [
                'integer', 
                'min:1'
            ]
        ];
    }

    public function messages()
    {
        return [
            'send_to_kitchen_time.required' => 'Send to Kitchen Time is required.',
            'send_to_kitchen_time.date' => 'Send to Kitchen Time must be a valid date.',
            'send_to_kitchen_time.after_or_equal' => 'Send to Kitchen Time must be in the future.',
            'concessions.required' => 'Please select at least one concession.',
            'concessions.min' => 'Please select at least one concession.',
            'concessions.*.integer' => 'Invalid concession selection.',
            'concessions.*.min' => 'Quantity must be at least 1.'
        ];
    }
}