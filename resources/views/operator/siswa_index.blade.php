@extends('layouts.app_sneat')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">{{ $title }}</h5>

                <div class="card-body">
                    @can('operator')
                    <div class="row">
                        <div class="col-md-6">
                            <a href="{{ route($routePrefix.'.create') }}" class="btn btn-primary btn-sm mb-3">Tambah Data</a>
                        </div>
                    </div>
                    {!! Form::open(['route' => $routePrefix.'.index', 'method'=>'GET']) !!}
                    <div class="input-group mb-3">
                        <div class="col-md-5">
                            <input name="search" type="text" class="form-control" placeholder="Cari Nama Siswa" aria-label="Cari Nama" aria-describedby="basic-addon2" value="{{ request('search') }}">
                        </div>
                        <button class="btn btn-outline-primary" type="submit" id="button-addon2">
                            <i class="bx bx-search"></i>
                        </button>
                      </div>
                    {!! Form::close() !!}
                    <form action="{{ route('siswa.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group col-md-4">
                          <div class="input-group mb-3">
                            <input type="file" name="file" class="form-control" required>
                            <button type="submit" class="btn btn-success">Excel</button>
                          </div>
                        </div>
                      </form>
                    <div class="row d-flex justify-content-end">
                        <div class="col-md-6 d-flex justify-content-end">
                            <a href="{{ route('status'.'.aktif') }}" class="btn btn-success btn-sm mb-3 ">Aktifkan Semua Siswa</a>
                            <a href="{{ route('status'.'.non-aktif') }}" class="btn btn-danger btn-sm mb-3 mx-3">Non-Aktifkan Semua Siswa</a>
                            <form action="{{ route('siswa.deleteAll') }}" method="POST">
                            @csrf
                            @method('delete')
                            <button class="btn btn-dark btn-sm mb-3" type="submit" onclick="return confirm('Ingin Menghapus Semua Data Siswa?')">HAPUS SEMUA DATA SISWA</button>
                            </form>
                        </div>
                    </div>
                    @endcan
                       <div class="table-responsive">
                        <table class="{{ config('app.table_style') }}">
                            <thead>
                                <tr>
                                    <th class="{{ config('app.th_style') }}" width="1%">No</th>
                                    <th class="{{ config('app.th_style') }}">Wali Murid</th>
                                    <th class="{{ config('app.th_style') }}">Nama Murid</th>
                                    <th class="{{ config('app.th_style') }}">NISN</th>
                                    <th class="{{ config('app.th_style') }}">Jurusan</th>
                                    <th class="{{ config('app.th_style') }}">Angkatan</th>
                                    <th class="{{ config('app.th_style') }}">Kelas</th>
                                    <th class="{{ config('app.th_style') }}">Biaya SPP</th>
                                    <th class="{{ config('app.th_style') }}">Status</th>
                                    <th class="{{ config('app.th_style') }}" width="100%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-secondary text-white">
                                @forelse ($models as $item)
                                    <tr class="mt-2">
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->wali->name ?? 'Belum Ada' }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->nisn }}</td>
                                        <td>{{ $item->jurusan }}</td>
                                        <td>{{ $item->angkatan }}</td>
                                        <td>{{ $item->kelas }}</td>
                                        <td>{{ formatRupiah($item->biaya?->children->sum('jumlah')) }}</td>
                                        <div class="d-flex align-items-center justify-content-center">
                                            <td  class="btn {{ $item->status == 'aktif' ? 'bg-success' : 'bg-danger' }} text-white font-weight-bold d-flex justify-content-center text-center mt-2 btn-sm mx-1">{{ $item->status }}</td>
                                        </div>
                                        <td>
                                        {!! Form::open([
                                                'route'=> [$routePrefix.'.destroy', $item->id],
                                                'method'=>'DELETE',
                                                'onsubmit'=>'return confirm("Yakin Ingin Hapus Data Ini?")',
                                                ]) !!}

                                            <a href="{{ route($routePrefix.'.show', $item->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> Detail</a>
                                            <a href="{{ route($routePrefix.'.edit', $item->id) }}" class="btn btn-warning btn-sm my-2 mx-2"><i class="fa fa-edit"></i> Edit</a>
                                            {{-- {!! Form::submit('Hapus', ['class'=>'btn btn-danger btn-sm']) !!} --}}
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fa fa-trash"></i> Hapus
                                            </button>
                                        {!! Form::close() !!}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4">Data Tidak Ada</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="mt-3">
                            {!! $models->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
