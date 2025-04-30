<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaxelShipment extends Model
{
    use HasFactory, SoftDeletes, HasUlids; // Aktifkan ULID

    protected $table = 'shipments_paxel'; // Nama tabel di database
    protected $primaryKey = 'shpxl_ID'; // Primary key tetap 'id'
    protected $keyType = 'ulid'; // Laravel 12 otomatis menangani ULID
    public $incrementing = false; // Non-auto-increment karena pakai ULID

    protected $fillable = [
        'courier_ID', // ulid
        'awb_number', // EM.XBG5FD6NH2-20250313-6-BJT261
        'awb_slot', // Pagi, Siang
        'awb_status', // Siap Antar, Selesai, Dikembalikan 
        'awb_hub', // HALIM, MANGGA DUA
        'awb_finish_time', // hasil pada tabel 11/03/2025, 08:00 WIB
        'awb_pod', // foto pod awb
        'created_at', // foto pod awb
    ];

    protected $dates = ['deleted_at']; // Soft delete

    protected $casts = [
        'shpxl_ID' => 'string', // ULID disimpan sebagai string
        'awb_finish_time' => 'datetime',
        'deleted_at' => 'datetime',
    ];


    public function courier()
    {
        return $this->belongsTo(Courier::class, 'courier_ID', 'courier_ID');
    }
}
