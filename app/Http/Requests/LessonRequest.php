<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule as ValidationRule;
use Illuminate\Validation\Rules\File;

class LessonRequest extends FormRequest
{
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
            'name' => ['required', 'string', 'max:100', ValidationRule::unique(table: 'lessons', column: 'name')->ignore(id: request('lesson'), idColumn: 'id')],   //
            'description' => ['required', 'string', 'max:150'],
            'level_id' => ['required', 'exists:levels,id'],
            'categories' => ['required'],
            'content' => ['sometimes', 'required', File::types('zip')->max(5 * 1024)],
            'pdf' => ['sometimes', 'required', File::types('pdf')->max(2 * 1024)], 
            'image' => ['sometimes', 'required', File::image()->max(2 * 1024)],
            'content_update' => ['nullable',  File::types('zip')->max(5 * 1024)],
            'pdf_update' => ['nullable', File::types('pdf')->max(2 * 1024)], 
            'image_update' => ['nullable', File::image()->max(2 * 1024)]
        ];
    }
}