<?php

namespace App\Jobs;

use Carbon\Carbon;
use App\Models\Siswa;
use App\Models\Tagihan;
use App\Models\TagihanDetail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Imtigger\LaravelJobStatus\Trackable;
use App\Notifications\TagihanNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Notification;

class ProcessTagihan implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, Trackable;

    private $requestData;

    /**
     * Create a new job instance.
     *
     * @param  array  $requestData
     * @return void
     */
    public function __construct($requestData)
    {
        $this->requestData = $requestData;
        $this->prepareStatus();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $requestData = $this->requestData;
        $requestData['status'] = 'baru';
        $tanggalTagihan = Carbon::parse($requestData['tanggal_tagihan']);
        $bulanTagihan = $tanggalTagihan->format('m');
        $tahunTagihan = $tanggalTagihan->format('Y');
        //ambil semua data siswa dengan status aktif
        $siswa = Siswa::with('biaya', 'tagihan')->currentStatus('aktif')->get();
        $this->setProgressMax($siswa->count());
        $i = 1;

        // if ($requestData['kelas'] != '') {
        //     $siswa->where('kelas', $requestData['kelas']);
        // }
        // if ($requestData['angkatan'] != '') {
        //     $siswa->where('angkatan', $requestData['angkatan']);
        // }
        foreach ($siswa as $itemSiswa) {
            $this->setProgressNow($i);
            $i++;
            $requestData = $this->requestData;
            $requestData['siswa_id'] = $itemSiswa->id;
            $cekTagihan = $itemSiswa->tagihan->filter(function ($value) use ($bulanTagihan, $tahunTagihan) {
                return $value->tanggal_tagihan->year == $tahunTagihan && $value->tanggal_tagihan->month == $bulanTagihan;
            })->first();
            // ->whereMonth('tanggal_tagihan', $bulanTagihan)
            // ->whereYear('tanggal_tagihan', $tahunTagihan)
            // ->first();
            if ($cekTagihan == null) {
                $tagihan = Tagihan::create($requestData);
                if ($tagihan->siswa->wali != null) {
                    Notification::send($tagihan->siswa->wali, new TagihanNotification($tagihan));
                }
                $biaya = $itemSiswa->biaya->children;
                foreach ($biaya as $itemBiaya) {
                    TagihanDetail::create([
                        'tagihan_id' => $tagihan->id,
                        'nama_biaya' => $itemBiaya->nama,
                        'jumlah_biaya' => $itemBiaya->jumlah,
                    ]);
                }
            }
            sleep(1);
        }
        $this->setOutput(['message' => 'Tagihan Bulan ' . ubahNamaBulan($bulanTagihan) . ' ' . $tahunTagihan]);
    }
}
