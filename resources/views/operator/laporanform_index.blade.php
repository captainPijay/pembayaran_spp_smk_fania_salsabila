@extends('layouts.app_sneat')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">Form Laporan</h5>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <h4>Laporan Tagihan</h4>
                            {!! Form::open(['route' => 'laporantagihan.index', 'method'=>'GET','target'=>'blank']) !!}
                            <div class="row gx-2">
                                {{-- <div class="col-md-2 col-sm-12">
                                    <label for="jurusan">Jurusan</label>
                                    {!! Form::select('jurusan',getNamaJurusan(), null, ['class'=>'form-control','placeholder'=>'Pilih Jurusan']) !!}
                                    <span class="text-danger">{{ $errors->first('jurusan') }}</span>
                                </div> --}}
                                <div class="col-md-2 col-sm-12">
                                    <div class="form-group">
                                        <label for="kelas">Kelas</label>
                                        {{-- {!! Form::selectRange('kelas', 10, 12, null, ['class'=>'form-control']) !!} --}}
                                        {!! Form::select('kelas', getNamaKelas(), null, ['class'=>'form-control','placeholder'=>'Pilih Kelas']) !!}
                                        <span class="text-danger">{{ $errors->first('kelas') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-12">
                                    <label for="angkatan">Angkatan</label>
                                  {!! Form::selectRange('angkatan', 2020, date('Y')+1, request('tahun'), ['class'=>'form-control','placeholder'=>'Pilih Angkatan']) !!}
                                  <span class="text-danger">{{ $errors->first('angkatan') }}</span>
                                </div>
                                <div class="col-md-2 col-sm-12">
                                    <label for="status">Status</label>
                                  {!! Form::select('status', [
                                    'lunas'=>'Lunas',
                                    'baru'=>'Baru',
                                    'angsur'=>'Angsur',
                                  ], request('status'), ['class'=>'form-control','placeholder'=>'Pilih Status']) !!}
                                  <span class="text-danger">{{ $errors->first('status') }}</span>
                                </div>
                                <div class="col-md-2 col-sm-12">
                                    <label for="bulan">Bulan</label>
                                  {!! Form::selectMonth('bulan', request('bulan'), ['class'=>'form-control','placeholder'=>'Pilih Bulan']) !!}
                                </div>
                                <div class="col-md-2 col-sm-12">
                                    <label for="tahun">Tahun</label>
                                  {!! Form::selectRange('tahun', 2020, date('Y')+1, request('tahun'), ['class'=>'form-control','placeholder'=>'Pilih Tahun']) !!}
                                </div>
                                <div class="col-md-2 col-sm-12 mt-4">
                                  <button class="btn btn-primary" type="submit">Tampil</button>
                                </div>
                              </div>
                        </div>
                        {!! Form::close() !!}
                    </div>
                    <hr>
                    <div class="row mt-3">
                        <div class="col-md-12">
                            <h4>Laporan Pembayaran</h4>
                            {!! Form::open(['route' => 'laporanpembayaran.index', 'method'=>'GET', 'target'=>'blank']) !!}
                            <div class="row gx-3">
                                <div class="col-md-2 col-sm-12">
                                    <div class="form-group">
                                        <label for="kelas">Kelas</label>
                                        {!! Form::select('kelas', getNamaKelas(), null, ['class'=>'form-control','placeholder'=>'Pilih Kelas']) !!}
                                        <span class="text-danger">{{ $errors->first('kelas') }}</span>
                                    </div>
                                </div>
                                <div class="col-md-2 col-sm-12">
                                    <label for="angkatan">Angkatan</label>
                                  {!! Form::selectRange('angkatan', 2020, date('Y')+1, request('tahun'), ['class'=>'form-control','placeholder'=>'Pilih Angkatan']) !!}
                                  <span class="text-danger">{{ $errors->first('angkatan') }}</span>
                                </div>
                                <div class="col-md-2 col-sm-12">
                                    <label for="status">Status Pembayaran</label>
                                  {!! Form::select('status', [
                                    'sudah-konfirmasi'=>'Sudah Di Konfirmasi',
                                    'belum-konfirmasi'=>'Belum Di Konfirmasi'
                                  ], request('status'), ['class'=>'form-control','placeholder'=>'Pilih Status']) !!}
                                </div>
                                <div class="col-md-2 col-sm-12">
                                    <label for="bulan">Bulan</label>
                                  {!! Form::selectMonth('bulan', request('bulan'), ['class'=>'form-control','placeholder'=>'Pilih Bulan']) !!}
                                </div>
                                <div class="col-md-2 col-sm-12">
                                    <label for="tahun">Tahun</label>
                                  {!! Form::selectRange('tahun', 2020, date('Y')+1, request('tahun'), ['class'=>'form-control','placeholder'=>'Pilih Tahun']) !!}
                                </div>
                                <div class="col-md-2 col-sm-12">
                                  <button class="btn btn-primary mt-4" type="submit">Tampil</button>
                                </div>
                              </div>
                        </div>
                        {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
