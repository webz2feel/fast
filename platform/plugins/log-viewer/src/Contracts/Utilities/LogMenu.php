<?php

namespace Fast\LogViewer\Contracts\Utilities;

use Fast\LogViewer\Entities\Log;
use Illuminate\Contracts\Config\Repository as ConfigContract;

interface LogMenu
{

    /**
     * Set the config instance.
     *
     * @param  \Illuminate\Contracts\Config\Repository $config
     *
     * @return self
     * @author ARCANEDEV
     */
    public function setConfig(ConfigContract $config);

    /**
     * Set the log styler instance.
     *
     * @param  \Fast\LogViewer\Contracts\Utilities\LogStyler $styler
     *
     * @return self
     * @author ARCANEDEV
     */
    public function setLogStyler(LogStyler $styler);

    /**
     * Make log menu.
     *
     * @param  \Fast\LogViewer\Entities\Log $log
     * @param  bool $trans
     *
     * @return array
     * @author ARCANEDEV
     */
    public function make(Log $log, $trans = true);
}
