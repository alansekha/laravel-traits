<?php

namespace App\Http\Controllers\Api;

use App\Models\Complaint;
use App\Traits\UploadFile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ComplaintController extends Controller
{
    use UploadFile;
    
    public function store(Request $request)
    {
        if($request->hasFile('file')){
            $fileName = $this->uploadFile($request->file('file'));
        }

        $complaint = Complaint::create([
            'user_id' => $request->user_id,
            'description' => $request->description,
            'path' => $fileName
        ]);

        return response()->json(['complaint' => $complaint], 200);
    }
}
