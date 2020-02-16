<?php

namespace Fast\Software\Forms;

use Assets;
use Fast\Base\Enums\BaseStatusEnum;
use Fast\Base\Forms\FormAbstract;
use Fast\Software\Forms\Fields\CategoryMultiField;
use Fast\Software\Forms\Fields\CompatibilityMultiField;
use Fast\Software\Forms\Fields\LanguageMultiField;
use Fast\Software\Forms\Fields\SystemMultiField;
use Fast\Software\Http\Requests\SoftwareRequest;
use Fast\Software\Models\Software;
use Fast\Software\Repositories\Interfaces\CategoryInterface;
use Fast\Software\Repositories\Interfaces\SystemInterface;

class SoftwareForm extends FormAbstract
{

    /**
     * @var string
     */
    protected $template = 'core/base::forms.form-tabs';

    /**
     * @return mixed|void
     * @throws \Throwable
     */
    public function buildForm()
    {
        Assets::addScripts(['bootstrap-tagsinput', 'typeahead'])
            ->addStyles(['bootstrap-tagsinput'])
            ->addScriptsDirectly('vendor/core/js/tags.js');

        $selectedCategories = [];
        if ($this->getModel()) {
            $selectedCategories = $this->getModel()->categories()->pluck('category_id')->all();
        }

        if (empty($selectedCategories)) {
            $selectedCategories = app(CategoryInterface::class)
                ->getModel()
                ->where('is_default', 1)
                ->pluck('id')
                ->all();
        }

        $selectedSystems = [];
        if ($this->getModel()) {
            $selectedSystems = $this->getModel()->systems()->pluck('system_id')->all();
        }

        $selectedLanguages = [];
        if ($this->getModel()) {
            $selectedLanguages = $this->getModel()->languages()->pluck('language_id')->all();
        }

        $selectedCompatibilities = [];
        if ($this->getModel()) {
            $selectedCompatibilities = $this->getModel()->compatibilities()->pluck('compatibility_id')->all();
        }

        $tags = null;

        if ($this->getModel()) {
            $tags = $this->getModel()->tags()->pluck('name')->all();
            $tags = implode(',', $tags);
        }

        if (!$this->formHelper->hasCustomField('categoryMulti')) {
            $this->formHelper->addCustomField('categoryMulti', CategoryMultiField::class);
        }
        if (!$this->formHelper->hasCustomField('systemMulti')) {
            $this->formHelper->addCustomField('systemMulti', SystemMultiField::class);
        }
        if (!$this->formHelper->hasCustomField('langMulti')) {
            $this->formHelper->addCustomField('langMulti', LanguageMultiField::class);
        }
        if (!$this->formHelper->hasCustomField('compMulti')) {
            $this->formHelper->addCustomField('compMulti', CompatibilityMultiField::class);
        }

        $this
            ->setupModel(new Software())
            ->setValidatorClass(SoftwareRequest::class)
            ->withCustomFields()
            ->add('name', 'text', [
                'label'      => trans('core/base::forms.name'),
                'label_attr' => ['class' => 'control-label required'],
                'attr'       => [
                    'placeholder'  => trans('core/base::forms.name_placeholder'),
                    'data-counter' => 120,
                ],
            ])
            ->add('description', 'textarea', [
                'label'      => trans('core/base::forms.description'),
                'label_attr' => ['class' => 'control-label'],
                'attr'       => [
                    'rows'         => 4,
                    'placeholder'  => trans('core/base::forms.description_placeholder'),
                    'data-counter' => 400,
                ],
            ])
            ->add('is_featured', 'onOff', [
                'label'         => trans('core/base::forms.is_featured'),
                'label_attr'    => ['class' => 'control-label'],
                'default_value' => false,
            ])
            ->add('content', 'editor', [
                'label'      => trans('core/base::forms.content'),
                'label_attr' => ['class' => 'control-label'],
                'attr'       => [
                    'rows'            => 4,
                    'placeholder'     => trans('core/base::forms.description_placeholder'),
                    'with-short-code' => true,
                ],
            ])
            ->add('download_link_32', 'text', [
                'label'      => trans('plugins/software::softwares.form.download_link_32'),
                'label_attr' => ['class' => 'control-label'],
                'attr'       => [
                    'placeholder'  => trans('plugins/software::softwares.form.download_32_placeholder'),
                ],
            ])
            ->add('download_link_64', 'text', [
                'label'      => trans('plugins/software::softwares.form.download_link_64'),
                'label_attr' => ['class' => 'control-label'],
                'attr'       => [
                    'placeholder'  => trans('plugins/software::softwares.form.download_64_placeholder'),
                ],
            ])
            ->add('status', 'customSelect', [
                'label'      => trans('core/base::tables.status'),
                'label_attr' => ['class' => 'control-label required'],
                'choices'    => BaseStatusEnum::labels(),
            ])
            ->add('format_type', 'customRadio', [
                'label'      => trans('plugins/software::softwares.form.format_type'),
                'label_attr' => ['class' => 'control-label required'],
                'choices'    => get_post_formats(true),
            ])
            ->add('categories[]', 'categoryMulti', [
                'label'      => trans('plugins/software::softwares.form.categories'),
                'label_attr' => ['class' => 'control-label required'],
                'choices'    => get_software_categories_with_children(),
                'value'      => old('categories', $selectedCategories),
            ])
            ->add('systems[]', 'systemMulti', [
                'label'      => trans('plugins/software::softwares.form.systems'),
                'label_attr' => ['class' => 'control-label'],
                'choices'    => get_all_systems(['status' => 'published']),
                'value'      => old('systems', $selectedSystems),
            ])
            ->add('languages[]', 'langMulti', [
                'label'      => trans('plugins/software::softwares.form.languages'),
                'label_attr' => ['class' => 'control-label'],
                'choices'    => get_all_software_languages(['status' => 'published']),
                'value'      => old('languages', $selectedLanguages),
            ])
            ->add('compatibilities[]', 'compMulti', [
                'label'      => trans('plugins/software::softwares.form.compatibilities'),
                'label_attr' => ['class' => 'control-label'],
                'choices'    => get_all_compatibilities(['status' => 'published']),
                'value'      => old('compatibilities', $selectedCompatibilities),
            ])
            ->add('image', 'mediaImage', [
                'label'      => trans('core/base::forms.image'),
                'label_attr' => ['class' => 'control-label'],
            ])
            ->add('tag', 'text', [
                'label'      => trans('plugins/software::softwares.form.tags'),
                'label_attr' => ['class' => 'control-label'],
                'attr'       => [
                    'class'       => 'form-control',
                    'id'          => 'tags',
                    'data-role'   => 'tagsinput',
                    'placeholder' => trans('plugins/software::softwares.form.tags_placeholder'),
                ],
                'value'      => $tags,
                'help_block' => [
                    'text' => 'Tag route',
                    'tag'  => 'div',
                    'attr' => [
                        'data-tag-route' => route('tags.all'),
                        'class'          => 'hidden',
                    ],
                ],
            ])
            ->setBreakFieldPoint('status');
    }
}
