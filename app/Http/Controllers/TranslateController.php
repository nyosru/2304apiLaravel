<?php

namespace App\Http\Controllers;

use App\Services\DictonariesOxfordService;
use Illuminate\Http\Request;

class TranslateController extends Controller
{

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        // $translate = [];
        // $translate[ 'data' ]['id'] = 1212;
        // return response()->json(['error' => '', 'data' => $translate]);

        try {
            $translate = DictonariesOxfordService::translate($request->word, $request->fromLang ?? 'en', $request->toLang ?? 'ru');
            return response()->json(['error' => '', 'data' => $translate]);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage(), 'data' => ''], $th->getCode());
        }

    }
}
