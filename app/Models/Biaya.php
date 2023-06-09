<?php

namespace App\Models;

use App\Traits\HasFormatRupiah;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Biaya extends Model
{
    use HasFactory;
    use HasFormatRupiah;
    use SearchableTrait;
    protected $guarded = ['id'];
    protected $append = ['nama_biaya_full', 'total_tagihan']; //ini untuk membuat api
    protected $searchable = [
        'columns' => [
            'nama' => 255,
            'jumlah' => 30,
        ],
    ];
    protected function totalTagihan(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->children()->sum('jumlah') //digunakan di tagihan index dan tagihan controller di bagian create tetapi harus menggunakan method get dulu agar menjadi collection
        );
    }
    /**
     * Get all of the children for the Biaya
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children(): HasMany
    {
        return $this->hasMany(Biaya::class, 'parent_id');
    }
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
     * Get all of the siswa for the Biaya
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function siswa(): HasMany
    {
        return $this->hasMany(Siswa::class);
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
