<?php

namespace Fast\SeoHelper\Contracts\Entities;

use Fast\SeoHelper\Contracts\RenderableContract;

interface AnalyticsContract extends RenderableContract
{
    /**
     * Set Google Analytics code.
     *
     * @param  string $code
     *
     * @return self
     */
    public function setGoogle($code);
}
