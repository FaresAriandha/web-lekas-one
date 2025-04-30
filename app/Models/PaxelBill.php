<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PaxelBill extends Model
{
    use HasFactory, SoftDeletes, HasUlids; // Aktifkan ULID

    protected $table = 'paxel_bills'; // Nama tabel di database
    protected $primaryKey = 'pxb_ID'; // Primary key tetap 'id'
    protected $keyType = 'ulid'; // Laravel 12 otomatis menangani ULID
    public $incrementing = false; // Non-auto-increment karena pakai ULID

    protected $fillable = [
        'courier_ID', // ulid
        'awb_total', // unsignedinteger(5)
        'awb_slot', // enum = Pagi, Siang
        'total_bill_client', // unsignedinteger(10)
        'total_paid_client', // unsignedinteger(10), default = 0
        'paid_to_courier', // unsignedinteger(10), default = 0
        'keterangan', // string dan nullable
        'created_at',
    ];

    protected $dates = ['deleted_at']; // Soft delete

    protected $casts = [
        'pxb_ID' => 'string', // ULID disimpan sebagai string
        'deleted_at' => 'datetime',
    ];


    public function courier()
    {
        return $this->belongsTo(Courier::class, 'courier_ID', 'courier_ID');
    }
}
