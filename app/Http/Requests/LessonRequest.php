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
            'name' => ['required', 'string', 'max:100', ValidationRule::unique(table: 'lessons', column: 'name')->ignore(id: request('lesson'), idColumn: 'id')],   //
            'description' => ['required', 'string', 'max:150'],
            'level_id' => ['required', 'exists:levels,id'],
            'categories' => ['required'],
           //'content' => ['exclude_with:content_update', 'required', 'file', 'extensions:zip'],
            //'pdf' => ['exclude_with:pdf_update', 'required', 'file', 'extensions:pdf'],
            'image' => ['exclude_with:image_update','required', 'image'],
            /* 'content_update' => ['exclude_with,content',  'file', 'extensions:zip'],
            'pdf_update' => ['exclude_with,pdf', 'file', 'extensions:pdf'], */
            //'image_update' => ['exclude_with,image', 'image']
        ];
    }
}