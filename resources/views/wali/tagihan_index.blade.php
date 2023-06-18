@extends('layouts.app_sneat_wali')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">DATA TAGIHAN SPP</h5>

                <div class="card-body">
                       <div class="table-responsive">
                        <table class="table table-stripped bg-dark">
                            <thead>
                                <tr>
                                    <th class="text-warning">No</th>
                                    <th class="text-warning">Nama </th>
                                    <th class="text-warning">Jurusan</th>
                                    <th class="text-warning">Kelas</th>
                                    <th class="text-warning">Tanggal Tagihan</th>
                                    <th class="text-warning">Status Pembayaran</th>
                                    <th class="text-warning">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-secondary text-white">
                                @forelse ($tagihan as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->siswa->nama }}</td>
                                        <td>{{ $item->siswa->jurusan }}</td>
                                        <td>{{ $item->siswa->kelas }}</td>
                                        <td>{{ $item->tanggal_tagihan->translatedFormat('F Y') }}</td>
                                        <td>
                                            @if ($item->pembayaran->count() >=1 )
                                            <a href="{{ route('wali.pembayaran.show',$item->pembayaran->first()->id) }}" class="btn {{ ($item->pembayaran != null && $item->status == 'baru') ? "btn-warning" : "btn-success" }} btn-sm">
                                                @if ($item->pembayaran != null && $item->status == 'baru')
                                                Belum DiKonfirmasi
                                                @else
                                                {{ $item->getStatusTagihanWali() }}
                                            @endif</a>
                                    @else
                                    {{ $item->getStatusTagihanWali() }}
                                    @endif
                                </td>
                                        <td>
                                            @if ($item->status == 'baru' || $item->status == 'angsur')
                                            <a href="{{ route('wali.tagihan.show', $item->id) }}" class="btn btn-primary btn-sm">Lakukan Pembayaran</a>
                                            @else
                                            <a href="" class="btn btn-success">Pembayaran Sudah Lunas</a>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4">Data Tidak Ada</td>
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
