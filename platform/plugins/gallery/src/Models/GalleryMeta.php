<?php

namespace Fast\Gallery\Models;

use Eloquent;

class GalleryMeta extends Eloquent
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'gallery_meta';

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
     * @param $value
     * @return mixed
     * @author Imran Ali
     */
    public function getImagesAttribute($value)
    {
        return json_decode($value, true);
    }
}
