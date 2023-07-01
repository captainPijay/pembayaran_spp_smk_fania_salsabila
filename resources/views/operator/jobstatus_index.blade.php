@extends('layouts.app_sneat')
@section('js')
    <script>
        $(document).ready(function () {
    $.ajaxSetup({
        timeout: 60000, // Timeout dalam milidetik (60 detik)
    });

    var bar = document.querySelector(".progress-bar");
    var intervalId = window.setInterval(function () {
        @if (request('job_status_id') != '')
        $.getJSON("{{ route('jobstatus.show',request('job_status_id')) }}",
            function (data, textStatus, jqXHR) {
                var progressPercent = data['progress_percentage'];
                var progressNow = data['progress_now'];
                var progressMax = data['progress_max'];
                var isEnded = data['is_ended'];
                var id = data['id'];
                bar.style.width = progressPercent + "%";
                bar.innerText = progressPercent + "%";
                $("#progress-now" + id).text(progressNow);
                $("#progress-max" + id).text(progressMax);
                if (isEnded) {
                    window.location.href = "{{ route('jobstatus.index') }}";
                }
            });
        @endif
    }, 1000);
});

    </script>
@endsection
@section('content')
<style>
    .progress-bar{
        font-size: 12px;
    }
</style>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">{{ $title }}</h5>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="{{ route('tagihan'.'.create') }}" class="btn btn-primary btn-sm mb-3">Tambah Data</a>
                        </div>
                        {!! Form::open(['route' => $routePrefix.'.index', 'method'=>'GET']) !!}
                        <div class="input-group mb-3">
                            <div class="col-md-5">
                                <input name="search" type="text" class="form-control" placeholder="Cari Data" aria-label="Cari Nama" aria-describedby="basic-addon2" value="{{ request('search') }}">
                            </div>
                            <button class="btn btn-outline-primary" type="submit" id="button-addon2">
                                <i class="bx bx-search"></i>
                            </button>
                          </div>
                        {!! Form::close() !!}
                    </div>
                    @if (request('job_status_id') != '')
                    <div class="progress mb-3" style="height: 20px;">
                        <div class="progress-bar" role="progressbar" aria-label="Example with labels" style="width: 25%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                      </div>
                    @endif
                       <div class="table-responsive">
                        <table class="{{ config('app.table_style') }}">
                            <thead>
                                <tr>
                                    <th class="{{ config('app.th_style') }}">No</th>
                                    <th class="{{ config('app.th_style') }}">Modul Job</th>
                                    <th class="{{ config('app.th_style') }}">Progress</th>
                                    <th class="{{ config('app.th_style') }}">Status</th>
                                    <th class="{{ config('app.th_style') }}">Created At</th>
                                    <th class="{{ config('app.th_style') }}">Description</th>
                                </tr>
                            </thead>
                            <tbody class="bg-secondary text-white">
                                @forelse ($jobstatus as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>
                                            @if ($item->status =='finished')
                                                {{ getClassName($item->type) }}
                                            @else
                                            <a href="{{ route('jobstatus.index',['job_status_id'=>$item->id]) }}">
                                            {{ $item->type }}
                                            </a>
                                            @endif
                                        </td>
                                        <td>
                                            <span id="progress-now{{ $item->id }}">{{ $item->progress_now }}
                                            </span> /
                                            <span id="progress-max{{ $item->id }}">{{ $item->progress_max }}
                                            </span>
                                        <td>
                                            <span class="badge bg-{{ $item->status == 'finished' ?'success' : 'info' }}">
                                                {{ $item->status }}
                                            </span>
                                        </td>
                                        <td>{{ $item->created_at->format('d-M-Y H:i:s') }}</td>
                                        <td>{{ json_encode($item->output) }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7">Data Tidak Ada</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {!! $jobstatus->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
