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
                                <tr>
                                    <td colspan="2" class="bg-secondary text-white fw-bold">INFORMASI TAGIHAN</td>
                                </tr>
                                <tr>
                                    <td>Nomor Tagihan</td>
                                    <td>: {{ $model->tagihan->id }}</td>
                                </tr>
                                <tr>
                                    <td>Invoice Tagihan</td>
                                    <td colspan="2">
                                        <a href="{{ route('invoice.show',$model->tagihan->id) }}" target="blank">:
                                        <i class="fa fa-file-pdf"></i> Cetak
                                    </a>
                                </td>
                                </tr>
                                <tr>
                                    <td>Total Tagihan</td>
                                    <td>: {{ formatRupiah($model->tagihan->total_tagihan) }}</td>
                                </tr>
                                @if ($model->metode_pembayaran != 'manual')
                                <tr>
                                    <td colspan="2" class="bg-secondary text-white fw-bold">INFORMASI BANK PENGIRIM</td>
                                </tr>
                                @if ($model->wali_bank_id != null)
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
                                @else
                                <tr>
                                    <td colspan="2"><h5>Anda Tidak Menyimpan Rekening Anda Ke Daftar Wali Bank Sekolah</h5></td>
                                </tr>
                                @endif
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
                                    {{-- atribut title dan url emang bawaan dari popupcenter nya --}}
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
                        @if ($model->tanggal_konfirmasi != null)
                        <div class="alert alert-primary d-flex justify-content-center" role="alert">
                            <h3>TAGIHAN INI SUDAH LUNAS</h3>
                        </div>
                        <a href="{{ route('kwitansipembayaran.show', $model->id) }}" target="blank"><i class="fa fa-file-pdf"></i> Download Kwitansi</a>
                        @else
                        {!! Form::open([
                            'route'=> ['wali.pembayaran.destroy', $model->id],
                            'method'=>'DELETE',
                            'onsubmit'=>'return confirm("Yakin Ingin Membatalkan Data Ini?")',
                            ]) !!}
                        <button type="submit" class="btn btn-danger mt-3">Batalkan Konfirmasi Pembayaran Ini</button>
                        </form>
                    {!! Form::close() !!}
                    @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
