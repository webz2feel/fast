<?php

namespace Fast\CustomField\Actions;

use Auth;
use Fast\Base\Events\CreatedContentEvent;
use Fast\CustomField\Repositories\Interfaces\FieldGroupInterface;

class CreateCustomFieldAction extends AbstractAction
{
    /**
     * @var FieldGroupInterface
     */
    protected $fieldGroupRepository;

    /**
     * CreateCustomFieldAction constructor.
     * @param FieldGroupInterface $fieldGroupRepository
     */
    public function __construct(FieldGroupInterface $fieldGroupRepository)
    {
        $this->fieldGroupRepository = $fieldGroupRepository;
    }

    /**
     * @param array $data
     * @return array
     */
    public function run(array $data)
    {
        $data['created_by'] = Auth::user()->id;
        $data['updated_by'] = Auth::user()->id;

        $result = $this->fieldGroupRepository->createFieldGroup($data);

        event(new CreatedContentEvent(CUSTOM_FIELD_MODULE_SCREEN_NAME, request(), $result));

        if (!$result) {
            return $this->error();
        }

        return $this->success(null, [
            'id' => $result,
        ]);
    }
}
