<?php

namespace App\Http\Controllers;

use Imtigger\LaravelJobStatus\JobStatus;
use Illuminate\Http\Request;

class JobStatusController extends Controller
{
    public function index()
    {
        $jobstatus = JobStatus::latest()->paginate(settings()->get('app_pagination', '50'));
        return view('operator.jobstatus_index', [
            'jobstatus' => $jobstatus,
            'title' => 'Job Status',
            'routePrefix' => 'jobstatus'
        ]);
    }
    public function show($id)
    {
        $job = JobStatus::findOrFail($id);
        $data = [
            'id' => $job->id,
            'progress_now' => $job->progress_now,
            'progress_max' => $job->progress_max,
            'is_ended' => $job->is_ended,
            'progress_percentage' => $job->progress_percentage
        ];
        return response()->json($data, 200);
    }
}
