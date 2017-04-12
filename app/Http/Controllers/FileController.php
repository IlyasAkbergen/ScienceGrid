<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Response;

class FileController extends Controller
{
   
    public function download($filename)
    {
        $file="./uploads/" . $filename;
        return Response::download($file);
    }
}
