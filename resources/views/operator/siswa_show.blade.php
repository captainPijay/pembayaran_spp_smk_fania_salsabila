@extends('layouts.app_sneat')

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
                    {{-- <h6 class="mt-3">TAGIHAN SPP</h6>
                    <div class="row">
                        <div class="col-md-5">
                            <table class="table table-bordered table-sm">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Item Tagihan</th>
                                        <th>Jumlah Tagihan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($model->biaya->children as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->nama }}</td>
                                            <td>{{ formatRupiah($item->jumlah) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
