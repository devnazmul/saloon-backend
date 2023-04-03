<?php

namespace App\Http\Requests;

use App\Rules\TimeValidation;
use Illuminate\Foundation\Http\FormRequest;

class FuelStationCreateRequest extends FormRequest
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
            "name" => "required|string",
            "address" => "required|string",
            "opening_time"=> ['required','date_format:H:i', new TimeValidation
        ],
            "closing_time" => ['required','date_format:H:i', new TimeValidation
            ],
            "description" => "nullable|string",
            'lat' => 'nullable|string',
            'long' => 'nullable|string',

            "options" => "nullable|array",
            "options.*.option" => "required_if:options,!=,null|string",
            "options.*.is_active" => "required_if:options,!=,null|boolean",


        ];
    }
}
