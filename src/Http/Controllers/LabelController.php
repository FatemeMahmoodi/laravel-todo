<?php

namespace FatemeMahmoodi\LaravelToDo\Http\Controllers;

use FatemeMahmoodi\LaravelToDo\Http\Requests\Label\StoreRequest;
use FatemeMahmoodi\LaravelToDo\Http\Requests\Label\UpdateRequest;
use FatemeMahmoodi\LaravelToDo\Http\Resources\LabelResource;
use FatemeMahmoodi\LaravelToDo\Interfaces\Repositories\LabelRepositoryInterface;
use FatemeMahmoodi\LaravelToDo\Models\Label;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class LabelController extends Controller
{
    private $labelRepository;

    public function __construct(LabelRepositoryInterface $labelRepository)
    {
        $this->labelRepository = $labelRepository;
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        return LabelResource::collection($this->labelRepository->list($request->all()));
    }

    /**
     * @param StoreRequest $request
     * @return LabelResource
     */
    public function store(StoreRequest $request): LabelResource
    {
        return new LabelResource(Label::create($request->all()));

    }

    /**
     * @param UpdateRequest $request
     * @param Label $label
     * @return LabelResource
     */
    public function update(UpdateRequest $request, Label $label): LabelResource
    {

        $updatedLabel = $label->update($request->all());
        return new LabelResource($updatedLabel);
    }
}
