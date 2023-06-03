<?php

namespace App\Traits;


trait HasFormatRupiah
{
    function formatRupiah($field, $prefix = null)
    {
        $prefix = $prefix ? $prefix : 'Rp. ';
        $nominal = $this->attributes[$field]; //attributes memang bawaan dari php attributes return objek
        // dd($this->attributes);
        return $prefix . number_format($nominal, 0, ',', '.');
    }
}
