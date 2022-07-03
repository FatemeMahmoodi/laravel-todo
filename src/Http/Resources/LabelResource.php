<?php

namespace FatemeMahmoodi\LaravelToDo\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class LabelResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'tasks_count' => $this->tasks()
                ->creator(Auth::user())
                ->count()
        ];
    }
}
