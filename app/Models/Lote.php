<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lote extends Model
{
    use HasFactory;

    public function quadra(){
        return $this->belongsTo(Quadra::class);
    }

    public function proprietarios(){
        return $this->hasMany(Proprietario::class);
    }

    protected $fillable = [
        'descricao',
        'area',
        'valor',
        'status',
        'quadra_id'
    ];
}
