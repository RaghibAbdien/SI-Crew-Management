<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;

    protected $table = 'bank';

    // Relasi dengan model Crew
    public function crews()
    {
        return $this->hasMany(Crew::class, 'id_bank');
    }
}
