<?php

namespace App\Http\Requests\Post;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class StorePostRequest extends FormRequest
{
    public static array $extensions = [
            'jpg', 'jpeg', 'png', 'gif', 'webp', 'svg',
            'mp3', 'wav', 'mp4',
            'doc', 'docx', 'pdf', 'csv', 'xls', 'xlsx',
            'zip', 'txt'
    ];
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
                'body'    => ['nullable', 'string'],
                'user_id' => ['numeric'],
                'attachments' => 'array|max:10',
                'attachments.*' => [
                    'file',
                    File::types(self::$extensions)->max(500 * 1024 * 1024)
                ]
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
                'user_id' => auth()->id(),
                'body'    => $this->input('body') ?: '',
        ]);
    }

    public function messages()
    {
        return [
                'attachments.*' => 'Invalid file'
        ];
    }
}
