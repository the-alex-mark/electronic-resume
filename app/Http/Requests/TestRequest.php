<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TestRequest extends FormRequest {

    #region Properties

    /**
     * @inheritDoc
     */
    protected $stopOnFirstFailure = false;

    /**
     * @var array Список доступных типов вопроса
     */
    public $types = [
        'choice',
        'free'
    ];

    #endregion

    /**
     * @inheritDoc
     */
    public function authorize() {
        return true;
    }

    /**
     * @inheritDoc
     */
    protected function passedValidation() {
        $questions = $this->get('questions');
        foreach ($questions as $index => $question) {
            $file = $this->file("questions.$index.image");
            $questions[$index]['image'] = (!empty($file))
                ? base64_encode(file_get_contents($file->getPathname()))
                : $this->get("questions.$index.image_base64", '');
        }

        $this->merge([ 'questions' => array_values($questions) ]);
    }

    /**
     * @inheritDoc
     */
    public function rules() {
        return [

            // Свойства
            'title' => [ 'bail', 'required', 'string' ],
            'description' => [ 'bail', 'nullable', 'string' ],
            'position_id' => [ 'bail', 'required', 'integer', 'min:0', 'exists:positions,id' ],
            'questions' => [ 'bail', 'required', 'array', 'min:1' ],

            // Вопрос
            'questions.*.question' => [ 'bail', 'required', 'string' ],
            'questions.*.type' => [ 'bail', 'required', 'string', 'in:' . implode(',', $this->types) ],
            'questions.*.image' => [ 'bail', 'nullable', 'file', 'image', 'min:1' ],
            'questions.*.image_base64' => [ 'bail', 'nullable', 'string' ],
            'questions.*.answers' => [ 'bail', 'exclude_unless:questions.*.type,choice', 'required', 'array', 'min:2' ],

            // Вариант ответа
            'questions.*.true' => [ 'bail', 'exclude_unless:questions.*.type,choice', 'required', 'integer', 'min:0' ],
            'questions.*.answers.*' => [ 'bail', 'required', 'string' ]
        ];
    }

    /**
     * @inheritDoc
     */
    public function messages() {
        return [
            'required' => 'Обязательное поле.'
        ];
    }

    /**
     * @inheritDoc
     */
    public function attributes() {
        return [
            'title' => 'название',
            'description' => 'описание',
            'position_id' => 'должность',
            'question' => 'вопрос',
            'image' => 'изображение',
            'answer' => 'вариант ответа',
            'is_true' => 'верный вариант ответа'
        ];
    }
}
