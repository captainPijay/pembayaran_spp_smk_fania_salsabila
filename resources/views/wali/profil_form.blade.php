@extends('layouts.app_sneat_wali')

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
                            'admin'=>'Administrator',
                            'wali'=>'Wali Murid'
                        ],
                        null,
                        ['class'=>'form-control']) !!}
                        <span class="text-danger">{{ $errors->first('akses') }}</span>
                    </div>
                    @endif

                    <div class="mb-3 form-password-toggle mt-3">
                        <label class="form-label" for="basic-default-password">Password</label>
                        <div class="input-group input-group-merge">
                          <input name="password" type="password" id="basic-default-password32" class="form-control" placeholder="············" aria-describedby="basic-default-password">
                          <span class="input-group-text cursor-pointer" id="basic-default-password3"><i class="bx bx-hide"></i></span>
                        </div>
                      </div>
                    {!! Form::submit($button, ['class'=>'btn btn-primary mt-3']) !!}

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
