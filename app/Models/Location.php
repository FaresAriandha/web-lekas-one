<?php

namespace App\Models;

use App\Http\Controllers\PasarJayaShipmentController;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Location extends Model
{
    use HasFactory, SoftDeletes, HasUlids; // Aktifkan ULID

    protected $table = 'shipment_pasjay_locations'; // Nama tabel di database
    protected $primaryKey = 'shploc_ID'; // Primary key tetap 'id'
    protected $keyType = 'ulid'; // Laravel 12 otomatis menangani ULID
    public $incrementing = false; // Non-auto-increment karena pakai ULID

    protected $fillable = [
        'shploc_name',
        'shploc_address',
        'spl_ID', // Jakarta Utara, Jakarta Barat, Jakarta Pusat, Jakarta Timur, Jakarta Selatan
        'shploc_url_maps',
    ];

    protected $dates = ['deleted_at']; // Soft delete

    protected $casts = [
        'shploc_ID' => 'string', // ULID disimpan sebagai string
        'deleted_at' => 'datetime',
    ];


    protected static function booted()
    {
        static::deleting(function ($location) {
            if (!$location->isForceDeleting()) {
                // Soft delete relasi shipments & bills
                foreach ($location->pasarJayaShipments as $shipment) {
                    PasarJayaShipmentController::destroyIfLocationGone($shipment);
                }
                // $location->pasarJayaBills()->delete();
            }
        });

        // static::restoring(function ($location) {
        //     // Restore relasi assigns
        //     $location->pasarJayaShipments()->withTrashed()->restore();
        //     $location->pasarJayaBills()->withTrashed()->restore();
        // });
    }


    public function price()
    {
        return $this->belongsTo(Price::class, 'spl_ID', 'spl_ID');
    }

    public function pasarJayaShipments()
    {
        return $this->hasMany(PasarJayaShipment::class, 'shploc_ID', 'shploc_ID');
    }

    public function pasarJayaBills()
    {
        return $this->hasMany(PasarJayaBill::class, 'shploc_ID', 'shploc_ID');
    }
}
