<?php

namespace Fast\Software\Services\Abstracts;

use Fast\Software\Models\Software;
use Fast\Software\Repositories\Interfaces\TagInterface;
use Illuminate\Http\Request;

abstract class StoreTagServiceAbstract
{
    /**
     * @var TagInterface
     */
    protected $tagRepository;

    /**
     * StoreTagService constructor.
     * @param TagInterface $tagRepository
     */
    public function __construct(TagInterface $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    /**
     * @param Request $request
     * @param Software $software
     * @return mixed
     */
    abstract public function execute(Request $request, Software $software);
}
