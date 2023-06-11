<?php

namespace App\Models;

use App\Traits\HasFormatRupiah;
use Auth;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tagihan extends Model
{
    use HasFactory;
    use HasFormatRupiah;
    protected $guarded = ['id'];
    protected $dates = ['tanggal_tagihan', 'tanggal_jatuh_tempo'];
    protected $with = ['user', 'siswa', 'tagihanDetails'];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class)->withDefault("Data Kosong");
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    /**
     * Get all of the tagihansDetail for the Tagihan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tagihanDetails(): HasMany
    {
        return $this->hasMany(TagihanDetail::class);
    }
    /**
     * Get all of the comments for the Tagihan
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function pembayaran(): HasMany
    {
        return $this->hasMany(Pembayaran::class);
    }
    public function getStatusTagihanWali()
    {
        if ($this->status == 'baru') {
            return 'Belum Dibayar';
        }
        if ($this->status == 'lunas') {
            return 'Sudah Dibayar';
        }
        return $this->status;
    }

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::creating(function ($tagihan) {
            $tagihan->user_id = auth()->user()->id;
        });

        static::updating(function ($tagihan) {
            $tagihan->user_id = auth()->user()->id;
        });
    }
    public function scopeWaliSiswa($tagihan)
    {
        return $tagihan->whereIn('siswa_id', Auth::user()->getAllSiswaId()); //model tagihan dimana siswa_id = wali yang login, lalu getAllSiswaId di model user $this->siswa->pluck('id')->toArray() artinya user yang login dan memiliki relasi ke siswa pilih masing masing id siswa nya yang memiliki wali_id = wali yang login. contoh kevin id = 1 di wali dan mancek memiliki wali_id =1 sebagai siswa singkatnya model tagihan dimana siswa_id = siswa yang memiliki wali_id sama dengan wali yang sedang login
    }
}
