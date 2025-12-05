<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusGizi extends Model
{
    protected $table = 'status_gizi';
    protected $primaryKey = 'id_status';
    public $timestamps = true;

    protected $fillable = ['id_pengukuran','id_balita','hasil_status_gizi'];

    public function pengukuran()
    {
        return $this->belongsTo(Pengukuran::class, 'id_pengukuran', 'id_pengukuran');
    }
}
