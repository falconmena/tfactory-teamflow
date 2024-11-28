<?php
namespace Techsfactory\TfactoryTeamflow\Http\Livewire;

use Exception;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Techsfactory\TfactoryTeamflow\Models\Note;

class SendMessage extends Component
{
    public $message;
    public $notableId;
    public $notableType;
    public $type = 'message';  //(can be 'note' or 'message')
    public $messages = [];  // To store the messages


    // Validation rules
    protected $rules = [
        'message' => 'required|string',
        'notableId' => 'required|integer',
        'notableType' => 'required|string',
    ];

    public function send()
    {
        $this->validate();

        // Create the message (note)
        Note::create([
            'type' => $this->type,
            'content' => $this->message,
            'created_by' => Auth::id(),
            'notable_type' => $this->notableType,
            'notable_id' => $this->notableId,
        ]);

        $this->reset();

        session()->flash('success', __('Message sent successfully!'));
    }

    public function mount()
    {
        $this->detectNotableEntity();
        $this->loadMessages();
    }

    public function loadMessages()
    {
        $this->messages = Note::where('notable_type', $this->notableType)
            ->where('notable_id', $this->notableId)
            ->where('type', 'message')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function render()
    {
        return view('tfactory-teamflow::livewire.send-message');
    }

    private function detectNotableEntity()
    {
        $routeParams = Route::current()->parameters();

        if(
            empty($this->notableType)
            || empty($this->notableId)
        ){
            if (count($routeParams) > 0) {
                $firstKey = array_key_first($routeParams);
                if(empty($this->notableType)){
                    $this->notableType = get_class($routeParams[$firstKey]);
                }
                if(empty($this->notableId)){
                    $this->notableId = $routeParams[$firstKey]->id;
                }
            }
            else{
                throw new Exception("This livewire component should be embeded inside entity show/edit views");
            }
        }
    }

}