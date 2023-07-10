@extends('layouts.app_sneat')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <h5 class="card-header">{{ $title }}</h5>

                <div class="card-body">
                    {!! Form::model($model, [
                        'route'=>$route,
                        'method'=>$method
                    ]) !!}
                    <div class="form-group">
                        <label for="name">Name</label>
                        {!! Form::text('name', $model->name, ['class'=>'form-control', 'autofocus']) !!}
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                    </div>
                    <div class="form-group mt-3">
                        <label for="email">Email</label>
                        {!! Form::text('email', $model->email, ['class'=>'form-control']) !!}
                        <span class="text-danger">{{ $errors->first('email') }}</span>
                    </div>
                    <div class="form-group mt-3">
                        <label for="nohp">No HP</label>
                        {!! Form::text('nohp', $model->nohp, ['class'=>'form-control']) !!}
                        <span class="text-danger">{{ $errors->first('nohp') }}</span>
                    </div>
                    @if (Route::is('user.*'))
                    <div class="form-group mt-3">
                        <label for="akses">Hak Akses</label>
                        {!! Form::select('akses', [
                            'operator'=>'Operator Sekolah',
                            'wali'=>'Wali Murid'
                        ],
                        null,
                        ['class'=>'form-control']) !!}
                        <span class="text-danger">{{ $errors->first('akses') }}</span>
                    </div>
                    @endif
                    <div class="form-group mt-3">
                        <label for="password">Password</label>
                        {!! Form::password('password', ['class'=>'form-control']) !!}
                        <span class="text-danger">{{ $errors->first('password') }}</span>
                    </div>
                    {!! Form::submit($button, ['class'=>'btn btn-primary mt-3']) !!}

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
