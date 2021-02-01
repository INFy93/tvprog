<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LogoRequest extends FormRequest
{
        /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
                'logo' => 'mimes:jpg,jpeg,bmp,png,svg' //проверка расширения файла
              ];
    }

    public function messages()
    {
      return [
      'logo.mimes' => 'Файл должен быть в формате JPEG, PNG, BMP или SVG!'
      ];
    }
}
