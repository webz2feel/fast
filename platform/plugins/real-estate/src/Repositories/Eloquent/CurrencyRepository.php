<?php

namespace Fast\RealEstate\Repositories\Eloquent;

use Fast\Support\Repositories\Eloquent\RepositoriesAbstract;
use Fast\RealEstate\Repositories\Interfaces\CurrencyInterface;

class CurrencyRepository extends RepositoriesAbstract implements CurrencyInterface
{
    /**
     * {@inheritdoc}
     */
    public function getAllCurrencies()
    {
        $data = $this->model
            ->orderBy('order', 'ASC')
            ->get();

        $this->resetModel();

        return $data;
    }
}
