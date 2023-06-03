@extends('layouts.app_sneat_wali')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">DATA SISWA</h5>

                <div class="card-body">
                    <a href="" class="btn btn-primary btn-sm mb-3">Tambah Data</a>
                       <div class="table-responsive">
                        <table class="table table-stripped bg-dark">
                            <thead>
                                <tr>
                                    <th class="text-warning">No</th>
                                    <th class="text-warning">Nama Wali Murid</th>
                                    <th class="text-warning">Nama Murid</th>
                                    <th class="text-warning">NISN</th>
                                    <th class="text-warning">Jurusan</th>
                                    <th class="text-warning">Kelas</th>
                                    <th class="text-warning">Angkatan</th>
                                    <th class="text-warning">Created By</th>
                                    <th class="text-warning">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-secondary text-white">
                                @forelse ($models as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->wali->name }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->nisn }}</td>
                                        <td>{{ $item->jurusan }}</td>
                                        <td>{{ $item->kelas }}</td>
                                        <td>{{ $item->angkatan }}</td>
                                        <td>{{ $item->user->name }}</td>
                                        <td><a href="{{ route('wali.siswa.show',$item->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> Detail Siswa</a>
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
