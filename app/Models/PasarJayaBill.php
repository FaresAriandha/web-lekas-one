<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUlids;

class PasarJayaBill extends Model
{
    use HasFactory, SoftDeletes, HasUlids; // Aktifkan ULID

    protected $table = 'pasjay_bills'; // Nama tabel di database
    protected $primaryKey = 'pjb_ID'; // Primary key tetap 'id'
    protected $keyType = 'ulid'; // Laravel 12 otomatis menangani ULID
    public $incrementing = false; // Non-auto-increment karena pakai ULID

    protected $fillable = [
        'courier_ID', // ulid ke tabel couriers
        'shploc_ID', // ulid ke tabel shipment_pasjay_locations
        'rit', // unsignedinteger
        'total_location', // unsignedinteger
        'total_bill_client', // unsignedinteger
        'total_charge', // unsignedinteger
        'paid_to_courier', // unsignedinteger
        'roundtrip', // boolean, true atau false, default false
        'keterangan', // string dan nullable
        'created_at',
    ];

    protected $dates = ['deleted_at']; // Soft delete

    protected $casts = [
        'pjb_ID' => 'string', // ULID disimpan sebagai string
        'deleted_at' => 'datetime',
        'roundtrip' => 'boolean',
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
