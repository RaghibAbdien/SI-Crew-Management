<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dokumen extends Model
{
    use HasFactory;

    protected $table = 'dokumens';

    protected $guarded = ['id'];

    public function crew()
    {
        return $this->belongsTo(Crew::class, 'id_crew', 'id_crew');
    }
}
