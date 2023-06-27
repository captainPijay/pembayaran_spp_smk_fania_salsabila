@extends('layouts.app_sneat_blank')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header"></h5>
                <div class="card-body">
                    <div class="row">
                            <table>
                                <tr>
                                    <td width="85">
                                        @if (request('output') == 'pdf')
                                            <img src="{{ public_path() . '/storage/images/fania.png' }}" alt="" width="110">
                                        @else
                                        <img src="{{ asset('storage/images/fania.png') }}" alt="" width="110">
                                        @endif
                                    </td>
                                    <td style="text-align:left; vertical-align: middle">
                                        <div style="font-size: 20px; font-weight:bold; margin-left:10px;">{{ settings()->get('app_name','My App') }}</div>
                                        <div style="margin-left:10px;">{{ settings()->get('app_address') }}</div>
                                    </td>
                                </tr>
                                <tr align="bottom">
                                    <td></td>
                                    <td></td>
                                    <td class="text-end" align="bottom">
                                        <span class="mx-3">
                                            Email : {{ settings()->get('app_email') }}
                                        </span>
                                        <span>
                                            Telp : {{ settings()->get('app_phone') }}
                                        </span>
                                        &nbsp;&nbsp;&nbsp;
                                    </td>
                                </tr>
                            </table>
                    </div>
                    <hr class="p-0 m-0">
                    <div class="card-body">
                    <h4>LAPORAN TAGIHAN</h4>
                    Laporan Berdasarkan {{ $title }}
                       <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-dark">
                                <tr>
                                    <th class="text-white" width="1%">No</th>
                                    <th class="text-white">NISN</th>
                                    <th class="text-white">Nama Siswa</th>
                                    <th class="text-white">Kelas</th>
                                    <th class="text-white">Tanggal Tagihan</th>
                                    <th class="text-white">Status</th>
                                    <th class="text-white">Total Tagihan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($tagihan as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->siswa->nisn }}</td>
                                    <td>{{ $item->siswa->nama }}</td>
                                    <td>{{ $item->siswa->kelas }}</td>
                                    <td>{{ $item->tanggal_tagihan->translatedFormat('d-F-Y') }}</td>
                                    <td>{{ $item->status }}</td>
                                    <td>{{ formatRupiah($item->tagihanDetails->sum('jumlah_biaya'))}}</td>
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
