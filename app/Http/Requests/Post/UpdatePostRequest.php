<?php

namespace App\Http\Requests\Post;

class UpdatePostRequest extends StorePostRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $post = $this->route('post');

        return $post->user_id == auth()->id();
    }

    public function rules(): array
    {
        return array_merge(parent::rules(), [
                'deleted_file_ids' => 'array',
                'deleted_file_ids.*' => 'numeric'
        ]);
    }
}
