<?php
namespace Techsfactory\TfactoryTeamflow\Models;

use Illuminate\Database\Eloquent\Model;

class Watcher extends Model
{
    protected $table = 'tf_teamflow_watchers';
    protected $fillable = ['user_id', 'watchable_id', 'watchable_type'];

    public function watchable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(config('tfacttory-teamflow.user_model'));
    }
}