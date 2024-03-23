  @extends('layouts.app_sneat')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">{{ $title }}</h5>

                <div class="card-body">
                    @can('operator')
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
                    <form action="{{ route('wali.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group col-md-4">
                          <div class="input-group mb-3">
                            <input type="file" name="file" class="form-control" required>
                            <button type="submit" class="btn btn-success">Excel</button>
                          </div>
                        </div>
                      </form>
                      <div class="col d-flex justify-content-end">
                        <div class="col-md-6 d-flex justify-content-end">
                            <form action="{{ route('walisiswa.deleteAll') }}" method="POST">
                                @csrf
                                @method('delete')
                                <button class="btn btn-dark btn-sm mb-2" type="submit" onclick="return confirm('Ingin Menghapus Semua Data Wali-Murid?')">HAPUS SEMUA DATA WALI</button>
                            </form>

                        </div>
                    </div>
                    @endcan
                       <div class="table-responsive">
                        <table class="{{ config('app.table_style') }}">
                            <thead>
                                <tr>
                                    <th class="{{ config('app.th_style') }}">No</th>
                                    <th class="{{ config('app.th_style') }}">Nama</th>
                                    <th class="{{ config('app.th_style') }}">No HP</th>
                                    <th class="{{ config('app.th_style') }}">Email</th>
                                    <th class="{{ config('app.th_style') }}">Akses</th>
                                    <th class="{{ config('app.th_style') }}">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-secondary text-white">
                                @forelse ($models as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->name }}</td>
                                        <td>{{ $item->nohp }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>{{ $item->akses }}</td>
                                        <td>
                                        {!! Form::open([
                                                'route'=> [$routePrefix.'.destroy', $item->id],
                                                'method'=>'DELETE',
                                                'onsubmit'=>'Yakin Ingin Hapus Data Ini? Jika Menghapus Data User Di Sini Maka Data Untuk Tagihan Dan Pembayarannya Pun Akan Ikut Terhapus, Sebaiknya Hapus Data Saat Tahun Ajaran Baru.',
                                                ]) !!}

                                            <a href="{{ route($routePrefix.'.show', $item->id) }}" class="btn btn-primary btn-sm"><i class="fa fa-eye"></i> Detail</a>
                                            <a href="{{ route($routePrefix.'.edit', $item->id) }}" class="btn btn-warning btn-sm mx-2"><i class="fa fa-edit"></i> Edit</a>
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
