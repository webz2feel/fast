<?php

namespace Fast\RealEstate\Forms;

use Fast\Base\Forms\FormAbstract;
use Fast\Base\Enums\BaseStatusEnum;
use Fast\RealEstate\Http\Requests\InvestorRequest;
use Fast\RealEstate\Models\Investor;
use Throwable;

class InvestorForm extends FormAbstract
{

    /**
     * @return mixed|void
     * @throws Throwable
     */
    public function buildForm()
    {
        $this
            ->setupModel(new Investor)
            ->setValidatorClass(InvestorRequest::class)
            ->withCustomFields()
            ->add('name', 'text', [
                'label'      => trans('core/base::forms.name'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => trans('core/base::forms.name_placeholder'),
                    'data-counter' => 120,
                ],
            ])
            ->add('status', 'customSelect', [
                'label'      => trans('core/base::tables.status'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'class' => 'form-control select-full',
                ],
                'choices'    => BaseStatusEnum::labels(),
            ])
            ->setBreakFieldPoint('status');
    }
}
