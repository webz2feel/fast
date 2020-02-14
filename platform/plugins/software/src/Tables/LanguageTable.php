<?php

namespace Fast\Software\Tables;

use Fast\Base\Enums\BaseStatusEnum;
use Fast\Software\Models\Language;
use Fast\Software\Repositories\Interfaces\LanguageInterface;
use Illuminate\Support\Facades\Auth;
use Fast\Table\Abstracts\TableAbstract;
use Illuminate\Contracts\Routing\UrlGenerator;
use Yajra\DataTables\DataTables;

class LanguageTable extends TableAbstract
{

    /**
     * @var bool
     */
    protected $hasActions = true;

    /**
     * @var bool
     */
    protected $hasFilter = true;

    /**
     * LanguageTable constructor.
     *
     * @param DataTables $table
     * @param UrlGenerator $urlGenerator
     * @param  LanguageInterface $languageRepository
     */
    public function __construct(DataTables $table, UrlGenerator $urlGenerator,
        LanguageInterface $languageRepository)
    {
        $this->repository = $languageRepository;
        $this->setOption('id', 'table-language');
        parent::__construct($table, $urlGenerator);

        if (!Auth::user()->hasAnyPermission(['languages.edit', 'languages.destroy'])) {
            $this->hasOperations = false;
            $this->hasActions = false;
        }
    }

    /**
     * Display ajax response.
     *
     * @return \Illuminate\Http\JsonResponse
     *
     * @since 2.1
     */
    public function ajax()
    {
        $data = $this->table
            ->eloquent($this->query())
            ->editColumn('name', function ($item) {
                if (!Auth::user()->hasPermission('languages.edit')) {
                    return $item->name;
                }

                return anchor_link(route('languages.edit', $item->id), $item->name);
            })
            ->editColumn('checkbox', function ($item) {
                return table_checkbox($item->id);
            })
            ->editColumn('created_at', function ($item) {
                return date_from_database($item->created_at, config('core.base.general.date_format.date'));
            })
            ->editColumn('status', function ($item) {
                if ($this->request()->input('action') === 'excel') {
                    return $item->status->getValue();
                }
                return $item->status->toHtml();
            });

        return apply_filters(BASE_FILTER_GET_LIST_DATA, $data, $this->repository->getModel())
            ->addColumn('operations', function ($item) {
                return table_actions('languages.edit', 'languages.destroy', $item);
            })
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * Get the query object to be processed by table.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     *
     * @since 2.1
     */
    public function query()
    {
        $model = $this->repository->getModel();
        $query = $model
            ->select([
                'software_languages.id',
                'software_languages.name',
                'software_languages.created_at',
                'software_languages.status',
            ]);

        return $this->applyScopes(apply_filters(BASE_FILTER_TABLE_QUERY, $query, $model));
    }

    /**
     * @return array
     *
     * @since 2.1
     */
    public function columns()
    {
        return [
            'id'         => [
                'name'  => 'software_languages.id',
                'title' => trans('core/base::tables.id'),
                'width' => '20px',
            ],
            'name'       => [
                'name'  => 'software_languages.name',
                'title' => trans('core/base::tables.name'),
                'class' => 'text-left',
            ],
            'status'     => [
                'name'  => 'software_languages.status',
                'title' => trans('core/base::tables.status'),
                'width' => '100px',
            ],
            'created_at' => [
                'name'  => 'software_languages.created_at',
                'title' => trans('core/base::tables.created_at'),
                'width' => '100px',
            ],
        ];
    }

    /**
     * @return array
     *
     * @since 2.1
     * @throws \Throwable
     */
    public function buttons()
    {
        $buttons = $this->addCreateButton(route('languages.create'), 'languages.create');

        return apply_filters(BASE_FILTER_TABLE_BUTTONS, $buttons, Language::class);
    }

    /**
     * @return array
     * @throws \Throwable
     */
    public function bulkActions(): array
    {
        return $this->addDeleteAction(route('languages.deletes'), 'languages.destroy', parent::bulkActions());
    }

    /**
     * @return array
     */
    public function getBulkChanges(): array
    {
        return [
            'languages.name'       => [
                'title'    => trans('core/base::tables.name'),
                'type'     => 'text',
                'validate' => 'required|max:120',
            ],
            'languages.status'     => [
                'title'    => trans('core/base::tables.status'),
                'type'     => 'select',
                'choices'  => BaseStatusEnum::labels(),
                'validate' => 'required|in:0,1',
            ],
            'languages.created_at' => [
                'title' => trans('core/base::tables.created_at'),
                'type'  => 'date',
            ],
        ];
    }
}
