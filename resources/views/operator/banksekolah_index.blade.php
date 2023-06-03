@extends('layouts.app_sneat')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">{{ $title }}</h5>

                <div class="card-body">
                    <a href="{{ route($routePrefix.'.create') }}" class="btn btn-primary btn-sm mb-3">Tambah Data</a>
                       <div class="table-responsive">
                        <table class="table table-stripped bg-dark">
                            <thead>
                                <tr>
                                    <th class="text-warning">No</th>
                                    <th class="text-warning">Nama Bank</th>
                                    <th class="text-warning">Kode Transfer</th>
                                    <th class="text-warning">Pemilik Rekening</th>
                                    <th class="text-warning">Nomor Rekening</th>
                                    <th class="text-warning">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-secondary text-white">
                                @forelse ($models as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->nama_bank }}</td>
                                        <td>{{ $item->kode }}</td>
                                        <td>{{ $item->nama_rekening }}</td>
                                        <td>{{ $item->nomor_rekening }}</td>
                                        <td>
                                        {!! Form::open([
                                                'route'=> [$routePrefix.'.destroy', $item->id],
                                                'method'=>'DELETE',
                                                'onsubmit'=>'return confirm("Yakin Ingin Hapus Data Ini?")',
                                                ]) !!}
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
