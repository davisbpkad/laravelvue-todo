<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTodoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $todo = $this->route('todo');
        
        // Admin can update any todo
        if (auth()->user()->isAdmin()) {
            return true;
        }
        
        // Users can only update their own todos
        return $todo && $todo->user_id === auth()->id();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['sometimes', 'string', 'max:255'],
            'description' => ['sometimes', 'nullable', 'string'],
            'completed' => ['sometimes', 'boolean'],
            'due_date' => ['sometimes', 'nullable', 'date', 'after_or_equal:today'],
            'priority' => ['sometimes', 'in:low,medium,high'],
            'user_id' => ['sometimes', 'exists:users,id'],
        ];
    }
}
