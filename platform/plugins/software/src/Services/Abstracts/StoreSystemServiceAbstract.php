<?php

namespace Fast\Software\Services\Abstracts;

use Fast\Software\Models\Software;
use Fast\Software\Repositories\Interfaces\SystemInterface;
use Illuminate\Http\Request;

abstract class StoreSystemServiceAbstract
{
    /**
     * @var SystemInterface
     */
    protected $systemRepository;

    /**
     * StoreSystemServiceAbstract constructor.
     * @param SystemInterface $systemRepository
     */
    public function __construct(SystemInterface $systemRepository)
    {
        $this->systemRepository = $systemRepository;
    }

    /**
     * @param Request $request
     * @param Software $software
     * @return mixed
     */
    abstract public function execute(Request $request, Software $software);
}
