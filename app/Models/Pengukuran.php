<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pengukuran extends Model
{
    protected $table = 'pengukuran';
    protected $primaryKey = 'id_pengukuran';
    public $timestamps = true;

    protected $fillable = [
        'id_balita','id_user','usia_bulan','berat_badan','tinggi_badan','lingkar_kepala','lila'
    ];

    public function balita()
    {
        return $this->belongsTo(Balita::class, 'id_balita', 'id_balita');
    }

    public function statusGizi()
    {
        return $this->hasOne(StatusGizi::class, 'id_pengukuran', 'id_pengukuran');
    }
}
