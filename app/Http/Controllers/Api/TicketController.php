<?php

namespace App\Http\Controllers\Api;

use App\Models\Ticket;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class TicketController extends Controller
{
    public function store(Request $request)
    {
        if($request->hasFile('file')){
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();

            // Generate random file name
            $random_file_name = Str::uuid()->toString();
            $fileName = 'img/' . $random_file_name .'.'.$extension;

            Storage::disk('local')->put($fileName, $file);
        }

        $ticket = Ticket::create([
            'user_id' => $request->user_id,
            'description' => $request->description,
            'path' => $fileName
        ]);

        return response()->json(['ticket' => $ticket], 200);
    }
}
