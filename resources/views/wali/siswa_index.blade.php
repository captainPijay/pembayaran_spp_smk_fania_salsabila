@extends('layouts.app_sneat_wali')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">DATA SISWA</h5>

                <div class="card-body">
                       <div class="table-responsive">
                        <table class="table table-stripped bg-dark table-bordered">
                            <thead>
                                <tr>
                                    <th class="text-warning" width="1%">No</th>
                                    <th class="text-warning">Nama Siswa</th>
                                    <th class="text-warning">NISN</th>
                                    <th class="text-warning">Jurusan</th>
                                    <th class="text-warning">Kelas</th>
                                    <th class="text-warning">Angkatan</th>
                                    <th class="text-warning">Biaya Sekolah</th>
                                </tr>
                            </thead>
                            <tbody class="bg-secondary text-white">
                                @forelse ($models as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->nisn }}</td>
                                        <td>{{ $item->jurusan }}</td>
                                        <td>{{ $item->kelas }}</td>
                                        <td>{{ $item->angkatan }}</td>
                                        <td class="text-end">
                                            <a href="{{ route('wali.siswa.show',$item->id) }}">
                                                {{ formatRupiah($item->biaya->children->sum('jumlah')) }}
                                                <i class="fa fa-arrow-right"></i>
                                            </a>
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
