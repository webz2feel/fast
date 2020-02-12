<?php

namespace Fast\Blog\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Fast\Base\Enums\BaseStatusEnum;
use Fast\Base\Http\Responses\BaseHttpResponse;
use Fast\Blog\Http\Resources\CategoryResource;
use Fast\Blog\Repositories\Interfaces\CategoryInterface;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * @var CategoryInterface
     */
    protected $categoryRepository;

    /**
     * AuthenticationController constructor.
     *
     * @param CategoryInterface $categoryRepository
     */
    public function __construct(CategoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * List categories
     *
     * @group Blog
     *
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function index(Request $request, BaseHttpResponse $response)
    {
        $data = $this->categoryRepository
            ->getModel()
            ->where(['status' => BaseStatusEnum::PUBLISHED])
            ->select(['id', 'name', 'description'])
            ->paginate($request->input('per_page', 10));

        return $response
            ->setData(CategoryResource::collection($data))
            ->toApiResponse();
    }
}
