<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Crew extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class, 'lokasi_crew_id');
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class, 'id_bank');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class, 'id_crew', 'id_crew');
    }

    public function documents()
    {
        return $this->hasOne(Dokumen::class, 'id_crew', 'id_crew');
    }

    public function proyeks()
    {
        return $this->belongsTo(Proyek::class, 'proyek_crew_id');
    }

    public function absensis()
    {
        return $this->hasMany(Absensi::class, 'id_crew');
    }

    public function cutis()
    {
        return $this->hasMany(Cuti::class, 'id_crew');
    }

}
