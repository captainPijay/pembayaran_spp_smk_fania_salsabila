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
        return $this->belongsTo(User::class, 'wali_id')->withDefault([
            'name' => 'Belum Ada Wali Murid'
        ]);
    }
    public function scopeSiswaPrevent($siswa)
    {
        return $siswa->where('wali_id', Auth::user()->id)->findOrFail(Request::segment(3));
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
}
