<?php

namespace App\Services\UploadService;

use App\Http\Requests\api\Uploads\UploadRequest;
use Illuminate\Support\Facades\Storage;

class UploadService
{
    public function store(UploadRequest $request, $modelInstance)
    {
        $validatedData = $request->validated();
        $file = $validatedData['file'];
        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif'];

        if (!in_array($file->getClientOriginalExtension(), $imageExtensions)) {
            return false;
        }

        $path = $file->store('photos/' . class_basename(get_class($modelInstance)), 'public');

        $modelInstance->files()->create([
            'file_name' => $file->hashName(),
            'file_path' => $path
        ]);

        return true;
    }

    public function get($modelInstance)
    {
        return $modelInstance->files;
    }

    public function delete($modelInstance, $file_id = null)
    {
        if ($file_id) {
            $file = $modelInstance->files()->findOrFail($fileId);
            Storage::disk('public')->delete($file->file_path);
            $file->delete();
        } else {
            $files = $modelInstance->files;
            foreach ($files as $file) {
                Storage::disk('public')->delete($file->file_path);
                $file->delete();
            }
        }
        return true;
    }
}
