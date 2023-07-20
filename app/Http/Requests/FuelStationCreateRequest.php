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
            'lat' => 'required|string',
            'long' => 'required|string',

            "options" => "nullable|array",
            "options.*.option_id" => "required_if:options,!=,null|numeric",
            "options.*.is_active" => "required_if:options,!=,null|boolean",

            'country' => 'required|string',
            'city' => 'required|string',
            'postcode' => 'nullable|string',
            'address_line_1' => 'required|string',
            'address_line_2' => 'nullable|string',
            'additional_information' => 'nullable|string',

        ];
    }
}
