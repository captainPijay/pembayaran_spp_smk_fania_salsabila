@extends('layouts.app_sneat')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">DATA PEMBAYARAN</h5>

                <div class="card-body">
                    <div class="row d-flex justify-content-end">
                        <div class="col-md-10">
                            {!! Form::open(['route' => 'pembayaran.index', 'method'=>'GET']) !!}
                            <div class="row justify-content-end gx-3">
                                <div class="col-md-2 col-sm-12 my-3">
                                  {!! Form::select('status', [
                                    'sudah-konfirmasi'=>'Sudah Di Konfirmasi',
                                    'belum-konfirmasi'=>'Belum Di Konfirmasi'
                                  ], request('status'), ['class'=>'form-control','placeholder'=>'Pilih Status']) !!}
                                </div>
                                <div class="col-md-2 col-sm-12 my-3">
                                  {!! Form::selectMonth('bulan', request('bulan'), ['class'=>'form-control','placeholder'=>'Pilih Bulan']) !!}
                                </div>
                                <div class="col-md-2 col-sm-12 my-3">
                                  {!! Form::selectRange('tahun', 2022, date('Y')+1, request('tahun'), ['class'=>'form-control','placeholder'=>'Pilih Tahun']) !!}
                                </div>
                                <div class="col-md-2 col-sm-12 my-3">
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
                                    <th class="{{ config('app.th_style') }}">Nama</th>
                                    <th class="{{ config('app.th_style') }}">Nama Wali</th>
                                    <th class="{{ config('app.th_style') }}">Metode Pembayaran</th>
                                    <th class="{{ config('app.th_style') }}">Status Konfirmasi</th>
                                    <th class="{{ config('app.th_style') }}">Tanggal Konfirmasi</th>
                                    <th class="{{ config('app.th_style') }}">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="bg-secondary text-white">
                                @forelse ($models as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->tagihan->siswa->nisn }}</td>
                                        <td>{{ $item->tagihan->siswa->nama }}</td>
                                        <td>{{ $item->wali->name ?? 'Belum Ada'}}</td>
                                        <td>{{ $item->metode_pembayaran }}</td>
                                        <td>{{ $item->status_konfirmasi }}</td>
                                        <td>
                                            @if ($item->tanggal_konfirmasi != null)
                                            {{ $item->tanggal_konfirmasi->format('d/m/y') }}
                                            @else
                                            {{ "Menunggu Konfirmasi" }}
                                            @endif
                                        </td>
                                        <td>
                                        {!! Form::open([
                                                'route'=> ['pembayaran.destroy', $item->id],
                                                'method'=>'DELETE',
                                                'onsubmit'=>'return confirm("Yakin Ingin Hapus Data Ini? Jika Menghapus Data Pembayaran Di Sini Maka Data Untuk Tagihan Nya Pun Akan Ikut Terhapus Sebaiknya Hapus Data Saat Tahun Ajaran Baru.")',
                                                ]) !!}

                                            <a href="{{ route('pembayaran.show',$item->id) }}" class="btn btn-primary btn-sm mx-3"><i class="fa fa-eye"></i> Detail</a>
                                            {{-- <form action="{{ route('tagihan.destroy', $item->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                            </form> --}}
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
