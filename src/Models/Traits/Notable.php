<?php
namespace Techsfactory\TfactoryTeamflow\Models\Traits;

use Techsfactory\TfactoryTeamflow\Models\Note;

Trait Notable
{
    public function sendMessage()
    {
        Note::create([
            'type' => 'message',
            'content' => request()->message,
            'created_by' => request()->created_by ?? auth()->id(),
            'notable_type' => self::class,
            'notable_id' => $this->id,
        ]);
    }
    public function messages()
    {
        return Note::query()
                ->where('notable_type','=',self::class)
                ->where('type','=','message')
                ->where('notable_id','=',$this->id);
    }

    public function notes()
    {
        return Note::query()
                ->where('notable_type','=',self::class)
                ->where('type','=','note')
                ->where('notable_id','=',$this->id);
    }
}