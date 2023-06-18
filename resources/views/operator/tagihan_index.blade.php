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
                        <div class="col-md-6">
                            {!! Form::open(['route' => $routePrefix.'.index', 'method'=>'GET']) !!}
                            <div class="row">
                                <div class="col-md-4 col-sm-12 my-3">
                                  {!! Form::selectMonth('bulan', request('bulan'), ['class'=>'form-control']) !!}
                                </div>
                                <div class="col-md-4 col-sm-12 my-3">
                                  {!! Form::selectRange('tahun', 2022, date('Y'), request('tahun'), ['class'=>'form-control']) !!}
                                </div>
                                <div class="col my-3">
                                  <button class="btn btn-primary" type="submit">Tampil</button>
                                </div>
                              </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                       <div class="table-responsive">
                        <table class="{{ config('app.table_style') }}">
                            <thead>
                                <tr>
                                    <th class="{{ config('app.th_style') }}">No</th>
                                    <th class="{{ config('app.th_style') }}">NISN</th>
                                    <th class="{{ config('app.th_style') }}">Nama Siswa</th>
                                    <th class="{{ config('app.th_style') }}">Tanggal Tagihan</th>
                                    <th class="{{ config('app.th_style') }}">Status</th>
                                    <th class="{{ config('app.th_style') }}">Total Tagihan</th>
                                    <th class="{{ config('app.th_style') }}">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-secondary text-white">
                                @if ($models->count() >=1)
                                @foreach ($models as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->siswa->nisn }}</td>
                                    <td>{{ $item->siswa->nama }}</td>
                                    <td>{{ $item->tanggal_tagihan->translatedFormat('d-F-Y') }}</td>
                                    <td>{{ $item->status }}</td>
                                    <td>{{ formatRupiah($item->tagihanDetails->sum('jumlah_biaya'))}}</td>
                                    <td>
                                    {!! Form::open([
                                            'route'=> [$routePrefix.'.destroy', $item->id],
                                            'method'=>'DELETE',
                                            'onsubmit'=>'return confirm("Yakin Ingin Hapus Data Ini?")',
                                            ]) !!}

                                        <a href="{{ route($routePrefix.'.show',[
                                            $item->id,
                                            'siswa_id'=>$item->siswa_id,
                                            'bulan'=>$item->tanggal_tagihan->format('m'),
                                            'tahun'=>$item->tanggal_tagihan->format('Y')
                                        ]) }}" class="btn btn-primary btn-sm mx-3"><i class="fa fa-eye"></i> Detail</a>
                                        <form action="{{ route('tagihan.destroy', $item->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                        </form>
                                    {!! Form::close() !!}
                                    </td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="4">Data Tidak Ada</td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                        {!! $models->links() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
