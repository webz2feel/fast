<?php

namespace Fast\Blog\Http\Controllers;

use Fast\Base\Events\BeforeEditContentEvent;
use Fast\Base\Forms\FormBuilder;
use Fast\Base\Http\Controllers\BaseController;
use Fast\Base\Http\Responses\BaseHttpResponse;
use Fast\Base\Traits\HasDeleteManyItemsTrait;
use Fast\Blog\Forms\PostForm;
use Fast\Blog\Http\Requests\PostRequest;
use Fast\Blog\Models\Post;
use Fast\Blog\Repositories\Interfaces\CategoryInterface;
use Fast\Blog\Repositories\Interfaces\PostInterface;
use Fast\Blog\Tables\PostTable;
use Fast\Blog\Repositories\Interfaces\TagInterface;
use Fast\Blog\Services\StoreCategoryService;
use Fast\Blog\Services\StoreTagService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Fast\Base\Events\CreatedContentEvent;
use Fast\Base\Events\DeletedContentEvent;
use Fast\Base\Events\UpdatedContentEvent;

class PostController extends BaseController
{

    use HasDeleteManyItemsTrait;

    /**
     * @var PostInterface
     */
    protected $postRepository;

    /**
     * @var TagInterface
     */
    protected $tagRepository;

    /**
     * @var CategoryInterface
     */
    protected $categoryRepository;

    /**
     * @param PostInterface $postRepository
     * @param TagInterface $tagRepository
     * @param CategoryInterface $categoryRepository
     */
    public function __construct(
        PostInterface $postRepository,
        TagInterface $tagRepository,
        CategoryInterface $categoryRepository
    ) {
        $this->postRepository = $postRepository;
        $this->tagRepository = $tagRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @param PostTable $dataTable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Throwable
     */
    public function index(PostTable $dataTable)
    {
        page_title()->setTitle(trans('plugins/blog::posts.menu_name'));

        return $dataTable->renderTable();
    }

    /**
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('plugins/blog::posts.create'));

        return $formBuilder->create(PostForm::class)->renderForm();
    }

    /**
     * @param PostRequest $request
     * @param StoreTagService $tagService
     * @param StoreCategoryService $categoryService
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function store(
        PostRequest $request,
        StoreTagService $tagService,
        StoreCategoryService $categoryService,
        BaseHttpResponse $response
    ) {
        /**
         * @var Post $post
         */
        $post = $this->postRepository->createOrUpdate(array_merge($request->input(), [
            'author_id'   => Auth::user()->getKey(),
            'is_featured' => $request->input('is_featured', false),
        ]));

        event(new CreatedContentEvent(POST_MODULE_SCREEN_NAME, $request, $post));

        $tagService->execute($request, $post);

        $categoryService->execute($request, $post);

        return $response
            ->setPreviousUrl(route('posts.index'))
            ->setNextUrl(route('posts.edit', $post->id))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    /**
     * @param int $id
     * @param FormBuilder $formBuilder
     * @param Request $request
     * @return string
     */
    public function edit($id, FormBuilder $formBuilder, Request $request)
    {
        $post = $this->postRepository->findOrFail($id);

        event(new BeforeEditContentEvent($request, $post));

        page_title()->setTitle(trans('plugins/blog::posts.edit') . ' "' . $post->name . '"');

        return $formBuilder->create(PostForm::class, ['model' => $post])->renderForm();
    }

    /**
     * @param int $id
     * @param PostRequest $request
     * @param StoreTagService $tagService
     * @param StoreCategoryService $categoryService
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function update(
        $id,
        PostRequest $request,
        StoreTagService $tagService,
        StoreCategoryService $categoryService,
        BaseHttpResponse $response
    ) {
        $post = $this->postRepository->findOrFail($id);

        $post->fill($request->input());
        $post->is_featured = $request->input('is_featured', false);

        $this->postRepository->createOrUpdate($post);

        event(new UpdatedContentEvent(POST_MODULE_SCREEN_NAME, $request, $post));

        $tagService->execute($request, $post);

        $categoryService->execute($request, $post);

        return $response
            ->setPreviousUrl(route('posts.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    /**
     * @param int $id
     * @param Request $request
     * @return BaseHttpResponse
     */
    public function destroy($id, Request $request, BaseHttpResponse $response)
    {
        try {
            $post = $this->postRepository->findOrFail($id);
            $this->postRepository->delete($post);

            event(new DeletedContentEvent(POST_MODULE_SCREEN_NAME, $request, $post));

            return $response
                ->setMessage(trans('core/base::notices.delete_success_message'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage(trans('core/base::notices.cannot_delete'));
        }
    }

    /**
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     * @throws Exception
     */
    public function deletes(Request $request, BaseHttpResponse $response)
    {
        return $this->executeDeleteItems($request, $response, $this->postRepository, POST_MODULE_SCREEN_NAME);
    }

    /**
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     * @throws \Throwable
     */
    public function getWidgetRecentPosts(Request $request, BaseHttpResponse $response)
    {
        $limit = $request->input('paginate', 10);
        $posts = $this->postRepository->getModel()
            ->orderBy('posts.created_at', 'desc')
            ->paginate($limit);

        return $response
            ->setData(view('plugins/blog::posts.widgets.posts', compact('posts', 'limit'))->render());
    }
}
