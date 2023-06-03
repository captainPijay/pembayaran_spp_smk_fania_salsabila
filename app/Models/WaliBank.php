<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WaliBank extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected function namaBankFull(): Attribute
    {
        //Misal : Bank BRI - an. Zahran (1010110-0)
        return Attribute::make(
            get: fn ($value) => $this->nama_bank . ' - An. ' . $this->nama_rekening . ' (' . $this->nomor_rekening . ')', //digunakan di Pembayaran form dan tagihan controller di bagian create
        );
    }
}
