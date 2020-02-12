<?php

namespace Fast\Location\Models;

use Fast\Base\Traits\EnumCastable;
use Fast\Base\Enums\BaseStatusEnum;
use Fast\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class State extends BaseModel
{
    use EnumCastable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'states';

    /**
     * @var array
     */
    protected $fillable = [
        'name',
        'country_id',
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

    /**
     * @return BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class)->withDefault();
    }
}
