<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Card;
use App\Http\Controllers\Controller;

class CardController extends Controller
{
    public function index(Request $request) {
        $request->validate([
            'limit' => ['required', 'numeric'],
        ]);
        $cards = Card::skip(0)->take($request->limit)->get();
        $cards->each(function($card) {
           $card->img = '/upload/' . $card->file_path;
        });
        return $cards;
    }
    public function create()
    {
        return view('card');
    }
    public function store(Request $request)
    {
        // Validate the inputs
        $request->validate([
            'name' => 'required',
        ]);

        // ensure the request has a file before we attempt anything else.
//        if ($request->hasFile('file')) {

//            $request->validate([
//                'image' => 'mimes:jpeg,bmp,png' // Only allow .jpg, .bmp and .png file types.
//            ]);
//
//            // Save the file locally in the storage/public/ folder under a new folder named /product
//            $request->file->store('public');

            // Store the record, using the new file hashname which will be it's new filename identity.
            $card = new Card([
                "name" => $request->get('name'),
                "file_path" => $request->get('name')
            ]);
            $card->save(); // Finally, save the record.
//        }

        return view('card');

    }
}
