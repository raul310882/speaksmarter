<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
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
            'content' => ['excludeIf:updating,true', 'required', 'file', 'extensions:zip'],
            'pdf' => ['excludeIf:updating,true', 'required', 'file', 'extensions:pdf'],
            'image' => ['excludeIf:updating,true', 'required', 'image'],
            'content_update' => ['excludeIf:updating,false', 'nullable', 'file', 'extensions:zip'],
            'pdf_update' => ['excludeIf:updating,false', 'nullable', 'file', 'extensions:pdf'],
            'image_update' => ['excludeIf:updating,false', 'nullable', 'image']
        ];
    }
}