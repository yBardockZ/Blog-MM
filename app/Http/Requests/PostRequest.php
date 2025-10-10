<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|max:255',
            'content' => 'required',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'tags' => 'array',
            'tags.*' => 'exists:tags,id',
        ];
    }
    public function messages(): array
    {
        return [
            'title.required' => 'O título é obrigatório.',
            'content.required' => 'O conteúdo é obrigatório.',
            'image.image' => 'O arquivo enviado deve ser uma imagem.',
            'image.mimes' => 'A imagem deve estar no formato JPEG, JPG ou PNG.',
            'image.max' => 'A imagem não pode ter mais de 2MB.',
        ];
    }

}
