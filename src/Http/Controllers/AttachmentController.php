<?php

namespace Techsfactory\TfactoryTeamflow\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Techsfactory\TfactoryTeamflow\Models\Attachment;

class AttachmentController extends Controller
{
    public function getRecentFiles(Request $request)
    {
        // Get route parameters (attachable_type and attachable_id)
        $routeParams = Route::current()->parameters();
        $attachable_type = $request->input('attachable_type', $routeParams['attachable_type'] ?? null);
        $attachable_id = $request->input('attachable_id', $routeParams['attachable_id'] ?? null);

        if (!$attachable_type || !$attachable_id) {
            throw new \Exception("Attachable entity type and ID are required.");
        }

        $attachments = Attachment::where('attachable_id', $request->attachable_id)
            ->where('attachable_type', $request->attachable_type)
            ->get();

        return response()->json(
            $attachments->map(function ($attachment) {
                $fileSize = Storage::disk('public')->size($attachment->media_path);
                return [
                    'id' => $attachment->id,
                    'name' => basename($attachment->media_path),
                    'url' => Storage::url($attachment->media_path),
                    'media_type' => $attachment->media_type,
                    'size' => $fileSize,
                    'created_at' => $attachment->created_at->toDateTimeString(),
                ];
            })
        );
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|file',
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

        $activeGuard = $this->getLoggedInGuard();
        if ($activeGuard) {
            $userId = Auth::guard($activeGuard)->id(); // Get the logged-in user's ID
        } else {
            $userId = Auth::id();
        }

        $attachment = Attachment::create([
            'media_type' => 'message',
            'media_path' => $attachment_path,
            'created_by' => $userId,
            'attachable_type' => $request->attachable_type,
            'attachable_id' => $request->attachable_id,
        ]);

        $fileSize = Storage::disk('public')->size($attachment->media_path);

        return response()->json([
            'id' => $attachment->id,
            'name' => $attachment->name,
            'size' => $fileSize,
            'url' => asset($attachment_path),
        ]);
    }

    public function delete($id)
    {
        $attachment = Attachment::findOrFail($id);

        // Delete file from storage
        if (Storage::disk('public')->exists($attachment->path)) {
            Storage::disk('public')->delete($attachment->path);
        }

        // Delete database record
        $attachment->delete();

        return response()->json(['message' => 'File deleted successfully']);
    }

    function getLoggedInGuard()
    {
        foreach (config('auth.guards') as $guard => $guardConfig) {
            if (Auth::guard($guard)->check()) {
                return $guard; // Return the name of the active guard
            }
        }

        return null; // No guard is logged in
    }
}
