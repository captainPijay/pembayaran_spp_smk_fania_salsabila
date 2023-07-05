<!DOCTYPE html>
<html>
<head>
  <title>{{ settings()->get('app_name', 'My App') }}</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <style>
    body {
      background-color: #d8e7f4;
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
    }

    .container {
      background-color: #fff;
      border-radius: 4px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      margin: 100px auto;
      max-width: 800px;
      padding: 40px;
    }

    h1 {
      font-size: 24px;
      margin-bottom: 20px;
      text-align: center;
    }

    p {
      font-size: 16px;
      margin-bottom: 30px;
      text-align: center;
    }

    form input {
      border: 1px solid #ccc;
      border-radius: 4px;
      display: block;
      font-size: 16px;
      margin-bottom: 20px;
      padding: 10px;
      width: 100%;
    }

    form button {
      background-color: #4caf50;
      border: none;
      border-radius: 4px;
      color: #fff;
      cursor: pointer;
      font-size: 16px;
      padding: 10px 20px;
    }

    a {
      color: #999;
      display: block;
      font-size: 14px;
      margin-top: 20px;
      text-align: center;
      text-decoration: none;
    }

    a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
    <div class="card-body">
        <div class="container">
          @if (session('status'))
              <div class="alert alert-success" role="alert">
                  {{ session('status') }}
              </div>
          @endif
          <div class="d-flex justify-content-center mb-2">
            <img src="{{ asset('storage/images/fania.png') }}" alt="fania" width="140px">
          </div>
          <h1>Lupa Password</h1>
          <div class="alert alert-info pb-0" role="alert">
              <p>
                  Jika Bapak/Ibu Kesulitan Dalam Melakukan Reset Password, Silahkan Hubungi Nomor Berikut
                  <a href="https://wa.me/+6282180864290" target="blank" style="font-weight: bold; color:green" class="mt-1">
                  Whatsapp <i class="fab fa-whatsapp" style="color:green; font-weight: bold;"></i></a>
              </p>
          </div>
          <p>Masukkan Email Anda Untuk Melakukan Reset Password</p>
          <form method="POST" action="{{ route('password.email') }}">
              @csrf
              <input type="email" id="email" name="email" placeholder="Email" required>
              <div class="row">
                <button type="submit">Kirim Link Reset</button>
              </div>
          </form>
          <a href="{{ route('login') }}">Kembali ke Halaman Login</a>
        </div>

    </div>
  </body>
  </html>
