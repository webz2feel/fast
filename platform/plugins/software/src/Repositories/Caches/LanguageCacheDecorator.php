<?php

namespace Fast\Software\Repositories\Caches;

use Fast\Software\Repositories\Interfaces\LanguageInterface;
use Fast\Support\Repositories\Caches\CacheAbstractDecorator;

class LanguageCacheDecorator extends CacheAbstractDecorator implements LanguageInterface
{
    /**
     * {@inheritdoc}
     */
    public function getDataSiteMap()
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function getPopularLanguages($limit)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function getAllLanguages($active = true)
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
