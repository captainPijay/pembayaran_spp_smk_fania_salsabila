<?php

namespace App\Jobs;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Siswa;
use App\Models\Tagihan;
use App\Models\TagihanDetail;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Imtigger\LaravelJobStatus\Trackable;
use App\Notifications\TagihanNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Notification;

class SpamWhatsapp implements ShouldQueue
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
        Log::info("Memulai proses SpamWhatsapp", ['requestData' => $this->requestData]);
        $walis = User::where('akses', 'wali')->get();
        foreach ($walis as $wali) {
            Notification::send($wali, new TagihanNotification($walis));
        }
        $this->setOutput(['message' => 'Tagihan Bulan ']);
    }
}
