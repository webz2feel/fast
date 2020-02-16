<?php

namespace Fast\Software\Services\Abstracts;

use Fast\Software\Models\Software;
use Fast\Software\Repositories\Interfaces\LanguageInterface;
use Illuminate\Http\Request;

abstract class StoreLanguageServiceAbstract
{
    /**
     * @var LanguageInterface
     */
    protected $languageRepository;

    /**
     * StoreLanguageServiceAbstract constructor.
     * @param LanguageInterface $languageRepository
     */
    public function __construct(LanguageInterface $languageRepository)
    {
        $this->languageRepository = $languageRepository;
    }

    /**
     * @param Request $request
     * @param Software $software
     * @return mixed
     */
    abstract public function execute(Request $request, Software $software);
}
