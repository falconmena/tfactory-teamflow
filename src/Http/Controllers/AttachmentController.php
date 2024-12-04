<?php 
namespace Techsfactory\TfactoryTeamflow\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Techsfactory\TfactoryTeamflow\Models\Note;
use Techsfactory\TfactoryTeamflow\Models\Attachment;

class AttachmentController extends Controller
{
    public function index(Request $request)
    {
        // Get route parameters (attachable_type and attachable_id)
        $routeParams = Route::current()->parameters();
        $attachable_type = $request->input('attachable_type', $routeParams['attachable_type'] ?? null);
        $attachable_id = $request->input('attachable_id', $routeParams['attachable_id'] ?? null);

        if (!$attachable_type || !$attachable_id) {
            throw new \Exception("Attachable entity type and ID are required.");
        }

        // Get all messages related to the notable entity
        $Attachments = Attachment::where('attachable_type', $attachable_type)
            ->where('attachable_id', $attachable_id)
            ->orderBy('created_at', 'desc')
            ->get();

        return $Attachments;
    }

    public function store(Request $request)
    {
        $request->validate([
            'attachment' => 'required|file',
            'attachable_id' => 'required|integer',
            'attachable_type' => 'required|string',
        ]);

        $attachment = $request->file('attachment');
        $attachment_path = '';
        $attachment_type = '';

        if ($request->hasFile('attachment') && $attachment->isValid()) {
            $attachmenttype = $attachment->getClientOriginalExtension();
            $attachmentName = time() . '-' . $attachment->getClientOriginalExtension();
            $savePath = '/public/tfactory-teamflow/attachments/';
            $imgPath = '/storage/tfactory-teamflow/attachments/';
            $attachment_path = $imgPath . $attachmentName;
            Storage::putFileAs($savePath, $attachment, $attachmentName);
        }

        $attachment = Attachment::create([
            'media_type' => 'message',
            'media_path' => $attachment_path,
            'created_by' => Auth::id(),
            'attachable_type' => $request->attachable_type,
            'attachable_id' => $request->attachable_id,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Attachment added',
            'attachment' => $attachment,
        ], 200);
    }
}
