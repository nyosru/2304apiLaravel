<?php

namespace App\Http\Controllers;

use App\Http\Resources\HistoryResource;
use App\Models\History;
use Illuminate\Http\Request;

class HistoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $lang = $request->lang ?? 'ru';
        // return HistoryResource::collection(History::latest()->take(5)->get());
        return HistoryResource::collection(History::where('toLang', '=', $lang)->latest()->take(5)->get());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    static public function store(array $translate, $toLang = 'ru')
    {
        try {

            $history = new History;
            $history->word = $translate['id'];
            $history->toLang = $toLang;
            $history->translate = $translate['results'][0]['lexicalEntries'][0]['entries'][0]['senses'][0]['translations'][0]['text'];
            $history->data = json_encode($translate);
            return $history->save();
        } catch (\Throwable $th) {

            // dd([ 'error' , $th ]);
            // нет перевода, ничего не пишем
            return false;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(History $history)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(History $history)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, History $history)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(History $history)
    {
        //
    }
}
