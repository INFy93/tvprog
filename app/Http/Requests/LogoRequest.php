<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LogoRequest extends FormRequest
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
                'logo' => 'mimes:jpeg,bmp,png,svg' //проверка расширения файла
              ];
    }

    public function messages()
    {
      return [
      'logo.mimes' => 'Файл должен быть в формате JPEG, PNG, BMP или SVG!'
      ];
    }
}
