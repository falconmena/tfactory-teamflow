<?php

namespace Techsfactory\TfactoryTeamflow\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Techsfactory\TfactoryTeamflow\Models\Activity;

class ActivityController extends Controller
{
    public function getActivity(Request $request)
    {
        // Get route parameters (activityable_type and activityable_id)
        $routeParams = Route::current()->parameters();
        $activityable_id = $request->input('activityable_id', $routeParams['activityable_id'] ?? null);
        $activityable_type = $request->input('activityable_type', $routeParams['activityable_type'] ?? null);

        if (!$activityable_type || !$activityable_id) {
            throw new \Exception("Activityable entity type and ID are required.");
        }

        $activities = Activity::where('activityable_id', $activityable_id)
            ->where('activityable_type', $activityable_type)
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Success',
            'activities' => $activities
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'activityable_id' => 'required',
            'activityable_type' => 'required',
            'assigned_to' => 'required|integer|exists:users,id',
            'due_date' => ['required', 'regex:/^\d{4}-\d{2}-\d{2}$/'],
            'activity_type' => 'required',
            'content' => 'required|string',
        ]);

        $activityable_id = $request->input('activityable_id', $routeParams['activityable_id'] ?? null);
        $activityable_type = $request->input('activityable_type', $routeParams['activityable_type'] ?? null);

        if (!$activityable_type || !$activityable_id) {
            throw new \Exception("Activityable entity type and ID are required.");
        }

        $activity = Activity::create([
            'activityable_id' => $request->activityable_id,
            'activityable_type' => $request->activityable_type,
            'assigned_to' => $request->assigned_to,
            'title' => $request->title,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'activity_type' => $request->activity_type,
            'description' => $request->content,
        ]);
    }

    public function delete($id)
    {
        $activity = Activity::findOrFail($id);

        if ($activity) {
            $activity->delete();
        }

        return response()->json(['message' => 'activity deleted successfully']);
    }
}
