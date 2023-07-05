<?php

namespace App\Models;

use Auth;
use Request;
use Spatie\ModelStatus\HasStatuses;
use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Siswa extends Model
{
    use HasFactory;
    use SearchableTrait;
    use HasStatuses;
    protected $guarded = ['id'];
    protected $searchable = [
        'columns' => [
            'nama' => 255,
            'nisn' => 20,
            'angkatan' => 4,
            'kelas' => 2,
            'jurusan' => 50,
        ],
    ];

    /**
     * Get the user that owns the Siswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    /**
     * Get the user that owns the Siswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function wali()
    {
        return $this->belongsTo(User::class, 'wali_id');
    }
    public function scopeSiswaPrevent($siswa)
    {
        return $siswa->where('wali_id', Auth::user()->id)->findOrFail(Request::segment(3));
        // ambil satu siswa dimana wali_id = user id yang login lalu temukan satu data siswa dengan findorfail, request::segment(3) merupakan method yang memungkinkan kita mengambil url di / ke 3 (localhost:8000 tidak di hitung)
    }
    /**
     * Get all of the biaya for the Siswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function biaya(): BelongsTo
    {
        return $this->belongsTo(Biaya::class);
    }
    /**
     * Get all of the tagihan for the Siswa
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function tagihan(): HasMany
    {
        return $this->hasMany(Tagihan::class);
    }
    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        static::creating(function ($siswa) {
            $siswa->user_id = auth()->user()->id;
        });
        static::created(function ($siswa) {
            $siswa->setStatus('aktif');
        });

        static::updating(function ($siswa) {
            $siswa->user_id = auth()->user()->id;
        });
    }
}
