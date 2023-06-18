@extends('layouts.app_sneat_wali')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">TAGIHAN SPP {{ strtoupper($siswa->nama) }}</h5>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <table class="table table-sm table-borderless">
                                <tr>
                                    @if ($siswa->foto == true)
                                    <td rowspan="8" width="100">
                                        <img src="{{ Storage::url($siswa->foto) }}" alt="" width="180px" class="rounded mb-3" class="align-top">
                                    </td>

                                    @elseif($siswa->foto == null && $siswa->jenis_kelamin =='Perempuan' )
                                    <td rowspan="8" width="100" class="align-top">
                                    <img src="{{ asset('storage/images/no-image-woman.png') }}" alt="" width="180px" class="rounded mb-3">
                                    </td>
                                    @elseif($siswa->foto == null && $siswa->jenis_kelamin =='Laki-Laki' )
                                    <td rowspan="8" width="100" class="align-top">
                                        <img src="{{ asset('storage/images/no-image-man.jpg') }}" alt="" width="180px" class="rounded mb-3">
                                    </td>
                                </tr>
                                    @endif
                                        <tr>
                                            <td width="50">NISN</td>
                                            <td>: {{ $siswa->nisn }}</td>
                                        </tr>
                                        <tr>
                                            <td>Nama</td>
                                            <td>: {{ $siswa->nama }}</td>
                                        </tr>
                                        <tr>
                                            <td>Jurusan</td>
                                            <td>: {{ $siswa->jurusan }}</td>
                                        </tr>
                                        <tr>
                                            <td>Angkatan</td>
                                            <td>: {{ $siswa->angkatan }}</td>
                                        </tr>
                                        <tr>
                                            <td>Kelas</td>
                                            <td>: {{ $siswa->kelas }}</td>
                                        </tr>
                                    </table>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <h5>SMK FANIA SALSABILA</h5>
                            <table class="">
                                <tr>
                                    <td>No. Tagihan</td>
                                    <td>: #SFS-{{ $tagihan->id }}</td>
                                </tr>
                                <tr>
                                    <td>Tanggal Tagihan</td>
                                    <td>: {{ $tagihan->tanggal_tagihan->format('d F Y') }}</td>
                                </tr>
                                <tr>
                                    <td>Tanggal Jatuh Tempo</td>
                                    <td>: {{ $tagihan->tanggal_jatuh_tempo->format('d F Y') }}</td>
                                </tr>
                                <tr>
                                    <td>Status Pembayaran</td>
                                    <td>: {{ $tagihan->getStatusTagihanWali() }}</td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <a href="" target="blank">
                                        <i class="fa fa-file-pdf"></i> Cetak Invoice Tagihan
                                    </a>
                                </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <table class="table table-sm table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <td width="1%">No</td>
                                <td>Nama Tagihan</td>
                                <td class="text-end">Jumlah Tagihan</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tagihan->tagihanDetails as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->nama_biaya }}</td>
                                    <td class="text-end">{{ formatRupiah($item->jumlah_biaya) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2" class="text-center fw-bold">Total Pembayaran</td>
                                <td class="text-end fw-bold">{{ formatRupiah($tagihan->tagihanDetails->sum('jumlah_biaya')) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                    <div class="alert alert-secondary" role="alert" style="color:black">
                        Pembayaran Bisa DI lakukan Dengan Cara Langsung Ke Operator Sekolah Atau Di transfer Melalui Rekening Milik Sekolah Dibawah Ini. <br>
                        <u><i>Jangan Melakukan Transfer Ke Rekening Selain Dari Rekening Dibawah Ini.</i></u>
                        <br>
                        Silahkan Lihat Tata Cara Melakukan Pembayaran Melalui <a href="{{ route('panduan.pembayaran','atm') }}" target="blank">ATM</a> Atau <a href="{{ route('panduan.pembayaran','internet-banking') }}" target="blank">Internet Banking</a>.
                        <br>
                        Setelah Melakukan Pembayaran, Silahkan Upload Bukti Pembayaran Melalui Tombol Konfirmasi Yang Ada Di Bawah Ini
                    </div>
                   <ul>
                    <li> <a href="{{ route('panduan.pembayaran','atm') }}" target="blank">Lihat Cara Melakukan Pembayaran Dengan Transfer Melalui ATM</a></li>
                    <li> <a href="{{ route('panduan.pembayaran','internet-banking') }}" target="blank">Lihat Cara Melakukan Pembayaran Dengan Transfer Melalui Internet Banking</a></li>
                   </ul>
                <div class="row">
                    @foreach ($bankSekolah as $itemBank)
                    <div class="col-md-6">
                        <div class="alert alert-dark" role="alert">
                            <table width="100%">
                                <tbody>
                                    <tr>
                                        <td width="30%">Bank Tujuan</td>
                                        <td>: {{ $itemBank->nama_bank }}</td>
                                    </tr>
                                    <tr>
                                        <td>Nomor Rekening</td>
                                        <td>: {{ $itemBank->nomor_rekening }}</td>
                                    </tr>
                                    <tr>
                                        <td>Atas Nama</td>
                                        <td>: {{ $itemBank->nama_rekening }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <a href="{{ route('wali.pembayaran.create',[
                                'tagihan_id'=>$tagihan->id,
                                'bank_sekolah_id'=>$itemBank->id
                            ]) }}" class="btn btn-primary btn-sm mt-3">Konfirmasi Pembayaran</a>
                        </div>
                    </div>
                    @endforeach
                </div>
                </div>
            </div>
        </div>
    </div>
@endsection
