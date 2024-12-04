<?php 
namespace TfactoryTeamflow\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Techsfactory\TfactoryTeamflow\Models\Note;

class SendMessageController extends Controller
{
    public function index(Request $request)
    {
        // Get route parameters (notableType and notableId)
        $routeParams = Route::current()->parameters();
        $notableType = $request->input('notableType', $routeParams['notableType'] ?? null);
        $notableId = $request->input('notableId', $routeParams['notableId'] ?? null);

        if (!$notableType || !$notableId) {
            throw new \Exception("Notable entity type and ID are required.");
        }

        // Get all messages related to the notable entity
        $messages = Note::where('notable_type', $notableType)
            ->where('notable_id', $notableId)
            ->where('type', 'message')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('tfactory-teamflow::send-message', compact('messages', 'notableType', 'notableId'));
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
            'created_by' => Auth::id(),
            'notable_type' => $request->notableType,
            'notable_id' => $request->notableId,
        ]);

        return redirect()->route('teamflow.sendMessage', [
            'notableType' => $request->notableType,
            'notableId' => $request->notableId,
        ])->with('success', 'Message sent successfully!');
    }
}
