<?php

namespace App\Models;

use App\Traits\HasFormatRupiah;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Biaya extends Model
{
    use HasFactory;
    use HasFormatRupiah;
    use SearchableTrait;
    protected $guarded = ['id'];
    protected $append = ['nama_biaya_full']; //ini untuk membuat api
    protected $searchable = [
        'columns' => [
            'nama' => 255,
            'jumlah' => 30,
        ],
    ];
    /**
     * Interact with the user's first name.
     */
    protected function namaBiayaFull(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->nama . ' - ' . $this->formatRupiah('jumlah') //digunakan di tagihan index dan tagihan controller di bagian create tetapi harus menggunakan method get dulu agar menjadi collection
        );
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::creating(function ($biaya) {
            $biaya->user_id = auth()->user()->id;
        });

        static::updating(function ($biaya) {
            $biaya->user_id = auth()->user()->id;
        });
    }
}
