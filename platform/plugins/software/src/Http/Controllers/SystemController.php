<?php

namespace Fast\Software\Http\Controllers;

use Fast\Base\Events\BeforeEditContentEvent;
use Fast\Base\Forms\FormBuilder;
use Fast\Base\Http\Controllers\BaseController;
use Fast\Base\Http\Responses\BaseHttpResponse;
use Fast\Base\Traits\HasDeleteManyItemsTrait;
use Fast\Software\Forms\SystemForm;
use Fast\Software\Repositories\Interfaces\SystemInterface;
use Fast\Software\Tables\SystemTable;
use Fast\Software\Http\Requests\SystemRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Fast\Base\Events\CreatedContentEvent;
use Fast\Base\Events\DeletedContentEvent;
use Fast\Base\Events\UpdatedContentEvent;

class SystemController extends BaseController
{

    use HasDeleteManyItemsTrait;

    /**
     * @var SystemInterface
     */
    protected $systemRepository;

    /**
     * @param SystemInterface $systemRepository
     */
    public function __construct(SystemInterface $systemRepository)
    {
        $this->systemRepository = $systemRepository;
    }

    /**
     * @param SystemTable $dataTable
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * @throws \Throwable
     */
    public function index(SystemTable $dataTable)
    {
        page_title()->setTitle(trans('plugins/software::system.menu'));

        return $dataTable->renderTable();
    }

    /**
     * @return string
     */
    public function create(FormBuilder $formBuilder)
    {
        page_title()->setTitle(trans('plugins/software::system.create'));

        return $formBuilder->create(SystemForm::class)->renderForm();
    }

    /**
     * @param SystemRequest  $request
     * @param BaseHttpResponse $response
     *
     * @return BaseHttpResponse
     */
    public function store(SystemRequest $request, BaseHttpResponse $response)
    {
        $tag = $this->systemRepository->createOrUpdate(array_merge($request->input(),
            ['author_id' => Auth::user()->getKey()]));
        event(new CreatedContentEvent(SYSTEM_MODULE_SCREEN_NAME, $request, $tag));

        return $response
            ->setPreviousUrl(route('systems.index'))
            ->setNextUrl(route('systems.edit', $tag->id))
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
        $tag = $this->systemRepository->findOrFail($id);

        event(new BeforeEditContentEvent($request, $tag));

        page_title()->setTitle(trans('plugins/software::system.edit') . ' "' . $tag->name . '"');

        return $formBuilder->create(SystemForm::class, ['model' => $tag])->renderForm();
    }

    /**
     * @param int $id
     * @param  SystemRequest $request
     * @param BaseHttpResponse $response
     *
     * @return BaseHttpResponse
     */
    public function update($id, SystemRequest $request, BaseHttpResponse $response)
    {
        $tag = $this->systemRepository->findOrFail($id);
        $tag->fill($request->input());

        $this->systemRepository->createOrUpdate($tag);
        event(new UpdatedContentEvent(SYSTEM_MODULE_SCREEN_NAME, $request, $tag));

        return $response
            ->setPreviousUrl(route('systems.index'))
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
            $tag = $this->systemRepository->findOrFail($id);
            $this->systemRepository->delete($tag);

            event(new DeletedContentEvent(SYSTEM_MODULE_SCREEN_NAME, $request, $tag));

            return $response->setMessage(trans('plugins/software::system.deleted'));
        } catch (Exception $exception) {
            return $response
                ->setError()
                ->setMessage(trans('plugins/software::system.cannot_delete'));
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
        return $this->executeDeleteItems($request, $response, $this->systemRepository, SYSTEM_MODULE_SCREEN_NAME);
    }

    /**
     * Get list tags in db
     *
     * @return array
     */
    public function getAllSystems()
    {
        return $this->systemRepository->pluck('name');
    }
}
