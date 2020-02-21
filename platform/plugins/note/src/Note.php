<?php

namespace Fast\Note;

use Auth;
use Fast\Note\Repositories\Interfaces\NoteInterface;
use Eloquent;

class Note
{
    /**
     * @var NoteInterface
     */
    protected $noteRepository;

    /**
     * Gallery constructor.
     * @author Imran Ali
     */
    public function __construct(NoteInterface $noteRepository)
    {
        $this->noteRepository = $noteRepository;
    }

    /**
     * @param string | array $screen
     * @return Note
     * @author Imran Ali
     */
    public function registerModule($screen)
    {
        if (!is_array($screen)) {
            $screen = [$screen];
        }
        config(['plugins.note.general.supported' => array_merge(config('plugins.note.general.supported'), $screen)]);
        return $this;
    }

    /**
     * @param string $screen
     * @param \Illuminate\Http\Request $request
     * @param Eloquent| false $object
     * @author Imran Ali
     */
    public function saveNote($screen, $request, $object)
    {
        if (in_array($screen, config('plugins.note.general.supported')) && $request->input('note')) {
            $note = $this->noteRepository->getModel();
            $note->note = $request->input('note');
            $note->user_id = Auth::user()->getKey();
            $note->created_by = Auth::user()->getKey();
            $note->reference_type = $screen;
            $note->reference_id = $object->id;
            $this->noteRepository->createOrUpdate($note);
        }
    }

    /**
     * @param \Eloquent|false $data
     * @param string $screen
     * @return mixed
     * @author Imran Ali
     */
    public function deleteNote($screen, $data)
    {
        if ($data instanceof Eloquent) {
            $this->noteRepository->deleteBy([
                'reference_id' => $data->id,
                'reference_type' => $screen,
            ]);
            return true;
        }
        return false;
    }
}
