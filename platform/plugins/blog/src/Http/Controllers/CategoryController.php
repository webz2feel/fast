<?php

namespace Fast\Blog\Http\Controllers;

use Fast\Base\Events\BeforeEditContentEvent;
use Fast\Base\Forms\FormBuilder;
use Fast\Base\Http\Controllers\BaseController;
use Fast\Base\Http\Responses\BaseHttpResponse;
use Fast\Blog\Forms\CategoryForm;
use Fast\Blog\Tables\CategoryTable;
use Fast\Blog\Http\Requests\CategoryRequest;
use Fast\Blog\Repositories\Interfaces\CategoryInterface;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Fast\Base\Events\CreatedContentEvent;
use Fast\Base\Events\DeletedContentEvent;
use Fast\Base\Events\UpdatedContentEvent;

class CategoryController extends BaseController
{

    /**
     * @var CategoryInterface
     */
    protected $categoryRepository;

    /**
     * @param CategoryInterface $categoryRepository
     *
     */
    public function __construct(CategoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Display all categories
     * @param CategoryTable $dataTable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * @throws \Throwable
     */
    public function index(CategoryTable $dataTable)
    {
        page_title()->setTitle(trans('plugins/blog::categories.menu'));

        return $dataTable->renderTable();
    }

    /**
     * Show create form
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('plugins/blog::categories.create'));

        return $formBuilder->create(CategoryForm::class)->renderForm();
    }

    /**
     * Insert new Category into database
     *
     * @param CategoryRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function store(CategoryRequest $request, BaseHttpResponse $response)
    {
        $category = $this->categoryRepository->createOrUpdate(array_merge($request->input(), [
            'author_id'   => Auth::user()->getKey(),
            'is_featured' => $request->input('is_featured', false),
            'is_default'  => $request->input('is_default', false),
        ]));

        event(new CreatedContentEvent(CATEGORY_MODULE_SCREEN_NAME, $request, $category));

        return $response
            ->setPreviousUrl(route('categories.index'))
            ->setNextUrl(route('categories.edit', $category->id))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    /**
     * Show edit form
     *
     * @param Request $request
     * @param int $id
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function edit(Request $request, $id, FormBuilder $formBuilder)
    {
        $category = $this->categoryRepository->findOrFail($id);

        event(new BeforeEditContentEvent($request, $category));

        page_title()->setTitle(trans('plugins/blog::categories.edit') . ' "' . $category->name . '"');

        return $formBuilder->create(CategoryForm::class, ['model' => $category])->renderForm();
    }

    /**
     * @param int $id
     * @param CategoryRequest $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function update($id, CategoryRequest $request, BaseHttpResponse $response)
    {
        $category = $this->categoryRepository->findOrFail($id);

        $category->fill($request->input());
        $category->is_featured = $request->input('is_featured', false);
        $category->is_default = $request->input('is_default', false);

        $this->categoryRepository->createOrUpdate($category);

        event(new UpdatedContentEvent(CATEGORY_MODULE_SCREEN_NAME, $request, $category));

        return $response
            ->setPreviousUrl(route('categories.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    /**
     * @param Request $request
     * @param int $id
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function destroy(Request $request, $id, BaseHttpResponse $response)
    {
        try {
            $category = $this->categoryRepository->findOrFail($id);

            if (!$category->is_default) {
                $this->categoryRepository->delete($category);
                event(new DeletedContentEvent(CATEGORY_MODULE_SCREEN_NAME, $request, $category));
            }

            return $response->setMessage(trans('core/base::notices.delete_success_message'));
        } catch (Exception $ex) {
            return $response
                ->setError()
                ->setMessage(trans('core/base::notices.cannot_delete'));
        }
    }

    /**
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     *
     * @throws Exception
     */
    public function deletes(Request $request, BaseHttpResponse $response)
    {
        $ids = $request->input('ids');
        if (empty($ids)) {
            return $response->setMessage(trans('core/base::notices.no_select'));
        }

        foreach ($ids as $id) {
            $category = $this->categoryRepository->findOrFail($id);
            if (!$category->is_default) {
                $this->categoryRepository->delete($category);

                event(new DeletedContentEvent(CATEGORY_MODULE_SCREEN_NAME, $request, $category));
            }
        }

        return $response->setMessage(trans('core/base::notices.delete_success_message'));
    }
}
