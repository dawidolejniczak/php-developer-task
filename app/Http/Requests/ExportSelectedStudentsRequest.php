<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExportSelectedStudentsRequest extends FormRequest
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
    public function rules(): array
    {
        if (!is_array($this->request->get('studentId'))) {
            return [
                'studentId' => 'required|array'
            ];
        }

        $rules = [];
        if (count($this->request->get('studentId')) > 0) {
            foreach ($this->request->get('studentId') as $key => $val) {
                $rules['studentId.' . $key] = 'integer|exists:student,id';
            }
        }

        return $rules;
    }
}
