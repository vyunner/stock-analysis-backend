<?php

namespace App\Models;

use App\Http\Requests\api\Uploads\UploadRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class File extends Model
{
    use HasFactory;

    public $timestamps = true;
    protected $fillable = [
        'file_name',
        'file_path',
        'model_type',
        'model_id'
    ];

    public function model()
    {
        return $this->morphTo();
    }}
