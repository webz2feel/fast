<?php

namespace Fast\Software\Services\Abstracts;

use Fast\Software\Models\Software;
use Fast\Software\Repositories\Interfaces\CompatibilityInterface;
use Illuminate\Http\Request;

abstract class StoreCompatibilityServiceAbstract
{
    /**
     * @var CompatibilityInterface
     */
    protected $compatibilityRepository;

    /**
     * StoreCompatibilityServiceAbstract constructor.
     * @param CompatibilityInterface $compatibilityRepository
     */
    public function __construct(CompatibilityInterface $compatibilityRepository)
    {
        $this->compatibilityRepository = $compatibilityRepository;
    }

    /**
     * @param Request $request
     * @param Software $software
     * @return mixed
     */
    abstract public function execute(Request $request, Software $software);
}
