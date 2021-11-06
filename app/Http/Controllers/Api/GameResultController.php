<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\GameResult;

class GameResultController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cards = GameResult::orderBy('seconds')->orderBy('attempt')->skip(0)->take(10)->get();
        return $cards;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'seconds' => ['required', 'numeric'],
            'attempt' => ['required', 'numeric'],
        ]);
        $result = new GameResult([
            "seconds" => $request->get('seconds'),
            "attempt" => $request->get('attempt'),
        ]);
        $result->save(); // Finally, save the record.
        return $result->id;
    }

}
