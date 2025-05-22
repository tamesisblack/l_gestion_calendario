<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CordinadorArea extends Model
{
    use HasFactory;
    protected $table = 'cordinador_areas';
    protected $primaryKey = 'id';
    protected $fillable = [
        'user_id',
        'area_id',
        'estado',
    ];
    // Relaciones
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }
}
