<?php
namespace Techsfactory\TfactoryTeamflow\Models;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $table = 'tf_teamflow_activites';
    protected $fillable = ['activityable_type', 'activityable_id', 'assigned_to', 'title', 'due_date', 'activity_type', 'description'];

    public function activityable()
    {
        return $this->morphTo();
    }

    public function assigned_to()
    {
        return $this->belongsTo(config('tfacttory-teamflow.user_model'), 'assigned_to');
    }
}