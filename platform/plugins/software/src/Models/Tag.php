<?php

namespace Fast\Software\Models;

use Fast\Base\Traits\EnumCastable;
use Fast\Base\Enums\BaseStatusEnum;
use Fast\Slug\Traits\SlugTrait;
use Fast\Base\Models\BaseModel;

class Tag extends BaseModel
{
    use SlugTrait;
    use EnumCastable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'software_tags';

    /**
     * The date fields for the model.clear
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'description',
        'status',
        'author_id',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'status' => BaseStatusEnum::class,
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function softwares()
    {
        return $this->belongsToMany(Software::class, 'software_tags_pivot', 'tag_id', 'software_id');
    }

    protected static function boot()
    {
        parent::boot();

        self::deleting(function (Tag $tag) {
            $tag->softwares()->detach();
        });
    }
}
