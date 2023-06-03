@extends('layouts.app_sneat_wali')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">DATA PEMBAYARAN</h5>

                <div class="card-body">
                       <div class="table-responsive">
                        <table class="table table-light">
                            <thead>
                                <tr>
                                    <td colspan="2" class="bg-secondary text-white fw-bold">INFORMASI TAGIHAN</td>
                                </tr>
                                <tr>
                                    <td width="18%">No</td>
                                    <td>: {{ $model->id }}</td>
                                </tr>
                                <tr>
                                    <td>ID Tagihan</td>
                                    <td>: {{ $model->tagihan_id }}</td>
                                </tr>
                                <tr>
                                    <td>Item Tagihan</td>
                                    <td>:
                                        <table class="table table-sm">
                                            <thead>
                                            <th>No</th>
                                            <th>Nama Biaya</th>
                                            <th>Jumlah</th>
                                            </thead>
                                            <tbody>
                                                @foreach ($model->tagihan->tagihanDetails as $item)
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->nama_biaya }}</td>
                                                <td>{{ formatRupiah($item->jumlah_biaya) }}</td>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td>ID Tagihan</td>
                                    <td>{{ formatRupiah($model->tagihan->tagihanDetails->sum('jumlah_biaya')) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="bg-secondary text-white fw-bold">INFORMASI SISWA</td>
                                </tr>
                                <tr>
                                    <td>Nama Siswa</td>
                                    <td>: {{ $model->tagihan->siswa->nama }}</td>
                                </tr>
                                <tr>
                                    <td>Nama Wali</td>
                                    <td>: {{ $model->wali->name }}</td>
                                </tr>
                                @if ($model->metode_pembayaran != 'manual')
                                <tr>
                                    <td colspan="2" class="bg-secondary text-white fw-bold">INFORMASI BANK PENGIRIM</td>
                                </tr>
                                <tr>
                                    <td>Nama Bank Pengirim</td>
                                    <td>: {{ $model->waliBank->nama_bank }}</td>
                                </tr>
                                <tr>
                                    <td>Nomor Rekening</td>
                                    <td>: {{ $model->waliBank->nomor_rekening }}</td>
                                <tr>
                                    <td>Pemilik Rekening</td>
                                    <td>: {{ $model->waliBank->nama_rekening }}</td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="bg-secondary text-white fw-bold">INFORMASI BANK TUJUAN TRANSFER</td>
                                </tr>
                                <tr>
                                    <td>Bank Tujuan Transfer</td>
                                    <td>: {{ $model->bankSekolah->nama_bank }}</td>
                                </tr>
                                <tr>
                                    <td>Nomor Rekening</td>
                                    <td>: {{ $model->bankSekolah->nomor_rekening }}</td>
                                <tr>
                                    <td>Atas Nama</td>
                                    <td>: {{ $model->bankSekolah->nama_rekening }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <td colspan="2" class="bg-secondary text-white fw-bold">INFORMASI PEMBAYARAN</td>
                                </tr>
                                <tr>
                                    <td>Metode Pembayaran</td>
                                    <td>: {{ $model->metode_pembayaran }}</td>
                                </tr>
                                <tr>
                                    <td>Tanggal Pembayaran</td>
                                    <td>: {{ optional($model->tanggal_bayar)->translatedFormat('d F Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <td>Jumlah Total Tagihan</td>
                                    <td>: {{ formatRupiah($model->tagihan->tagihanDetails->sum('jumlah_biaya')) }}</td>
                                </tr>
                                <tr>
                                    <td>Jumlah Yang Di Bayar</td>
                                    <td>: {{ formatRupiah($model->jumlah_dibayar) }}</td>
                                </tr>
                                <tr>
                                    <td>Bukti Pembayaran</td>
                                    <td>:
                                        <a href="javascript:void[0]"
                                        onclick="popupCenter({url: '{{ Storage::url($model->bukti_bayar) }}', title: 'Bukti Pembayaran', w: 900, h: 700});  ">
                                        Lihat Bukti Bayar
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Status Konfirmasi</td>
                                    <td>: {{ $model->status_konfirmasi }}</td>
                                </tr>
                                <tr>
                                    <td>Status Pembayaran</td>
                                    <td>: {{ $model->tagihan->getStatusTagihanWali() }}</td>
                                </tr>
                                <tr>
                                    <td>Tanggal Konfirmasi</td>
                                    <td>: {{ optional($model->tanggal_konfirmasi)->translatedFormat('d F Y H:i') }}</td>
                                </tr>
                            </thead>
                        </table>
                        @if ($model->tanggal_konfirmasi == null)
                        {!! Form::open(['route'=>$route,
                        'method'=>'PUT',
                        'onsubmit'=>'return confirm("Apakah Anda Yakin?")']) !!}
                        {!! Form::hidden('pembayaran_id', $model->id, []) !!}
                        {!! Form::submit('Konfirmasi Pembayaran', ['class'=>'btn btn-primary mt-3']) !!}
                        {!! Form::close() !!}
                        @else
                        <div class="alert alert-primary" role="alert">
                            <h3>TAGIHAN INI SUDAH LUNAS</h3>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
