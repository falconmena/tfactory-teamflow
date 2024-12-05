<?php
namespace Techsfactory\TfactoryTeamflow\Models;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $table = 'tf_teamflow_attachments';
    protected $fillable = ['media_type', 'media_path', 'attachable_type', 'attachable_id'];

    public function attachable()
    {
        return $this->morphTo();
    }

    public function creator()
    {
        return $this->belongsTo(config('tfacttory-teamflow.user_model'), 'created_by');
    }
}