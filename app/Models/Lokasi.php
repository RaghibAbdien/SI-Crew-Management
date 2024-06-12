<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lokasi extends Model
{
    use HasFactory;

    protected $table = 'lokasi';
    protected $guarded = ['id'];

    // Relasi dengan model Crew
    public function crews()
    {
        return $this->hasMany(Crew::class, 'lokasi_crew_id');
    }

    public function proyek()
    {
        return $this->hasOne(Proyek::class, 'lokasi_proyek_id');
    }
}
