<?php

namespace Fast\Software\Http\Controllers;

use Fast\Base\Events\BeforeEditContentEvent;
use Fast\Base\Forms\FormBuilder;
use Fast\Base\Http\Controllers\BaseController;
use Fast\Base\Http\Responses\BaseHttpResponse;
use Fast\Base\Traits\HasDeleteManyItemsTrait;
use Fast\Software\Forms\LanguageForm;
use Fast\Software\Http\Requests\LanguageRequest;
use Fast\Software\Repositories\Interfaces\LanguageInterface;
use Fast\Software\Tables\LanguageTable;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Fast\Base\Events\CreatedContentEvent;
use Fast\Base\Events\DeletedContentEvent;
use Fast\Base\Events\UpdatedContentEvent;

class LanguageController extends BaseController
{

    use HasDeleteManyItemsTrait;

    /**
     * @var LanguageInterface
     */
    protected $languageRepository;

    /**
     * @param LanguageInterface $languageRepository
     */
    public function __construct(LanguageInterface $languageRepository)
    {
        $this->languageRepository = $languageRepository;
    }

    /**
     * @param LanguageTable $dataTable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * @throws \Throwable
     */
    public function index(LanguageTable $dataTable)
    {
        page_title()->setTitle(trans('plugins/software::language.menu'));

        return $dataTable->renderTable();
    }

    /**
     * @return string
     */
    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('plugins/software::language.create'));

        return $formBuilder->create(LanguageForm::class)->renderForm();
    }

    /**
     * @param LanguageRequest  $request
     * @param BaseHttpResponse $response
     *
     * @return BaseHttpResponse
     */
    public function store(LanguageRequest $request, BaseHttpResponse $response)
    {
        $tag = $this->languageRepository->createOrUpdate(array_merge($request->input(),
            ['author_id' => Auth::user()->getKey()]));
        event(new CreatedContentEvent(SOFTWARE_LANGUAGE_MODULE_SCREEN_NAME, $request, $tag));

        return $response
            ->setPreviousUrl(route('languages.index'))
            ->setNextUrl(route('languages.edit', $tag->id))
            ->setMessage(trans('core/base::notices.create_success_message'));
    }

    /**
     * @param int $id
     * @param Request $request
     * @param FormBuilder $formBuilder
     * @return string
     */
    public function edit($id, Request $request, FormBuilder $formBuilder)
    {
        $tag = $this->languageRepository->findOrFail($id);

        event(new BeforeEditContentEvent($request, $tag));

        page_title()->setTitle(trans('plugins/software::language.edit') . ' "' . $tag->name . '"');

        return $formBuilder->create(LanguageForm::class, ['model' => $tag])->renderForm();
    }

    /**
     * @param int $id
     * @param  LanguageRequest $request
     * @param BaseHttpResponse $response
     *
     * @return BaseHttpResponse
     */
    public function update($id, LanguageRequest $request, BaseHttpResponse $response)
    {
        $tag = $this->languageRepository->findOrFail($id);
        $tag->fill($request->input());

        $this->languageRepository->createOrUpdate($tag);
        event(new UpdatedContentEvent(SOFTWARE_LANGUAGE_MODULE_SCREEN_NAME, $request, $tag));

        return $response
            ->setPreviousUrl(route('languages.index'))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    /**
     * @param Request $request
     * @param int $id
     * @param BaseHttpResponse $response
     * @return BaseHttpResponse
     */
    public function destroy($id, Request $request, BaseHttpResponse $response)
    {
        try {
            $tag = $this->languageRepository->findOrFail($id);
            $this->languageRepository->delete($tag);

            event(new DeletedContentEvent(SOFTWARE_LANGUAGE_MODULE_SCREEN_NAME, $request, $tag));

            return $response->setMessage(trans('plugins/software::language.deleted'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage(trans('plugins/software::language.cannot_delete'));
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
        return $this->executeDeleteItems($request, $response, $this->languageRepository, SOFTWARE_LANGUAGE_MODULE_SCREEN_NAME);
    }

    /**
     * Get list tags in db
     *
     * @return array
     */
    public function getAllCompatibilities()
    {
        return $this->languageRepository->pluck('name');
    }
}
