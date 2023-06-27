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
                        'files'=>true
                    ]) !!}
                    {{-- ini cara kalo pake User::where('akses', 'wali') --}}
                    {{-- <select class="form-select mb-3" aria-label="Default select example" name="dokter_id">
                        @foreach($wali as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                      </select> --}}

                      {{-- ini cara kalo pake User::where('akses','wali')->pluck('name','id') menampilkan parameter pertama --}}
                    <div class="form-group mb-3">
                        <label for="wali_id">Wali Name (optional)</label>
                        {!! Form::select('wali_id', $wali, null, [
                            'class'=>'form-control select2',
                            'placeholder'=>'Pilih Wali Murid'
                        ]) !!}
                        <span class="text-danger">{{ $errors->first('wali_id') }}</span>
                    </div>
                    <div class="form-group">
                        <label for="nama">Name</label>
                        {!! Form::text('nama', null, ['class'=>'form-control', 'autofocus']) !!}
                        <span class="text-danger">{{ $errors->first('nama') }}</span>
                    </div>
                    <div class="form-group mt-3">
                        <label for="biaya_id">Biaya SPP</label>
                        {!! Form::select('biaya_id', $listBiaya, null, ['class'=>'form-control']) !!}
                        <span class="text-danger">{{ $errors->first('biaya_id') }}</span>
                    </div>
                    <div class="form-group mt-3">
                        <label for="nisn">NISN</label>
                        {!! Form::text('nisn', null, ['class'=>'form-control']) !!}
                        <span class="text-danger">{{ $errors->first('nisn') }}</span>
                    </div>
                    <div class="form-group mt-3">
                        <label for="jurusan">Jurusan</label>
                        {!! Form::select('jurusan',getNamaJurusan(), null, ['class'=>'form-control']) !!}
                        <span class="text-danger">{{ $errors->first('jurusan') }}</span>
                    </div>
                    <div class="form-group mt-3">
                        <label for="jenis_kelamin">Jenis Kelamin</label>
                        {!! Form::select('jenis_kelamin',
                        [
                            'Laki-Laki'=>'Laki-Laki',
                            'Perempuan'=>'Perempuan'

                        ], null, ['class'=>'form-control']) !!}
                        <span class="text-danger">{{ $errors->first('jurusan') }}</span>
                    </div>
                    <div class="form-group mt-3">
                        <label for="kelas">Kelas</label>
                        {{-- {!! Form::selectRange('kelas', 10, 12, null, ['class'=>'form-control']) !!} --}}
                        {!! Form::select('kelas', getNamaKelas(), null, ['class'=>'form-control']) !!}
                        <span class="text-danger">{{ $errors->first('kelas') }}</span>
                    </div>
                    <div class="form-group mt-3">
                        <label for="angkatan">Angkatan</label>
                        {!! Form::selectRange('angkatan', 2020, date('Y'), null, ['class'=>'form-control']) !!}
                        <span class="text-danger">{{ $errors->first('angkatan') }}</span>
                    </div>
                    <div class="form-group mt-3">
                        <label for="foto" class="mb-2">Foto <b class="text-danger">(Format: jpg,jpeg,png. Ukuran Maks: 5MB)</b></label>
                        @if ($model->foto)
                            <img src="{{ Storage::url($model->foto) }}" alt="" width="200" class="img-thumbnail img-preview mb-3">
                        @else
                            <img class="img-preview img-fluid mb-3" width="200">
                        @endif

                        <input type="file" id="image" name="foto" class="form-control mb-3" onchange="previewImage()">

                        <span class="text-danger">{{ $errors->first('foto') }}</span>
                        {{-- {!! Form::file('foto', ['class'=>'form-control', 'accept'=>'image/*', 'id'=>'image', 'onchange'=>'previewImage()']) !!} --}}
                    </div>
                    {!! Form::submit($button, ['class'=>'btn btn-primary mt-3']) !!}

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>


    <script>

        //menampilkan preview image dengan javascript queryselector
        function previewImage(){
            const image = document.querySelector('#image');
            const imgPreview = document.querySelector('.img-preview');

            imgPreview.style.display = 'block';
            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);

            oFReader.onload = function(oFREvent){
                imgPreview.src = oFREvent.target.result;
            }
        }
    </script>
@endsection
