<?php

namespace FatemeMahmoodi\LaravelToDo\Http\Requests\Task;

use FatemeMahmoodi\LaravelToDo\Enums\TaskStatus;
use FatemeMahmoodi\LaravelToDo\Enums\TaskStatusEnums;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
      return  Auth::check() ;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string',
            'description' => 'required|string',
            'status' => 'in:' . implode(',' , TaskStatus::ALL),
            'labels' => 'array',
            'labels.*' => 'required|exists:labels,id'
        ];
    }
}
