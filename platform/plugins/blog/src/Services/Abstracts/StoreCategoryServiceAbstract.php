<?php

namespace Fast\Blog\Services\Abstracts;

use Fast\Blog\Models\Post;
use Fast\Blog\Repositories\Interfaces\CategoryInterface;
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
     * @param Post $post
     * @return mixed
     */
    abstract public function execute(Request $request, Post $post);
}
