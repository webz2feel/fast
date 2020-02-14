<?php

namespace Fast\Software\Services\Abstracts;

use Fast\Software\Models\Software;
use Fast\Software\Repositories\Interfaces\CategoryInterface;
use Illuminate\Http\Request;

abstract class StoreCategoryServiceAbstract
{
    /**
     * @var CategoryInterface
     */
    protected $categoryRepository;

    /**
     * StoreCategoryServiceAbstract constructor.
     * @param CategoryInterface $categoryRepository
     */
    public function __construct(CategoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @param Request $request
     * @param Software $software
     * @return mixed
     */
    abstract public function execute(Request $request, Software $software);
}
