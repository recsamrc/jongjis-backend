<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    public function image($path)
    {
        $imagePath = '/images/' .$path;
        if ($path && Storage::exists($imagePath)) {
            $content = Storage::get($imagePath);
            $contentType = Storage::getMimeType($imagePath);

            return response($content)
                ->header('Content-Type', $contentType);
        }

        return '';
    }
}
