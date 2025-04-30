<?php

namespace App\Models;

use App\Models\Courier;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PasarJayaShipment extends Model
{
    use HasFactory, SoftDeletes, HasUlids; // Aktifkan ULID

    protected $table = 'shipments_pasjay'; // Nama tabel di database
    protected $primaryKey = 'shpsj_ID'; // Primary key tetap 'id'
    protected $keyType = 'ulid'; // Laravel 12 otomatis menangani ULID
    public $incrementing = false; // Non-auto-increment karena pakai ULID

    protected $fillable = [
        'courier_ID', // ulid
        'shploc_ID', // ulid
        'rit', // unsignedinteger
        'roundtrip', // varchar dan nullable
        'image', // varchar
        'created_at', // timestamp
    ];

    protected $dates = ['deleted_at']; // Soft delete

    protected $casts = [
        'shpsj_ID' => 'string', // ULID disimpan sebagai string
        'deleted_at' => 'datetime',
    ];


    public function courier()
    {
        return $this->belongsTo(Courier::class, 'courier_ID', 'courier_ID');
    }

    public function location()
    {
        return $this->belongsTo(Location::class, 'shploc_ID', 'shploc_ID');
    }
}
