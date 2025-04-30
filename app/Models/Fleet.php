<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Fleet extends Model
{
    //
    use HasFactory, SoftDeletes, HasUlids; // Aktifkan ULID

    protected $table = 'fleets'; // Nama tabel di database
    protected $primaryKey = 'fleet_ID'; // Primary key tetap 'id'
    protected $keyType = 'ulid'; // Laravel 12 otomatis menangani ULID
    public $incrementing = false; // Non-auto-increment karena pakai ULID

    protected $fillable = [
        'fleet_nopol',
        'courier_ID',
        'fleet_type', // Van, Pickup, CDE Box
        'fleet_merk',
        'fleet_status', // DIGUNAKAN, TERSEDIA, PERBAIKAN
        'fleet_KIR_date', // pdf
        'fleet_img', // pdf
        'fleet_docs', // pdf
    ];

    protected $dates = ['deleted_at']; // Soft delete

    protected $casts = [
        'fleet_ID' => 'string', // ULID disimpan sebagai string
        'fleet_KIR_date' => 'date',
        'deleted_at' => 'datetime',
    ];


    public function courier()
    {
        return $this->belongsTo(Courier::class, 'courier_ID', 'courier_ID');
    }
}
