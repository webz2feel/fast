<?php

namespace Fast\Blog\Http\Controllers\API;

use Fast\Base\Enums\BaseStatusEnum;
use Fast\Base\Http\Responses\BaseHttpResponse;
use Fast\Blog\Http\Resources\PostResource;
use Fast\Blog\Repositories\Interfaces\PostInterface;
use Fast\Page\Repositories\Interfaces\PageInterface;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Theme;

class PostController extends Controller
{

    /**
     * @var PostInterface
     */
    protected $postRepository;

    /**
     * AuthenticationController constructor.
     *
     * @param PostInterface $postRepository
     */
    public function __construct(PostInterface $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    /**
     * List posts
     *
     * @group Blog
     *
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function index(Request $request, BaseHttpResponse $response)
    {
        $data = $this->postRepository
            ->getModel()
            ->where(['status' => BaseStatusEnum::PUBLISHED])
            ->with(['tags', 'categories'])
            ->select(['id', 'name', 'description', 'content', 'image'])
            ->paginate($request->input('per_page', 10));

        return $response
            ->setData(PostResource::collection($data))
            ->toApiResponse();
    }

    /**
     * Search post
     *
     * @bodyParam q string required The search keyword.
     *
     * @group Blog
     *
     * @param Request $request
     * @param PostInterface $postRepository
     * @param PageInterface $pageRepository
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function getSearch(
        Request $request,
        PostInterface $postRepository,
        PageInterface $pageRepository,
        BaseHttpResponse $response
    ) {
        $query = $request->input('q');
        if (!empty($query)) {
            $posts = $postRepository->getSearch($query);
            $pages = $pageRepository->getSearch($query);

            $data = [
                'items' => [
                    'Posts' => Theme::partial('search.post', compact('posts')),
                    'Pages' => Theme::partial('search.page', compact('pages')),
                ],
                'query' => $query,
                'count' => $posts->count() + $pages->count(),
            ];

            if ($data['count'] > 0) {
                return $response->setData(apply_filters(BASE_FILTER_SET_DATA_SEARCH, $data, 10, 1));
            }
        }

        return $response
            ->setError()
            ->setMessage(trans('core/base::layouts.no_search_result'));
    }
}
