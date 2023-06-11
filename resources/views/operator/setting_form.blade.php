@extends('layouts.app_sneat', ['title'=>'Settings'])

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">Pengaturan Aplikasi</h5>

                <div class="card-body">
                   {!! Form::open([
                    'route'=>'setting.store',
                    'method'=>'POST',
                   ]
                   ) !!}
                   <h6>Pengaturan Instansi</h6>
                    <div class="form-group mb-3 mt-3">
                        <label for="app_name">Nama Instansi</label>
                        {!! Form::text('app_name', settings()->get('app_name'), ['class'=>'form-control', 'autofocus']) !!}
                        <span class="text-danger">{{ $errors->first('nama') }}</span>
                    </div>
                    <div class="form-group mt-3">
                        <label for="app_email">Email Instansi</label>
                        {!! Form::text('app_email', settings()->get('app_email'), ['class'=>'form-control']) !!}
                        <span class="text-danger">{{ $errors->first('app_email') }}</span>
                    </div>
                    <div class="form-group mt-3">
                        <label for="app_phone">Nomor Telpon Instansi</label>
                        {!! Form::text('app_phone', settings()->get('app_phone'), ['class'=>'form-control']) !!}
                        <span class="text-danger">{{ $errors->first('app_phone') }}</span>
                    </div>
                    <div class="form-group mt-3">
                        <label for="app_address">Alamat Instansi</label>
                        {!! Form::textarea('app_address', settings()->get('app_address'), [
                            'class'=>'form-control',
                            'rows'=>3
                        ]) !!}
                        <span class="text-danger">{{ $errors->first('app_address') }}</span>
                    </div>
                    <h6 class="mt-3">Pengaturan Aplikasi</h6>
                    <div class="form-group mt-3">
                        <label for="app_pagination">Data Per Halaman</label>
                        {!! Form::number('app_pagination', settings()->get('app_pagination'), ['class'=>'form-control']) !!}
                        <span class="text-danger">{{ $errors->first('app_pagination') }}</span>
                    </div>
                    {!! Form::submit('UPDATE', ['class'=>'btn btn-primary mt-3']) !!}

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
