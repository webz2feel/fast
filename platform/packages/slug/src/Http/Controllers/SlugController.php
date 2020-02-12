<?php

namespace Fast\Slug\Http\Controllers;

use Fast\Base\Http\Controllers\BaseController;
use Fast\Slug\Http\Requests\SlugRequest;
use Fast\Slug\Repositories\Interfaces\SlugInterface;
use Fast\Slug\Services\SlugService;

class SlugController extends BaseController
{
    /**
     * @var SlugInterface
     */
    protected $slugRepository;

    /**
     * @var SlugService
     */
    protected $slugService;

    /**
     * SlugController constructor.
     * @param SlugInterface $slugRepository
     * @param SlugService $slugService
     */
    public function __construct(SlugInterface $slugRepository, SlugService $slugService)
    {
        $this->slugRepository = $slugRepository;
        $this->slugService = $slugService;
    }

    /**
     * @param SlugRequest $request
     * @return int|string
     */
    public function store(SlugRequest $request)
    {
        return $this->slugService->create($request->input('name'), $request->input('slug_id'),
            $request->input('model'));
    }
}
