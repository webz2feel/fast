<?php

namespace Fast\Career\Models;

use Fast\Base\Traits\EnumCastable;
use Fast\Base\Enums\BaseStatusEnum;
use Fast\Slug\Traits\SlugTrait;
use Eloquent;

/**
 * Fast\Career\Models\Career
 *
 * @mixin \Eloquent
 */
class Career extends Eloquent
{
    use EnumCastable;
    use SlugTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'careers';

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'location',
        'salary',
        'description',
        'status',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'status' => BaseStatusEnum::class,
    ];
}
