@extends('layouts.app_sneat', ['title'=>'Beranda Operator'])

@section('style')
<style>
    body {
        background-color: #f8f9fa;
    }

    .dashboard-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px;
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
    }

    h1 {
        color: #333;
        margin-bottom: 30px;
        text-align: center;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 2px;
    }

    .card {
        background-color: #fff;
        border: none;
        border-radius: 10px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
    }

    .card-body {
        padding: 30px;
    }

    .card-title {
        font-weight: bold;
        font-size: 24px;
        margin-bottom: 20px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .card-text {
        font-size: 18px;
        color: #777;
    }

    .stats-container {
    margin-top: 50px;
}

.stats-item {
    text-align: center;
    padding: 20px;
    background-color: #f8f9fa;
    border-radius: 10px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

.stats-item-title {
    font-weight: bold;
    font-size: 24px;
    margin-top: 10px;
    color: #333;
}

.stats-item-value {
    font-size: 18px;
    color: #777;
}

.bumping-icon {
    font-size: 40px;
    color: #17a2b8;
    animation: bumpAnimation 2s infinite;
    transform-origin: center;
}

@keyframes bumpAnimation {
    0% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-10px);
    }
    100% {
        transform: translateY(0);
    }
}
.card{
    height: 100%;
}
.card-body {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .card-text {
        margin-top: 10px;
    }
</style>
@endsection

@section('content')
<div class="dashboard-container">
    <h1>Selamat Datang {{ auth()->user()->name }}</h1>
    <div class="row">
        {{-- <div class="col-md-6 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <img src="{{ asset('storage/images/tut-wuri.png') }}" alt="Megatama Logo" width="90px">
                    <p class="card-text"><i>Tut Wuri Handayani</i></p>
                </div>
            </div> --}}
        {{-- </div>
        <div class="col-md-6 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <img src="{{ asset('storage/images/megatama.png') }}" alt="Megatama Logo" width="100px">
                    <p class="card-text">SMA MEGATAMA KOTA JAMBI</p>
                </div>
            </div>
        </div> --}}
        {{-- <div class="col-md-6 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <img src="{{ asset('storage/images/jambi.png') }}" alt="Megatama Logo" width="90px">
                    <p class="card-text"><i>Kota Jambi</i></p>
                </div>
            </div>
        </div> --}}
    </div>

    <div class="stats-container">
        <div class="row">
            <div class="col-md-4">
                <div class="stats-item">
                    <i class="fa fa-users stats-item-icon bumping-icon"></i>
                    <h4 class="stats-item-title">Total Siswa Yang Aktif</h4>
                    <p class="stats-item-value">{{ $siswa->count() }}</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-item">
                    <i class="fa-solid fa-sack-dollar stats-item-icon bumping-icon"></i>
                    <h4 class="stats-item-title">Total Uang Kas</h4>
                    <p class="stats-item-value">{{ ($kas == 0) ? '0' : $kas }}</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="stats-item">
                    <i class="fa fa-envelope stats-item-icon bumping-icon"></i>
                    <h4 class="stats-item-title">Pesan Baru</h4>
                    <p class="stats-item-value">{{ auth()->user()->unreadNotifications->count()}}</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Tautan Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<!-- Tautan JavaScript Bootstrap -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
@endsection
