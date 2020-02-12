<?php

namespace Fast\Payment\Repositories\Caches;

use Fast\Support\Repositories\Caches\CacheAbstractDecorator;
use Fast\Payment\Repositories\Interfaces\PaymentInterface;

class PaymentCacheDecorator extends CacheAbstractDecorator implements PaymentInterface
{
}
