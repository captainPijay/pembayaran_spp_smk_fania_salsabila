@extends('layouts.app_sneat')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">DATA TAGIHAN SPP SISWA {{strtoupper($periode)}}</h5>
                <div class="card-body">
                    <table class="table table-sm">
                <tr>
                    @if ($siswa->foto == true)
                    <td rowspan="8" width="100">
                        <img src="{{ Storage::url($siswa->foto) }}" alt="" width="180px" class="rounded mb-3">
                    </td>

                    @elseif($siswa->foto == null && $siswa->jenis_kelamin =='Perempuan' )
                    <td rowspan="8" width="100">
                    <img src="{{ asset('storage/images/no-image-woman.png') }}" alt="" width="180px" class="rounded mb-3">
                    </td>
                    @elseif($siswa->foto == null && $siswa->jenis_kelamin =='Laki-Laki' )
                    <td rowspan="8" width="100">
                        <img src="{{ asset('storage/images/no-image-man.jpg') }}" alt="" width="180px" class="rounded mb-3">
                    </td>
                </tr>
                    @endif
                        <tr>
                            <td width="50">NISN</td>
                            <td>: {{ $siswa->nisn }}</td>
                        </tr>
                        <tr>
                            <td>Nama</td>
                            <td>: {{ $siswa->nama }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-md-5">
            <div class="card">
                <h5 class="card-header pb-0">DATA TAGIHAN {{ strtoupper($periode) }}</h5>
                <div class="card-body">
                    <table class="table table-sm table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th class="text-white">No</th>
                                <th class="text-white">Nama Tagihan</th>
                                <th class="text-white text-end">Jumlah Tagihan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($tagihan->tagihanDetails as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->nama_biaya }}</td>
                                    <td class="text-end">{{ formatRupiah($item->jumlah_biaya) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="2">Total Tagihan</td>
                                <td class="text-end">{{ formatRupiah($tagihan->total_tagihan) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                    <a href="{{ route('invoice.show', $tagihan->id) }}" target="_blank">
                        <i class="fa fa-file-pdf"></i> Download Invoice
                    </a>
                </div>
            </div>
            <div class="card">
                <h5 class="card-header pb-0">DATA PEMBAYARAN</h5>
                <div class="card-body">
                    <table class="table table-stripped table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th width="1%" class="text-white">#</th>
                                <th class="text-white">TANGGAL</th>
                                <th class="text-white">METODE</th>
                                <th class="text-white">JUMLAH</th>
                                <th class="text-white">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($tagihan->pembayaran as $item)
                                <tr>
                                    <td>
                                        {{ $loop->iteration }}
                                    </td>
                                    <td>{{ $item->tanggal_bayar->translatedFormat('d/m/Y') }}</td>
                                    <td>{{ $item->metode_pembayaran }}</td>
                                    <td>{{ formatRupiah($item->jumlah_dibayar) }}</td>
                                    <td>
                                        <div class="d-flex justify-contrnt-center">
                                            <a href="{{ route('kwitansipembayaran.show',$item->id) }}" target="blank" class="mx-3"><i class="fa fa-print"></i></a>
                                        {!! Form::open([
                                            'route'=> ['pembayaran.destroy', $item->id],
                                            'method'=>'DELETE',
                                            'onsubmit'=>'Yakin Ingin Hapus Data Ini?',
                                            ]) !!}
                                            <button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-trash"></i></button>
                                    {!! Form::close() !!}
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center">Data Belum Ada</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3">Total Pembayaran</td>
                                <td colspan="2" class="text-end">{{ formatRupiah($tagihan->total_pembayaran) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                    <h5 class="mt-2">Status Pembayaran : {{ strtoupper($tagihan->status)}}</h5>
                </div>
                <h5 class="card-header">FORM PEMBAYARAN</h5>
                <div class="card-body">
                    {!! Form::model($model, ['route'=>'pembayaran.store','method'=>'POST']) !!}
                    {!! Form::hidden('tagihan_id', $tagihan->id, []) !!}
                    <div class="form-group">
                        <label for="tanggal_bayar">Tanggal Pelunasan</label>
                        {!! Form::date('tanggal_bayar', $model->tanggal_bayar ?? \Carbon\Carbon::now(), ['class'=>'form-control']) !!}
                        <span class="text-danger">{{ $errors->first('tanggal_bayar') }}</span>
                    </div>
                    <div class="form-group mt-3">
                        <label for="jumlah_bayar">Jumlah Yang Di Bayarkan</label>
                        {!! Form::text('jumlah_dibayar', null, ['class'=>'form-control rupiah']) !!}
                        <span class="text-danger">{{ $errors->first('jumlah_bayar') }}</span>
                    </div>
                    {!! Form::submit('SIMPAN', ['class'=>'btn btn-primary mt-3']) !!}
                {!! Form::close() !!}
                </div>
            </div>
        </div>
        <div class="col-md-7">
            <div class="card">
                <div class="d-flex">
                    <h5 class="card-header" style="text-align: start;">KARTU SPP</h5>
                <a style="text-align: center; font-size:12px;" href="{{ route('kartuspp.index', [
                        'siswa_id'=>$siswa->id,
                        'bulan'=>request('bulan'),
                        'tahun'=>request('tahun'),
                        'detailTagihan'=>$tagihan->id
                    ]) }}" class="btn btn-primary btn-sm mt-3 py-3" target="blank"><i class="fa fa-print"></i> Cetak Kartu SPP {{ request('tahun') }}</a>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead class="table-dark">
                          <tr>
                            <th style="text-align: center;" class="text-white" width="1%">No</th>
                            <th style="text-align: start;" class="text-white">Bulan & Tahun</th>
                            <th style="text-align: end;" class="text-white">Total Tagihan</th>
                            <th style="text-align: end;" class="text-white">Tanggal Bayar</th>
                            <th></th>
                            <th></th>
                          </tr>
                        </thead>
                        <tbody>
                          @foreach ($kartuSpp as $item)
                            <tr class="item">
                              <td style="text-align: center;">{{ $loop->iteration }}</td>
                              <td style="text-align: start;">{{ $item['bulan']. ' '.$item['tahun'] }}</td>
                              <td style="text-align: end;">{{ formatRupiah($item['total_tagihan'])}}</td>
                              <td style="text-align: end;">{{ $item['tanggal_bayar'] }}</td>
                              <td></td>
                              <td></td>
                            </tr>
                          @endforeach
                        </tbody>
                      </table>
                </div>
            </div>
        </div>
    </div>
@endsection
