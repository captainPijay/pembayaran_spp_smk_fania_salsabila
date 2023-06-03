<?php

namespace App\Models;

use App\Traits\HasFormatRupiah;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TagihanDetail extends Model
{
    use HasFactory;
    use HasFormatRupiah;
    protected $guarded = ['id'];

    /**
     * Get the tagihan that owns the TagihanDetail
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function tagihan(): BelongsTo
    {
        return $this->belongsTo(Tagihan::class,);
    }
}
