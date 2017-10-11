<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DownloadController extends Controller
{
    public function ai() {
        $path = storage_path('downloads/ai.zip');
        return response()->download($path);;
    }
}
