<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\FileRequest;
use App\Traits\UploadTrait;
use Illuminate\Http\Request;

class FileController extends Controller
{
    use UploadTrait;

    public function upload(FileRequest $request)
    {
        $file = $request->file('file');
        $filePath = $this->uploadOne($file, 'img');
        return $filePath;
    }
}
