<?php
namespace Techsfactory\TfactoryTeamflow\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $table = 'tfactory_teamflow_notes';
    protected $fillable = ['notable_id', 'notable_type', 'created_by', 'type', 'content'];

    public function notable()
    {
        return $this->morphTo();
    }

    public function creator()
    {
        return $this->belongsTo(config('tfacttory-teamflow.user_model'), 'created_by');
    }

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable');
    }
}