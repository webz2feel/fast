<?php

namespace Fast\Language\Repositories\Caches;

use Fast\Support\Repositories\Caches\CacheAbstractDecorator;
use Fast\Language\Repositories\Interfaces\LanguageInterface;

class LanguageCacheDecorator extends CacheAbstractDecorator implements LanguageInterface
{
    /**
     * {@inheritdoc}
     */
    public function getActiveLanguage($select = ['*'])
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultLanguage($select = ['*'])
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
