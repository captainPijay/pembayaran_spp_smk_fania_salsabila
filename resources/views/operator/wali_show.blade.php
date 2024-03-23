@extends('layouts.app_sneat')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">{{ $title }}</h5>
                <div class="card-body">
                    @if ($model->foto == !null)
                    <img src="{{ Storage::url($model->foto) }}" alt="" width="180px" class="rounded mb-3">

                    @elseif($model->foto == null && $model->jenis_kelamin =='Perempuan' )
                    <img src="{{ asset('storage/images/no-image-woman.png') }}" alt="" width="180px" class="rounded mb-3">

                    @elseif($model->foto == null && $model->jenis_kelamin =='Laki-Laki' )
                    <img src="{{ asset('storage/images/no-image-man.jpg') }}" alt="" width="180px" class="rounded mb-3">

                    @endif
                    <table class="table table-striped table-sm">
                        <thead>
                            <tr>
                                <td width='15%'>ID</td>
                                <td>: {{ $model->id }}</td>
                            </tr>
                            <tr>
                                <td>NAMA</td>
                                <td>: {{ $model->name }}</td>
                            </tr>
                            <tr>
                                <td>No HP</td>
                                <td>: {{ $model->nohp }}</td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td>: {{ $model->email }}</td>
                            </tr>
                            <tr>
                                <td>SEBAGAI</td>
                                <td>: {{ $model->akses.' murid' }}</td>
                            </tr>
                            <tr>
                                <td>TGL BUAT</td>
                                <td>: {{ $model->created_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            <tr>
                                <td>TGL UBAH</td>
                                <td>: {{ $model->updated_at->format('d/m/Y H:i') }}</td>
                            </tr>
                            <tr>
                                <td>DIBUAT OLEH</td>
                                <td>: {{ auth()->user()->name }}</td>
                            </tr>
                        </thead>
                    </table>
                    <h4 class="mt-3 mb-3">TAMBAH DATA ANAK</h4>
                    {!! Form::open(['route'=>'walisiswa.store','method'=>'POST']) !!}
                    {!! Form::hidden('wali_id', $model->id, []) !!}
                    <div class="form-group">
                        <label for="siswa_id">Pilih Data Siswa</label>
                        {!! Form::select('siswa_id', $siswa, null, ['class'=>'form-control select2']) !!}
                        <span class="text-danger">{{ $errors->first("siswa_id") }}</span>
                    </div>
                    {!! Form::submit('SIMPAN', ['class'=>'btn btn-primary my-3']) !!}
                    {!! Form::close() !!}
                    <h4 class="mt-3 mb-3">DATA ANAK</h4>  
                    <table class="table table-bordered">
                        <thead class="bg-dark">
                            <tr>
                                <th class="text-warning">No</th>
                                <th class="text-warning">NISN</th>
                                <th class="text-warning">Nama</th>
                                <th class="text-warning">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-secondary text-white">
                        @foreach ($model->siswa as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nisn }}</td>
                                <td>{{ $item->nama }}</td>
                                <td>
                                    {!! Form::open([
                                            'route'=> ['walisiswa.update', $item->id],
                                            'method'=>'PUT',
                                            'onsubmit'=>'return confirm("Yakin Ingin Hapus Data Ini?")',
                                            ]) !!}

                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i> Hapus
                                        </button>
                                    {!! Form::close() !!}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
