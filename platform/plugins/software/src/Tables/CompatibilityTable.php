<?php

namespace Fast\Software\Tables;

use Fast\Base\Enums\BaseStatusEnum;
use Fast\Software\Models\Compatibility;
use Fast\Software\Repositories\Interfaces\CompatibilityInterface;
use Illuminate\Support\Facades\Auth;
use Fast\Table\Abstracts\TableAbstract;
use Illuminate\Contracts\Routing\UrlGenerator;
use Yajra\DataTables\DataTables;

class CompatibilityTable extends TableAbstract
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
     * CompatibilityTable constructor.
     *
     * @param DataTables $table
     * @param UrlGenerator $urlGenerator
     * @param  CompatibilityInterface $compatibilityRepository
     */
    public function __construct(DataTables $table, UrlGenerator $urlGenerator,
        CompatibilityInterface $compatibilityRepository)
    {
        $this->repository = $compatibilityRepository;
        $this->setOption('id', 'table-compatibility');
        parent::__construct($table, $urlGenerator);

        if (!Auth::user()->hasAnyPermission(['compatibilities.edit', 'compatibilities.destroy'])) {
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
                if (!Auth::user()->hasPermission('compatibilities.edit')) {
                    return $item->name;
                }

                return anchor_link(route('compatibilities.edit', $item->id), $item->name);
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
                return table_actions('compatibilities.edit', 'compatibilities.destroy', $item);
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
                'software_compatibilities.id',
                'software_compatibilities.name',
                'software_compatibilities.created_at',
                'software_compatibilities.status',
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
                'name'  => 'software_compatibilities.id',
                'title' => trans('core/base::tables.id'),
                'width' => '20px',
            ],
            'name'       => [
                'name'  => 'software_compatibilities.name',
                'title' => trans('core/base::tables.name'),
                'class' => 'text-left',
            ],
            'status'     => [
                'name'  => 'software_compatibilities.status',
                'title' => trans('core/base::tables.status'),
                'width' => '100px',
            ],
            'created_at' => [
                'name'  => 'software_compatibilities.created_at',
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
        $buttons = $this->addCreateButton(route('compatibilities.create'), 'compatibilities.create');

        return apply_filters(BASE_FILTER_TABLE_BUTTONS, $buttons, Compatibility::class);
    }

    /**
     * @return array
     * @throws \Throwable
     */
    public function bulkActions(): array
    {
        return $this->addDeleteAction(route('compatibilities.deletes'), 'compatibilities.destroy', parent::bulkActions());
    }

    /**
     * @return array
     */
    public function getBulkChanges(): array
    {
        return [
            'compatibilities.name'       => [
                'title'    => trans('core/base::tables.name'),
                'type'     => 'text',
                'validate' => 'required|max:120',
            ],
            'compatibilities.status'     => [
                'title'    => trans('core/base::tables.status'),
                'type'     => 'select',
                'choices'  => BaseStatusEnum::labels(),
                'validate' => 'required|in:0,1',
            ],
            'compatibilities.created_at' => [
                'title' => trans('core/base::tables.created_at'),
                'type'  => 'date',
            ],
        ];
    }
}
