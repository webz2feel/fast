<?php

namespace Fast\Software\Tables;

use Fast\Software\Exports\SoftwareExport;
use Illuminate\Support\Facades\Auth;
use Fast\Base\Enums\BaseStatusEnum;
use Fast\Software\Models\Software;
use Fast\Software\Repositories\Interfaces\CategoryInterface;
use Fast\Software\Repositories\Interfaces\SoftwareInterface;
use Fast\Table\Abstracts\TableAbstract;
use Carbon\Carbon;
use Html;
use Illuminate\Contracts\Routing\UrlGenerator;
use Yajra\DataTables\DataTables;

class SoftwareTable extends TableAbstract
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
     * @var CategoryInterface
     */
    protected $categoryRepository;

    /**
     * @var string
     */
    protected $exportClass = SoftwareExport::class;

    /**
     * @var int
     */
    protected $defaultSortColumn = 6;

    /**
     * SoftwareTable constructor.
     * @param DataTables $table
     * @param UrlGenerator $urlGenerator
     * @param SoftwareInterface $softwareRepository
     * @param CategoryInterface $categoryRepository
     */
    public function __construct(
        DataTables $table,
        UrlGenerator $urlGenerator,
        SoftwareInterface $softwareRepository,
        CategoryInterface $categoryRepository
    ) {
        $this->repository = $softwareRepository;
        $this->setOption('id', 'table-softwares');
        $this->categoryRepository = $categoryRepository;
        parent::__construct($table, $urlGenerator);

        if (Auth::check() && !Auth::user()->hasAnyPermission(['softwares.edit', 'softwares.destroy'])) {
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
                if (Auth::check() && !Auth::user()->hasPermission('softwares.edit')) {
                    return $item->name;
                }

                return anchor_link(route('softwares.edit', $item->id), $item->name);
            })
            ->editColumn('image', function ($item) {
                if ($this->request()->input('action') === 'excel') {
                    return get_object_image($item->image, 'thumb');
                }
                return Html::image(get_object_image($item->image, 'thumb'), $item->name, ['width' => 50]);
            })
            ->editColumn('checkbox', function ($item) {
                return table_checkbox($item->id);
            })
            ->editColumn('created_at', function ($item) {
                return date_from_database($item->created_at, config('core.base.general.date_format.date'));
            })
            ->editColumn('updated_at', function ($item) {
                return implode(', ', $item->categories->pluck('name')->all());
            })
            ->editColumn('author_id', function ($item) {
                return $item->author ? $item->author->getFullName() : null;
            })
            ->editColumn('status', function ($item) {
                if ($this->request()->input('action') === 'excel') {
                    return $item->status->getValue();
                }
                return $item->status->toHtml();
            });

        return apply_filters(BASE_FILTER_GET_LIST_DATA, $data, $this->repository->getModel())
            ->addColumn('operations', function ($item) {
                return table_actions('softwares.edit', 'softwares.destroy', $item);
            })
            ->escapeColumns([])
            ->make(true);
    }

    /**
     * Get the query object to be processed by the table.
     *
     * @return \Illuminate\Database\Query\Builder|\Illuminate\Database\Eloquent\Builder
     *
     * @since 2.1
     */
    public function query()
    {
        $model = $this->repository->getModel();
        $query = $model
            ->with(['categories'])
            ->select([
                         'softwares.id',
                         'softwares.name',
                         'softwares.image',
                         'softwares.created_at',
                         'softwares.status',
                         'softwares.updated_at',
                         'softwares.author_id',
                         'softwares.author_type',
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
                'name'  => 'softwares.id',
                'title' => trans('core/base::tables.id'),
                'width' => '20px',
            ],
            'image'      => [
                'name'  => 'softwares.image',
                'title' => trans('core/base::tables.image'),
                'width' => '70px',
            ],
            'name'       => [
                'name'  => 'softwares.name',
                'title' => trans('core/base::tables.name'),
                'class' => 'text-left',
            ],
            'updated_at' => [
                'name'      => 'softwares.updated_at',
                'title'     => trans('plugins/software::softwares.categories'),
                'width'     => '150px',
                'class'     => 'no-sort',
                'orderable' => false,
            ],
            'author_id'  => [
                'name'      => 'softwares.author_id',
                'title'     => trans('plugins/software::softwares.author'),
                'width'     => '150px',
                'class'     => 'no-sort',
                'orderable' => false,
            ],
            'created_at' => [
                'name'  => 'softwares.created_at',
                'title' => trans('core/base::tables.created_at'),
                'width' => '100px',
            ],
            'status'     => [
                'name'  => 'softwares.status',
                'title' => trans('core/base::tables.status'),
                'width' => '100px',
            ],
        ];
    }

    /**
     * @return array
     *
     * @throws \Throwable
     * @since 2.1
     */
    public function buttons()
    {
        $buttons = $this->addCreateButton(route('softwares.create'), 'softwares.create');

        return apply_filters(BASE_FILTER_TABLE_BUTTONS, $buttons, Software::class);
    }

    /**
     * @return array
     * @throws \Throwable
     */
    public function bulkActions(): array
    {
        return $this->addDeleteAction(route('softwares.deletes'), 'softwares.destroy', parent::bulkActions());
    }

    /**
     * @return array
     */
    public function getBulkChanges(): array
    {
        return [
            'softwares.name'       => [
                'title'    => trans('core/base::tables.name'),
                'type'     => 'text',
                'validate' => 'required|max:120',
            ],
            'softwares.status'     => [
                'title'    => trans('core/base::tables.status'),
                'type'     => 'select',
                'choices'  => BaseStatusEnum::labels(),
                'validate' => 'required|in:' . implode(',', BaseStatusEnum::values()),
            ],
            'softwares.created_at' => [
                'title'    => trans('core/base::tables.created_at'),
                'type'     => 'date',
                'validate' => 'required',
            ],
            'category'         => [
                'title'    => __('Category'),
                'type'     => 'select-search',
                'validate' => 'required',
                'callback' => 'getCategories',
            ],
        ];
    }

    /**
     * @return array
     */
    public function getCategories()
    {
        return $this->categoryRepository->pluck('software_categories.name', 'software_categories.id');
    }

    /**
     * @param \Illuminate\Database\Query\Builder $query
     * @param string $key
     * @param string $operator
     * @param string $value
     * @return $this|\Illuminate\Database\Query\Builder|string|static
     */
    public function applyFilterCondition($query, string $key, string $operator, ?string $value)
    {
        switch ($key) {
            case 'softwares.created_at':
                $value = Carbon::createFromFormat('Y/m/d', $value)->toDateString();
                return $query->whereDate($key, $operator, $value);
            case 'category':
                return $query->join('post_categories', 'post_categories.post_id', '=', 'softwares.id')
                    ->join('categories', 'post_categories.category_id', '=', 'categories.id')
                    ->where('post_categories.category_id', $operator, $value);
        }

        return parent::applyFilterCondition($query, $key, $operator, $value);
    }

    /**
     * @param Software $item
     * @param string $inputKey
     * @param string $inputValue
     * @return false|\Illuminate\Database\Eloquent\Model
     */
    public function saveBulkChangeItem($item, string $inputKey, ?string $inputValue)
    {
        if ($inputKey === 'category') {
            $item->categories()->sync([$inputValue]);
            return $item;
        }

        return parent::saveBulkChangeItem($item, $inputKey, $inputValue);
    }

    /**
     * @return array
     */
    public function getDefaultButtons(): array
    {
        return ['excel', 'reload'];
    }
}
