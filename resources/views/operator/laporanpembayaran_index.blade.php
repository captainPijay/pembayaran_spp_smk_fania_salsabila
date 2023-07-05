@extends('layouts.app_sneat_blank')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header"></h5>
                <div class="card-body">
                    <div class="card-body">
                    @include('operator.laporan_header')
                    <h4 class="mt-3 mb-1">LAPORAN PEMBAYARAN</h4>
                    Laporan Berdasarkan {{ $title }}
                       <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th class="text-white" width="1%">No</th>
                                    <th class="text-white">NISN</th>
                                    <th class="text-white">Nama Siswa</th>
                                    <th class="text-white">Kelas</th>
                                    <th class="text-white">Tanggal Bayar</th>
                                    <th class="text-white">Metode Bayar</th>
                                    <th class="text-white">Status</th>
                                    <th class="text-white">Status Konfirmasi</th>
                                    <th class="text-white">Tanggal Konfirmasi</th>
                                    <th class="text-white">Jumlah Dibayar</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pembayaran as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->tagihan->siswa->nisn }}</td>
                                    <td>{{ $item->tagihan->siswa->nama }}</td>
                                    <td>{{ $item->tagihan->siswa->kelas }}</td>
                                    <td>{{ $item->tanggal_bayar->translatedFormat('d-F-Y') }}</td>
                                    <td>{{ $item->metode_pembayaran }}</td>
                                    <td>{{ $item->tagihan->status }}</td>
                                    <td>{{ $item->status_konfirmasi }}</td>
                                    <td>
                                        {{ optional($item->tanggal_konfirmasi)->translatedFormat('d/m/Y') }}
                                    </td>
                                    <td>{{ formatRupiah($item->jumlah_dibayar)}}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="9" class="text-center">Data Tidak Ada</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
