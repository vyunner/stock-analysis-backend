<?php

namespace App\Http\Controllers\Api\Uploads;

use App\Http\Controllers\Controller;
use App\Models\Photo;
use Illuminate\Http\Request;

class PhotoController extends Controller
{
    public function store()
    {
        $path = request()->file('photo')->store('uploads', 'public');
        Photo::create(['path' => "/storage/$path"]);

        return response([], 200);
    }
}
