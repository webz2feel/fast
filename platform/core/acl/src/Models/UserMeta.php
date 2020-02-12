<?php

namespace Fast\ACL\Models;

use Illuminate\Support\Facades\Auth;
use Fast\Base\Models\BaseModel;

class UserMeta extends BaseModel
{

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'user_meta';

    /**
     * @var array
     */
    protected $fillable = [
        'key',
        'value',
        'user_id',
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
     * @param string $key
     * @param null $value
     * @param int $userId
     * @return bool
     */
    public static function setMeta($key, $value = null, $userId = 0)
    {
        if ($userId == 0) {
            $userId = Auth::user()->getKey();
        }

        $meta = self::firstOrCreate([
            'user_id' => $userId,
            'key'     => $key,
        ]);

        return $meta->update(['value' => $value]);
    }

    /**
     * @param string $key
     * @param null $default_value
     * @param int $userId
     * @return string
     */
    public static function getMeta($key, $default_value = null, $userId = 0)
    {
        if ($userId == 0) {
            $userId = Auth::user()->getKey();
        }

        $meta = self::where([
            'user_id' => $userId,
            'key'     => $key,
        ])->select('value')->first();

        if (!empty($meta)) {
            return $meta->value;
        }

        return $default_value;
    }
}
