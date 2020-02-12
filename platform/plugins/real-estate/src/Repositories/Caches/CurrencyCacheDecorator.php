<?php

namespace Fast\RealEstate\Repositories\Caches;

use Fast\Support\Repositories\Caches\CacheAbstractDecorator;
use Fast\RealEstate\Repositories\Interfaces\CurrencyInterface;

class CurrencyCacheDecorator extends CacheAbstractDecorator implements CurrencyInterface
{
    /**
     * {@inheritdoc}
     */
    public function getAllCurrencies()
    {
        return $this->getDataIfExistCache(__FUNCTION__, func_get_args());
    }
}
