<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Courier extends Model
{
    //
    use HasFactory, SoftDeletes, HasUlids; // Aktifkan ULID

    protected $table = 'couriers'; // Nama tabel di database
    protected $primaryKey = 'courier_ID'; // Primary key tetap 'id'
    protected $keyType = 'ulid'; // Laravel 12 otomatis menangani ULID
    public $incrementing = false; // Non-auto-increment karena pakai ULID

    protected $fillable = [
        'courier_name',
        'courier_NIK',
        'courier_birthplace',
        'courier_birthdate',
        'courier_telp',
        'courier_telp_darurat',
        'courier_gender',
        'courier_address',
        'courier_nama_rekening',
        'courier_no_rekening',
        'courier_img',
        'courier_docs',
    ];

    protected $dates = ['deleted_at']; // Soft delete

    protected $casts = [
        'courier_ID' => 'string', // ULID disimpan sebagai string
        'courier_birthdate' => 'date',
        'deleted_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($courier) {
            // Set semua armada yang terkait dengan courier ini menjadi NULL
            Fleet::where('courier_ID', $courier->courier_ID)->update(['courier_ID' => null]);
        });
    }

    protected static function booted()
    {
        static::deleting(function ($courier) {
            if (!$courier->isForceDeleting()) {
                // 1. Soft delete relasi assigns
                $courier->assigns()->delete();
                $courier->user()->delete();
                $courier->paxelShipments()->delete();
                $courier->paxelBills()->delete();
                $courier->pasarJayaShipments()->delete();
                $courier->pasarJayaBills()->delete();
            }
        });

        static::restoring(function ($courier) {
            // Restore relasi assigns
            $courier->assigns()->withTrashed()->restore();
            $courier->user()->delete();
            $courier->paxelShipments()->withTrashed()->restore();
            $courier->paxelBills()->withTrashed()->restore();
            // $courier->pasarJayaShipments()->withTrashed()->restore();
            // $courier->pasarJayaBills()->withTrashed()->restore();
        });
    }

    public function fleet()
    {
        return $this->hasOne(Fleet::class, 'courier_ID', 'courier_ID');
    }

    public function user()
    {
        return $this->hasOne(User::class, 'courier_ID', 'courier_ID');
    }

    public function assigns()
    {
        return $this->hasMany(Assignee::class, 'courier_ID', 'courier_ID');
    }

    public function paxelShipments()
    {
        return $this->hasMany(PaxelShipment::class, 'courier_ID', 'courier_ID');
    }

    public function paxelBills()
    {
        return $this->hasMany(PaxelBill::class, 'courier_ID', 'courier_ID');
    }

    public function pasarJayaShipments()
    {
        return $this->hasMany(PasarJayaShipment::class, 'courier_ID', 'courier_ID');
    }

    public function pasarJayaBills()
    {
        return $this->hasMany(PasarJayaBill::class, 'courier_ID', 'courier_ID');
    }
}
