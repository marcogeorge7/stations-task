<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:App\Models\User,id',
            'trip_id' => 'required|exists:App\Models\Trip,id',
            'start' => 'required|exists:App\Models\Station,id',
            'end' => 'required|exists:App\Models\Station,id',
            'seat_number' => 'required|numeric|between:1,60'
        ];
    }
}
