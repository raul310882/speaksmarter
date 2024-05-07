<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illiminate\Validation\Rule;
use Illuminate\Validation\Rule as ValidationRule;

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
            'name' => ['required', 'string', 'max:100', ValidationRule::unique(table: 'lessons', column: 'name')->ignore(id: request('lesson'), idColumn: 'id')],
            'description' => ['required', 'string', 'max:150'],
            'level_id' => ['required', 'exists:levels,id'],
            'categories' => ['required'],
            'content' => ['required', 'file', 'extensions:zip'],
            'pdf' => ['required', 'file', 'extensions:pdf'],
            'image' => ['required', 'image']


           /*  'description' => 'required|string|max:150',
            'level_id' => 'required|exists:levels',
            'is_free' => 'required|boolean',
             */
        ];
    }
}
        /* level_id: 0,
        categories: [],
        is_free: false,
        image: null,
        pdf: null,
        content: null */