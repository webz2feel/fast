<?php

namespace Fast\Software\Http\Controllers;

use Fast\Base\Events\BeforeEditContentEvent;
use Fast\Base\Forms\FormBuilder;
use Fast\Base\Http\Controllers\BaseController;
use Fast\Base\Http\Responses\BaseHttpResponse;
use Fast\Base\Traits\HasDeleteManyItemsTrait;
use Fast\Software\Forms\SoftwareForm;
use Fast\Software\Http\Requests\SoftwareRequest;
use Fast\Software\Models\Software;
use Fast\Software\Repositories\Interfaces\CategoryInterface;
use Fast\Software\Repositories\Interfaces\CompatibilityInterface;
use Fast\Software\Repositories\Interfaces\LanguageInterface;
use Fast\Software\Repositories\Interfaces\SoftwareInterface;
use Fast\Software\Repositories\Interfaces\SystemInterface;
use Fast\Software\Services\StoreCompatibilityService;
use Fast\Software\Services\StoreLanguageService;
use Fast\Software\Services\StoreSystemService;
use Fast\Software\Tables\SoftwareTable;
use Fast\Software\Repositories\Interfaces\TagInterface;
use Fast\Software\Services\StoreCategoryService;
use Fast\Software\Services\StoreTagService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Fast\Base\Events\CreatedContentEvent;
use Fast\Base\Events\DeletedContentEvent;
use Fast\Base\Events\UpdatedContentEvent;

class SoftwareController extends BaseController
{

    use HasDeleteManyItemsTrait;

    /**
     * @var SoftwareInterface
     */
    protected $softwareRepository;

    /**
     * @var TagInterface
     */
    protected $tagRepository;

    /**
     * @var CategoryInterface
     */
    protected $categoryRepository;
    /**
     * @var CompatibilityInterface
     */
    protected $compatibilityRepository;
    /**
     * @var LanguageInterface
     */
    protected $languageRepository;
    /**
     * @var SystemInterface
     */
    protected $systemRepository;

    /**
     * @param  SoftwareInterface  $softwareRepository
     * @param  TagInterface  $tagRepository
     * @param  CategoryInterface  $categoryRepository
     * @param  SystemInterface  $systemRepository
     * @param  LanguageInterface  $languageRepository
     * @param  CompatibilityInterface  $compatibilityRepository
     */
    public function __construct(
        SoftwareInterface $softwareRepository,
        TagInterface $tagRepository,
        CategoryInterface $categoryRepository,
        SystemInterface $systemRepository,
        LanguageInterface $languageRepository,
        CompatibilityInterface $compatibilityRepository
    ) {
        $this->softwareRepository = $softwareRepository;
        $this->tagRepository = $tagRepository;
        $this->categoryRepository = $categoryRepository;
        $this->systemRepository = $systemRepository;
        $this->languageRepository = $languageRepository;
        $this->compatibilityRepository = $compatibilityRepository;
    }

    /**
     * @param SoftwareTable $dataTable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Throwable
     */
    public function index(SoftwareTable $dataTable)
    {
        page_title()->setTitle(trans('plugins/software::softwares.menu_name'));

        return $dataTable->renderTable();
    }

    /**
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('plugins/software::softwares.create'));

        return $formBuilder->create(SoftwareForm::class)->renderForm();
    }

    /**
     * @param  SoftwareRequest  $request
     * @param  StoreTagService  $tagService
     * @param  StoreCategoryService  $categoryService
     * @param  StoreSystemService  $systemService
     * @param  StoreLanguageService  $languageService
     * @param  StoreCompatibilityService  $compatibilityService
     * @param  BaseHttpResponse  $response
     *
     * @return BaseHttpResponse
     */
    public function store(
        SoftwareRequest $request,
        StoreTagService $tagService,
        StoreCategoryService $categoryService,
        StoreSystemService $systemService,
        StoreLanguageService $languageService,
        StoreCompatibilityService $compatibilityService,
        BaseHttpResponse $response
    ) {
        /**
         * @var Software $software
         */
        $software = $this->softwareRepository->createOrUpdate(array_merge($request->input(), [
            'author_id'   => Auth::user()->getKey(),
            'is_featured' => $request->input('is_featured', false),
        ]));

        event(new CreatedContentEvent(SOFTWARE_MODULE_SCREEN_NAME, $request, $software));

        $tagService->execute($request, $software);

        $categoryService->execute($request, $software);
        $systemService->execute($request, $software);
        $languageService->execute($request, $software);
        $compatibilityService->execute($request, $software);
        return $response
            ->setPreviousUrl(route('softwares.index'))
            ->setNextUrl(route('softwares.edit', $software->id))
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
        $software = $this->softwareRepository->findOrFail($id);

        event(new BeforeEditContentEvent($request, $software));

        page_title()->setTitle(trans('plugins/software::softwares.edit') . ' "' . $software->name . '"');

        return $formBuilder->create(SoftwareForm::class, ['model' => $software])->renderForm();
    }

    /**
     * @param  int  $id
     * @param  SoftwareRequest  $request
     * @param  StoreTagService  $tagService
     * @param  StoreCategoryService  $categoryService
     * @param  StoreSystemService  $systemService
     * @param  StoreLanguageService  $languageService
     * @param  StoreCompatibilityService  $compatibilityService
     * @param  BaseHttpResponse  $response
     *
     * @return BaseHttpResponse
     */
    public function update(
        $id,
        SoftwareRequest $request,
        StoreTagService $tagService,
        StoreCategoryService $categoryService,
        StoreSystemService $systemService,
        StoreLanguageService $languageService,
        StoreCompatibilityService $compatibilityService,
        BaseHttpResponse $response
    ) {
        $software = $this->softwareRepository->findOrFail($id);

        $software->fill($request->input());
        $software->is_featured = $request->input('is_featured', false);

        $this->softwareRepository->createOrUpdate($software);

        event(new UpdatedContentEvent(SOFTWARE_MODULE_SCREEN_NAME, $request, $software));

        $tagService->execute($request, $software);

        $categoryService->execute($request, $software);
        $systemService->execute($request, $software);
        $languageService->execute($request, $software);
        $compatibilityService->execute($request, $software);
        return $response
            ->setPreviousUrl(route('softwares.index'))
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
            $software = $this->softwareRepository->findOrFail($id);
            $this->softwareRepository->delete($software);

            event(new DeletedContentEvent(SOFTWARE_MODULE_SCREEN_NAME, $request, $software));

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
        return $this->executeDeleteItems($request, $response, $this->softwareRepository, SOFTWARE_MODULE_SCREEN_NAME);
    }

    /**
     * @param Request $request
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     * @throws \Throwable
     */
    public function getWidgetRecentSoftwares(Request $request, BaseHttpResponse $response)
    {
        $limit = $request->input('paginate', 10);
        $softwares = $this->softwareRepository->getModel()
            ->orderBy('softwares.created_at', 'desc')
            ->paginate($limit);

        return $response
            ->setData(view('plugins/software::softwares.widgets.softwares', compact('softwares', 'limit'))->render());
    }
}
