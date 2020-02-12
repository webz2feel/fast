<?php

namespace Fast\Location\Models;

use Fast\Base\Traits\EnumCastable;
use Fast\Base\Enums\BaseStatusEnum;
use Fast\Base\Models\BaseModel;

class Country extends BaseModel
{
    use EnumCastable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'countries';

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'nationality',
        'order',
        'is_default',
        'status',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'status' => BaseStatusEnum::class,
    ];
}
