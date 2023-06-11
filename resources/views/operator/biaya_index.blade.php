@extends('layouts.app_sneat')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">{{ $title }}</h5>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <a href="{{ route($routePrefix.'.create') }}" class="btn btn-primary btn-sm mb-3">Tambah Data</a>
                        </div>
                        {!! Form::open(['route' => $routePrefix.'.index', 'method'=>'GET']) !!}
                        <div class="input-group mb-3">
                            <div class="col-md-5">
                                <input name="search" type="text" class="form-control" placeholder="Cari Data" aria-label="Cari Nama" aria-describedby="basic-addon2" value="{{ request('search') }}">
                            </div>
                            <button class="btn btn-outline-primary" type="submit" id="button-addon2">
                                <i class="bx bx-search"></i>
                            </button>
                          </div>
                        {!! Form::close() !!}
                    </div>
                       <div class="table-responsive">
                        <table class="{{ config('app.table_style') }}">
                            <thead>
                                <tr>
                                    <th class="{{ config('app.th_style') }}">No</th>
                                    <th class="{{ config('app.th_style') }}">Nama Biaya</th>
                                    <th class="{{ config('app.th_style') }}">Jumlah</th>
                                    <th class="{{ config('app.th_style') }}">Created By</th>
                                    <th class="{{ config('app.th_style') }}">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-secondary text-white">
                                @forelse ($models as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ formatRupiah($item->total_tagihan) }}</td>
                                        <td>{{ $item->user->name }}</td>
                                        <td>
                                        {!! Form::open([
                                                'route'=> [$routePrefix.'.destroy', $item->id],
                                                'method'=>'DELETE',
                                                'onsubmit'=>'return confirm("Yakin Ingin Hapus Data Ini?")',
                                                ]) !!}

                                            <a href="{{ route($routePrefix.'.create', [
                                                'parent_id'=>$item->id
                                                ]) }}" class="btn btn-primary btn-sm mx-2"><i class="fa fa-eye"></i> Items</a>
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
