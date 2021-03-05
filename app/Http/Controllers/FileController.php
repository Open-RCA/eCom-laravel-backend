<?php

namespace App\Http\Controllers;

use App\Models\File;;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Mockery\Exception;

class FileController extends Controller
{
    //
    public function save(UploadedFile $file): ?Model {
        try {

            $fileName = ((string) Str::uuid()) .  "." . 'png';

            return File::query()->create([
                'file_url' => '/storage/' .  $file->storeAs('images', $fileName, 'public'),
                'file_name' => $fileName,
                'file_size_type' => 'B',
                'file_size' => $file->getSize(),
                'file_type' => $file->getExtension(),
                'status' => 'SAVED'
            ]);

        } catch (Exception $exception) {
            return null;
        }
    }


}
