<?php

namespace App\Http\Requests;

use App\Models\Education;
use App\Models\Experience;
use App\Models\Summary;
use Illuminate\Foundation\Http\FormRequest;

class SummaryRequest extends FormRequest {

    #region Properties

    /**
     * @inheritDoc
     */
    protected $stopOnFirstFailure = false;

    #endregion

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * @inheritDoc
     */
    protected function passedValidation() {
        $this->merge([
            'user_id' => $this->user()->id
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return array_merge_recursive(
            Summary::getValidatorRules(),
            Education::getValidatorRules('educations.*.'),
            Experience::getValidatorRules('experiences.*.')
        );
    }

    /**
     * @inheritDoc
     */
    public function messages() {
        return [
            'required' => 'Обязательное поле.',
            'required_with' => 'Обязательное поле.',
            'position_id.*' => 'Укажите :attribute.',
            'city.*' => 'Укажите :attribute.',
            'floor.*' => 'Укажите :attribute.'
        ];
    }

    /**
     * @inheritDoc
     */
    public function attributes() {
        return array_merge(
            Summary::getValidatorAttributes(),
            Education::getValidatorAttributes('educations.*.'),
            Experience::getValidatorAttributes('experiences.*.')
        );
    }
}
