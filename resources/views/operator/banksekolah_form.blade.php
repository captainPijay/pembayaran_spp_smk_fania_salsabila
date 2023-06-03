@extends('layouts.app_sneat')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">{{ $title }}</h5>

                <div class="card-body">
                    {!! Form::model($model, [
                        'route'=>$route,
                        'method'=>$method,
                    ]) !!}
                    <div class="form-group mb-3">
                        <label for="bank_id">Nama Bank</label>
                        {!! Form::select('bank_id', $listbank, null, ['class'=>'form-control select2']) !!}
                        <span class="text-danger">{{ $errors->first('bank_id') }}</span>
                    </div>
                    <div class="form-group mt-3">
                        <label for="nama_rekening">Nama Pemilik Rekening</label>
                        {!! Form::text('nama_rekening', null, ['class'=>'form-control']) !!}
                        <span class="text-danger">{{ $errors->first('nama_rekening') }}</span>
                    </div>
                    <div class="form-group mt-3">
                        <label for="nomor_rekening">Nomor Rekening</label>
                        {!! Form::text('nomor_rekening', null, ['class'=>'form-control']) !!}
                        <span class="text-danger">{{ $errors->first('nomor_rekening') }}</span>
                    </div>
                    {!! Form::submit($button, ['class'=>'btn btn-primary mt-3']) !!}

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
