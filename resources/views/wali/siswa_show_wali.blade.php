@extends('layouts.app_sneat_wali')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">{{ $title }}</h5>
                <div class="card-body">
                    @if ($model->foto == true)
                    <img src="{{ Storage::url($model->foto) }}" alt="" width="180px" class="rounded mb-3">

                    @elseif($model->foto == null && $model->jenis_kelamin =='Perempuan' )
                    <img src="{{ asset('storage/images/no-image-woman.png') }}" alt="" width="180px" class="rounded mb-3">

                    @elseif($model->foto == null && $model->jenis_kelamin =='Laki-Laki' )
                    <img src="{{ asset('storage/images/no-image-man.jpg') }}" alt="" width="180px" class="rounded mb-3">

                    @endif
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <td width='15%'>STATUS SISWA</td>
                                <td>: <span class="badge {{ $model->status == 'aktif' ? 'bg-success' : 'bg-danger' }}">
                                    {{ $model->status }}
                                </span>
                                </td>
                            </tr>
                            <tr>
                                <td width='15%'>NAMA</td>
                                <td>: {{ $model->nama }}</td>
                            </tr>
                            <tr>
                                <td>NISN</td>
                                <td>: {{ $model->nisn }}</td>
                            </tr>
                            <tr>
                                <td>Jenis_kelamin</td>
                                <td>: {{ $model->jenis_kelamin }}</td>
                            </tr>
                            <tr>
                                <td>PROGRAM STUDI</td>
                                <td>: {{ $model->jurusan }}</td>
                            </tr>
                            <tr>
                                <td>ANGKATAN</td>
                                <td>: {{ $model->angkatan }}</td>
                            </tr>
                            <tr>
                                <td>TGL BUAT</td>
                                <td>: {{ $model->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            <tr>
                                <td>TGL UBAH</td>
                                <td>: {{ $model->updated_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            <tr>
                                <td>DIBUAT OLEH</td>
                                <td>: {{ $model->user->name }}</td>
                            </tr>
                        </thead>
                    </table>
                    <div class="col-md-5 mt-3">
                        <table class="table table-responsive table-bordered">
                            <thead>
                                <th>No</th>
                                <th>Nama Biaya</th>
                                <th>Jumlah Biaya</th>
                            </thead>
                            <tbody>
                                @foreach ($model->biaya->children as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td class="text-end">{{ formatRupiah($item->jumlah) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <td colspan="2">TOTAL TAGIHAN</td>
                                <td class="text-end fw-bold">{{ formatRupiah($model->biaya->children->sum('jumlah')) }}</td>
                            </tfoot>
                        </table>
                        <a href="{{ route('kartuspp.index',[
                            'siswa_id'=>$model->id,
                            'tahun'=>date('Y'),
                        ]) }}" target="blank"><i class="fa fa-file-pdf mt-2"></i>Download Kartu SPP</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
