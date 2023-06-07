@extends('layouts.app_sneat')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">{{ $title }}</h5>

                <div class="card-body">
                    <a href="{{ route($routePrefix.'.create') }}" class="btn btn-primary btn-sm mb-3">Tambah Data</a>
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
                                    <th class="text-warning">Biaya SPP</th>
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
                                        <td>{{ formatRupiah($item->biaya?->first()->total_tagihan) }}</td>
                                        <td>
                                        {!! Form::open([
                                                'route'=> [$routePrefix.'.destroy', $item->id],
                                                'method'=>'DELETE',
                                                'onsubmit'=>'return confirm("Yakin Ingin Hapus Data Ini?")',
                                                ]) !!}

                                            <a href="{{ route($routePrefix.'.show', $item->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> Detail</a>
                                            <a href="{{ route($routePrefix.'.edit', $item->id) }}" class="btn btn-warning btn-sm mx-2 my-2"><i class="fa fa-edit"></i> Edit</a>
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
                        {!! $models->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
