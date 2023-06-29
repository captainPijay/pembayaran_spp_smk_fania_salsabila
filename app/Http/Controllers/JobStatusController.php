<?php

namespace App\Http\Controllers;

use Imtigger\LaravelJobStatus\JobStatus;
use Illuminate\Http\Request;
use Illuminate\Queue\Failed\FailedJobProviderInterface;


class JobStatusController extends Controller
{
    public function index(FailedJobProviderInterface $failedJobProvider)
    {
        $failedJobs = $failedJobProvider->all();
        $jobstatus = JobStatus::latest()->paginate(50);
        return view('operator.jobstatus_index', [
            'jobstatus' => $jobstatus,
            'title' => 'Job Status',
            'routePrefix' => 'jobstatus',
            'failedJobs' => $failedJobs
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
