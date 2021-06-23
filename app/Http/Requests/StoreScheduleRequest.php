<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreScheduleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return \Gate::allows('schedule_create');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // 'code' => [
            //     'required',
            // ],
            // 'register' => [
            //     'required',
            // ],
            'semester_id' => [
                'required',
            ],
            'periode_id' => [
                'required',
            ],
            'grade_id' => [
                'required',
            ],
            
        ];
    }
}
