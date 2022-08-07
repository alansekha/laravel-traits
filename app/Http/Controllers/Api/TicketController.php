<?php

namespace App\Http\Controllers\Api;

use App\Models\Ticket;
use App\Traits\UploadFile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TicketController extends Controller
{
    use UploadFile;
    
    public function store(Request $request)
    {
        if($request->hasFile('file')){
            $fileName = $this->uploadFile($request->file('file'));
        }

        $ticket = Ticket::create([
            'user_id' => $request->user_id,
            'description' => $request->description,
            'path' => $fileName
        ]);

        return response()->json(['ticket' => $ticket], 200);
    }
}
