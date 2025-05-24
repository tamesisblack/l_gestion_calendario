<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;
    protected $table = 'areas';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nombre_area',
    ];
    public function cordinadores()
    {
        return $this->belongsToMany(User::class, 'cordinador_areas', 'area_id', 'user_id')->where('estado', 1);
    }
}
