<?php

namespace App\Http\Controllers;

use App\Models\ClaimFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    
    public function downloadFile($uuid)
    {
        $upload = ClaimFile::where('file_uuid', $uuid)->first();
        $path = $upload->file_path;

        if (Storage::disk('public')->exists($path)) {
            
            $downloadName = basename($upload->file_path) . '.' . $upload->file_ext;
            return Storage::disk('public')->download($path, $downloadName);
        } else {
            return redirect()->back();
        }
    }

    public function deleteFile($uuid)
    {
        $upload = ClaimFile::where('file_uuid', $uuid)->first();
        $path = $upload->file_path;

        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
            $upload->delete();
        }

        return redirect()->back();
    }
    
}