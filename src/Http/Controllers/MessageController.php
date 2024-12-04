<?php 
namespace Techsfactory\TfactoryTeamflow\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Techsfactory\TfactoryTeamflow\Models\Note;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        $data = [];
        // Get route parameters (notableType and notableId)
        $routeParams = Route::current()->parameters();
        $data['notableType'] = $request->input('notableType', $routeParams['notableType'] ?? null);
        $data['notableId'] = $request->input('notableId', $routeParams['notableId'] ?? null);

        if (!$data['notableType'] || !$data['notableId']) {
            throw new \Exception("Notable entity type and ID are required.");
        }

        // Get all messages related to the notable entity
        $data['messages'] = Note::where('notable_type', $data['notableType'])
            ->where('notable_id', $data['notableId'])
            ->where('type', 'message')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('tfactory-teamflow::message', $data);
    }

    public function send(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
            'notableId' => 'required|integer',
            'notableType' => 'required|string',
        ]);

        // Create the message (note)
        Note::create([
            'type' => 'message',
            'content' => $request->message,
            'created_by' => $request->created_by,
            'notable_type' => $request->notableType,
            'notable_id' => $request->notableId,
        ]);

        return redirect()->back()->with('success', 'Message sent successfully!');
    }
}
