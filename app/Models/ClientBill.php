<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ClientBill extends Model
{
    use HasFactory, SoftDeletes, HasUlids; // Aktifkan ULID

    protected $table = 'client_bills'; // Nama tabel di database
    protected $primaryKey = 'cb_ID'; // Primary key tetap 'id'
    protected $keyType = 'ulid'; // Laravel 12 otomatis menangani ULID
    public $incrementing = false; // Non-auto-increment karena pakai ULID

    protected $fillable = [
        'cb_type', // enum: pasjay,paxel
        'total_bill_client', // unsignedinteger(10)
        'total_paid_client', // unsignedinteger(10), default = 0
        'keterangan', // string dan nullable
        'created_at',
    ];

    protected $dates = ['deleted_at']; // Soft delete

    protected $casts = [
        'cb_ID' => 'string', // ULID disimpan sebagai string
        'deleted_at' => 'datetime',
    ];
}
