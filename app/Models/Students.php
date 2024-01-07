<?php

namespace App\Models;

use App\Http\Controllers\RomblesController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Students extends Model
{
    use HasFactory;

    protected $fillable = [
        'nis',
        'name',
        'rombel_id',
        'rayon_id'
    ];

    public function rombel() {
        return $this->belongsTo(Rombles::class);
    }

    public function rayon() {
        return $this->belongsTo(Rayons::class);
    }

    public function late() {
        return $this->hasMany(Lates::class, 'student_id', 'id');
    }

    
}
