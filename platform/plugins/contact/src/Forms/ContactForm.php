<?php

namespace Fast\Contact\Forms;

use Assets;
use Fast\Base\Forms\FormAbstract;
use Fast\Contact\Enums\ContactStatusEnum;
use Fast\Contact\Http\Requests\EditContactRequest;
use Fast\Contact\Models\Contact;

class ContactForm extends FormAbstract
{

    /**
     * @return mixed|void
     * @throws \Throwable
     */
    public function buildForm()
    {

        Assets::addScriptsDirectly('vendor/core/plugins/contact/js/contact.js')
            ->addStylesDirectly('vendor/core/plugins/contact/css/contact.css');

        $this
            ->setupModel(new Contact)
            ->setValidatorClass(EditContactRequest::class)
            ->withCustomFields()
            ->add('status', 'customSelect', [
                'label'      => trans('core/base::tables.status'),
                'label_attr' => ['class' => 'control-label required'],
                'choices'    => ContactStatusEnum::labels(),
            ])
            ->setBreakFieldPoint('status')
            ->addMetaBoxes([
                'information' => [
                    'title'      => trans('plugins/contact::contact.contact_information'),
                    'content'    => view('plugins/contact::contact-info', ['contact' => $this->getModel()])->render(),
                    'attributes' => [
                        'style' => 'margin-top: 0',
                    ],
                ],
                'replies' => [
                    'title'      => trans('plugins/contact::contact.replies'),
                    'content'    => view('plugins/contact::reply-box', ['contact' => $this->getModel()])->render(),
                ],
            ]);
    }
}
