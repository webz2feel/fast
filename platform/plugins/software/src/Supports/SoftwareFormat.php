<?php

namespace Fast\Software\Supports;

class SoftwareFormat
{
    /**
     * @var array
     */
    protected static $formats = [
        ''        => [
            'key'  => '',
            'icon' => null,
            'name' => 'Default',
        ],
        'gallery' => [
            'key'  => 'gallery',
            'icon' => 'fa fa-image',
            'name' => 'Gallery',
        ],
        'video'   => [
            'key'  => 'video',
            'icon' => 'fa fa-camera',
            'name' => 'Video',
        ],
    ];

    /**
     * @param array $formats
     * @return void
     *
     * @since 16-09-2016
     */
    public static function registerSoftwareFormat(array $formats = [])
    {
        foreach ($formats as $key => $format) {
            self::$formats[$key] = $format;
        }
    }

    /**
     * @param bool $isConvertToList
     * @return array
     *
     * @since 16-09-2016
     */
    public static function getSoftwareFormats($isConvertToList = false)
    {
        if ($isConvertToList) {
            $results = [];
            foreach (self::$formats as $key => $item) {
                $results[] = [
                    $key,
                    $item['name'],
                ];
            }
            return $results;
        }

        return self::$formats;
    }
}
