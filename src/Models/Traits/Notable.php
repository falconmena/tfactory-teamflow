<?php
namespace Techsfactory\TfactoryTeamflow\Models\Traits;

Trait Notable
{
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