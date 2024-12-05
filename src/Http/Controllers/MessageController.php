<?php 
namespace Techsfactory\TfactoryTeamflow\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Techsfactory\TfactoryTeamflow\Models\Note;

class MessageController extends Controller
{

    public function get_logs($notableId)
    {
        $logs = Note::select()
            ->where('notable_type', self::class)
            ->where('notable_id', $notableId)
            ->orderBy('created_at', 'desc')
            ->with('creator')
            ->get();

        return $logs;
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
