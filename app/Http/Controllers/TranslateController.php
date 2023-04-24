<?php

namespace App\Http\Controllers;

use App\Services\DictonariesOxfordService;
use Illuminate\Http\Request;
use App\Http\Controllers\HistoryController;

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

            $translate = (array) DictonariesOxfordService::translate($request->word, $request->fromLang ?? 'en', $request->toLang ?? 'ru');
            // if (!empty($translate->message)) {
            //     return response()->json(['error' => $translate->message, 'data' => '']);
            // } else {

            $addRes = HistoryController::store($translate, $request->toLang);
            // dd(['$addRes',$addRes]);

            return response()->json(['error' => '', 'data' => $translate]);

            // }
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage(), 'data' => ''], ($th->getCode() > 0 ? $th->getCode() : 400));
        }
    }
}
