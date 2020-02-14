<?php

namespace Fast\Software\Http\Controllers;

use Fast\Base\Events\BeforeEditContentEvent;
use Fast\Base\Forms\FormBuilder;
use Fast\Base\Http\Controllers\BaseController;
use Fast\Base\Http\Responses\BaseHttpResponse;
use Fast\Base\Traits\HasDeleteManyItemsTrait;
use Fast\Software\Forms\CompatibilityForm;
use Fast\Software\Http\Requests\CompatibilityRequest;
use Fast\Software\Repositories\Interfaces\CompatibilityInterface;
use Fast\Software\Tables\CompatibilityTable;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Fast\Base\Events\CreatedContentEvent;
use Fast\Base\Events\DeletedContentEvent;
use Fast\Base\Events\UpdatedContentEvent;

class CompatibilityController extends BaseController
{

    use HasDeleteManyItemsTrait;

    /**
     * @var CompatibilityInterface
     */
    protected $compatibilityRepository;

    /**
     * @param CompatibilityInterface $compatibilityRepository
     */
    public function __construct(CompatibilityInterface $compatibilityRepository)
    {
        $this->compatibilityRepository = $compatibilityRepository;
    }

    /**
     * @param CompatibilityTable $dataTable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * @throws \Throwable
     */
    public function index(CompatibilityTable $dataTable)
    {
        page_title()->setTitle(trans('plugins/software::compatibility.menu'));

        return $dataTable->renderTable();
    }

    /**
     * @return string
     */
    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('plugins/software::compatibility.create'));

        return $formBuilder->create(CompatibilityForm::class)->renderForm();
    }

    /**
     * @param CompatibilityRequest  $request
     * @param BaseHttpResponse $response
     *
     * @return BaseHttpResponse
     */
    public function store(CompatibilityRequest $request, BaseHttpResponse $response)
    {
        $tag = $this->compatibilityRepository->createOrUpdate(array_merge($request->input(),
            ['author_id' => Auth::user()->getKey()]));
        event(new CreatedContentEvent(COMPATIBILITY_MODULE_SCREEN_NAME, $request, $tag));

        return $response
            ->setPreviousUrl(route('compatibilities.index'))
            ->setNextUrl(route('compatibilities.edit', $tag->id))
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
        $tag = $this->compatibilityRepository->findOrFail($id);

        event(new BeforeEditContentEvent($request, $tag));

        page_title()->setTitle(trans('plugins/software::compatibility.edit') . ' "' . $tag->name . '"');

        return $formBuilder->create(CompatibilityForm::class, ['model' => $tag])->renderForm();
    }

    /**
     * @param int $id
     * @param  CompatibilityRequest $request
     * @param BaseHttpResponse $response
     *
     * @return BaseHttpResponse
     */
    public function update($id, CompatibilityRequest $request, BaseHttpResponse $response)
    {
        $tag = $this->compatibilityRepository->findOrFail($id);
        $tag->fill($request->input());

        $this->compatibilityRepository->createOrUpdate($tag);
        event(new UpdatedContentEvent(COMPATIBILITY_MODULE_SCREEN_NAME, $request, $tag));

        return $response
            ->setPreviousUrl(route('compatibilities.index'))
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
            $tag = $this->compatibilityRepository->findOrFail($id);
            $this->compatibilityRepository->delete($tag);

            event(new DeletedContentEvent(COMPATIBILITY_MODULE_SCREEN_NAME, $request, $tag));

            return $response->setMessage(trans('plugins/software::compatibility.deleted'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage(trans('plugins/software::compatibility.cannot_delete'));
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
        return $this->executeDeleteItems($request, $response, $this->compatibilityRepository, COMPATIBILITY_MODULE_SCREEN_NAME);
    }

    /**
     * Get list tags in db
     *
     * @return array
     */
    public function getAllCompatibilities()
    {
        return $this->compatibilityRepository->pluck('name');
    }
}
