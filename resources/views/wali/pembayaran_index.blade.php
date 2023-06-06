@extends('layouts.app_sneat_wali')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">DATA PEMBAYARAN</h5>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            {!! Form::open(['route' => 'wali.pembayaran.index', 'method'=>'GET']) !!}
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
                        <table class="table table-stripped bg-dark">
                            <thead>
                                <tr>
                                    <th class="text-warning">No</th>
                                    <th class="text-warning">NISN</th>
                                    <th class="text-warning">Nama</th>
                                    <th class="text-warning">Nama Wali</th>
                                    <th class="text-warning">Metode Pembayaran</th>
                                    <th class="text-warning">Status Konfirmasi</th>
                                    <th class="text-warning">Tanggal Konfirmasi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-secondary text-white">
                                @forelse ($models as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->tagihan->siswa->nisn }}</td>
                                        <td>{{ $item->tagihan->siswa->nama }}</td>
                                        <td>{{ $item->wali->name }}</td>
                                        <td>{{ $item->metode_pembayaran }}</td>
                                        <td>{{ $item->status_konfirmasi }}</td>
                                        <td>
                                            <a href="{{ route('wali.pembayaran.show',$item->id) }}" class="btn btn-primary btn-sm mx-3"><i class="fa fa-eye"></i> Detail</a>
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
