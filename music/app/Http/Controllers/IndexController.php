<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __invoke() {

        $firstWord = 'Hello';
        $secondWord = 'World!';

        $greeting = $firstWord . " " . $secondWord;

        $greetingResponse = [
            'greeting' => $greeting
        ];

        return response()->json($greetingResponse);
    }
}
