<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Price extends Model
{
    use HasFactory, SoftDeletes, HasUlids; // Aktifkan ULID

    protected $table = 'shipment_price_lists'; // Nama tabel di database
    protected $primaryKey = 'spl_ID'; // Primary key tetap 'id'
    protected $keyType = 'ulid'; // Laravel 12 otomatis menangani ULID
    public $incrementing = false; // Non-auto-increment karena pakai ULID

    protected $fillable = [
        'spl_name', // varchar(100)
        'spl_type', // enum: pasjay, paxel
        'spl_baseprice', // integer(100)
        'spl_baseprice_client', // integer(100)
        'spl_multidrop', // integer(100)
        'spl_multidrop_client', // integer(100)
        'spl_roundtrip', // integer(100)
        'spl_roundtrip_client', // integer(100)
    ];

    protected $dates = ['deleted_at']; // Soft delete

    protected $casts = [
        'spl_ID' => 'string', // ULID disimpan sebagai string
        'deleted_at' => 'datetime',
    ];


    protected static function booted()
    {
        static::deleting(function ($price) {
            if (!$price->isForceDeleting()) {
                // Soft delete locations (trigger event di Location)
                foreach ($price->locations as $location) {
                    $location->delete(); // ini akan trigger booted() di Location
                }
            }
        });

        static::restoring(function ($price) {
            // Restore relasi locations
            $price->locations()->withTrashed()->restore();
        });
    }

    public function locations()
    {
        return $this->hasMany(Location::class, 'spl_ID', 'spl_ID');
    }
}
