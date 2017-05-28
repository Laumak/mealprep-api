<?php

namespace App\Http\Controllers;

use Storage;
use Illuminate\Http\Request;

use App\Meal;

class FileUploadController extends Controller {
    public function store($id, Request $request) {
        $file = $request->file("file");

        if($file) {
            $name = $file->getClientOriginalName();
            $path = $file->store("images", "s3");

            $meal = Meal::whereId($id)->first();
            $meal->headerImage()->create([
                "title"       => $name,
                "description" => null,
                "url"         => $path,
            ]);

            return response()->json([
                "message" => "success",
            ], 201);
        }

        return response()->json([
            "message" => "Upload failed",
        ], 500);
    }
}
