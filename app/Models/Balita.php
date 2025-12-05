<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Balita extends Model
{
    protected $table = 'balita';
    protected $primaryKey = 'id_balita';
    public $timestamps = true;

    protected $fillable = [
        'nama_balita','jenis_kelamin','tanggal_lahir','nama_ortu','alamat'
    ];

    // relasi ke pengukuran
    public function pengukuran()
    {
        return $this->hasMany(Pengukuran::class, 'id_balita', 'id_balita')->orderBy('created_at','desc');
    }
}
