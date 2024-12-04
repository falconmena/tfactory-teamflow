<?php 
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Techsfactory\TfactoryTeamflow\Models\Note;
use Techsfactory\TfactoryTeamflow\Models\Attachment;

class AttachmentController extends Controller
{
    public function index(Request $request)
    {
        // Get route parameters (notableType and notableId)
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
}
