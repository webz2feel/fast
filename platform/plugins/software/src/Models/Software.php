<?php

namespace Fast\Software\Models;

use Fast\ACL\Models\User;
use Fast\Base\Enums\BaseStatusEnum;
use Fast\Base\Models\BaseModel;
use Fast\Base\Traits\EnumCastable;
use Fast\Revision\RevisionableTrait;
use Fast\Slug\Traits\SlugTrait;

class Software extends BaseModel
{
    use RevisionableTrait;
    use SlugTrait;
    use EnumCastable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'softwares';

    /**
     * @var mixed
     */
    protected $revisionEnabled = true;

    /**
     * @var mixed
     */
    protected $revisionCleanup = true;

    /**
     * @var int
     */
    protected $historyLimit = 20;

    /**
     * @var array
     */
    protected $dontKeepRevisionOf = [
        'content',
        'views',
    ];

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
        'content',
        'image',
        'is_featured',
        'format_type',
        'status',
        'author_id',
        'author_type',
    ];

    /**
     * @var array
     */
    protected $casts = [
        'status' => BaseStatusEnum::class,
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class)->withDefault();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'software_tags_pivot', 'software_id', 'tag_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'software_categories_pivot', 'software_id', 'category_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function systems()
    {
        return $this->belongsToMany(System::class, 'software_system_pivot', 'software_id', 'system_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function compatibilities()
    {
        return $this->belongsToMany(Compatibility::class, 'software_compatibility_pivot', 'software_id', 'compatibility_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function languages()
    {
        return $this->belongsToMany(Language::class, 'software_language_pivot', 'software_id', 'language_id');
    }

    public function author()
    {
        return $this->morphTo();
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function (Software $software) {
            $software->categories()->detach();
            $software->tags()->detach();
            $software->systems()->detach();
            $software->compatibilities()->detach();
            $software->languages()->detach();
        });
    }
}
