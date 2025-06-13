<?php

namespace App\Http\Requests;

use App\Enums\TaskPriorityEnum;
use App\Enums\TaskStatusEnum;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTaskRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'min:5', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'status' => ['required', 'numeric', Rule::in(array_column(TaskStatusEnum::cases(), 'value'))],
            'due_date' => ['required', 'date_format:Y-m-d H:i', 'after:now'],
            'priority' => ['required', 'numeric', Rule::in(array_column(TaskPriorityEnum::cases(), 'value'))],
        ];
    }
    
}
