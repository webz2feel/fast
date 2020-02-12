<?php

namespace Fast\RealEstate\Models;

use Fast\Base\Traits\EnumCastable;
use Fast\Base\Enums\BaseStatusEnum;
use Fast\Base\Models\BaseModel;

class Investor extends BaseModel
{
    use EnumCastable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 're_investors';

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'status',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'status' => BaseStatusEnum::class,
    ];
}
