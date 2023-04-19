<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    public $timestamps = true;
    protected $fillable = [
        'file_name',
        'model_type',
        'model_id'
    ];

    public function model(){
        return $this->morphTo();
    }
}
