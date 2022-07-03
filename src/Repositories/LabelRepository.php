<?php

namespace FatemeMahmoodi\LaravelToDo\Repositories;

use FatemeMahmoodi\LaravelToDo\Interfaces\Repositories\LabelRepositoryInterface;
use FatemeMahmoodi\LaravelToDo\Models\Label;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LabelRepository  implements LabelRepositoryInterface
{
    /**
     * @param array $input
     * @return mixed
     */
    public function create(array $input)
    {
        return Label::create($input);
    }

    /**
     * @param Label $label
     * @param $data
     * @return Label
     */
    public function update(Label $label, $input): Label
    {
        $label->update($input);
        return $label;
    }

    /**
     * @param array $filters
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public function  list(array $filters)
    {
        $query = Label::query();
        return $query->paginate();
    }

}
