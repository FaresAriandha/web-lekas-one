<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Assignee extends Model
{
    use HasFactory, SoftDeletes, HasUlids; // Aktifkan ULID

    protected $table = 'courier_assigns'; // Nama tabel di database
    protected $primaryKey = 'cas_ID'; // Primary key tetap 'id'
    protected $keyType = 'ulid'; // Laravel 12 otomatis menangani ULID
    public $incrementing = false; // Non-auto-increment karena pakai ULID

    protected $fillable = [
        'courier_ID',
        'cas_type', // pasjay, paxel
        'cas_pickup_time', // hasil pada tabel 11/03/2025, 08:00 WIB
        'cas_arrived_time', // hasil pada tabel 11/03/2025, 08:00 WIB
        'cas_start_time', // hasil pada tabel 11/03/2025, 08:00 WIB
        'cas_finish_time', // hasil pada tabel 11/03/2025, 14:00 WIB
        'cas_status', // Ditugaskan, Sudah Tiba, Dalam Tugas, Selesai
    ];

    protected $dates = ['deleted_at']; // Soft delete

    protected $casts = [
        'cas_ID' => 'string', // ULID disimpan sebagai string
        'cas_pickup_time' => 'datetime',
        'cas_arrived_time' => 'datetime',
        'cas_start_time' => 'datetime',
        'cas_finish_time' => 'datetime',
        'deleted_at' => 'datetime',
    ];


    public function courier()
    {
        return $this->belongsTo(Courier::class, 'courier_ID', 'courier_ID');
    }
}
