<?php

namespace App\Http\Controllers;

use App\Jobs\SpamWhatsapp;
use Illuminate\Http\Request;

class SpamController extends Controller
{
    public function store(Request $request)
    {
        // Menggabungkan data dengan 'user_id' untuk keperluan job
        $requestData = array_merge($request->all(), ['user_id' => auth()->user()->id]);

        // Membuat dan memproses job untuk mengirim WhatsApp
        $processTagihan = new SpamWhatsapp($requestData);
        $this->dispatch($processTagihan);

        // Redirect ke halaman status job
        return redirect()->route('jobstatus.index', ['job_status_id' => $processTagihan->getJobStatusId()]);
    }
}
