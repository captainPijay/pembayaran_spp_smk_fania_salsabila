<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SMK FANIA SALSABILA</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
  <style>
    body {
      display: flex;
      flex-direction: column;
      min-height: 100vh;
    }

    .header {
      background-color: #084972;
      color: #fff;
      padding: 40px;
      text-align: center;
    }

    .header h1 {
      font-size: 40px;
    }

    .content {
      flex: 1;
      background-color: #64747e;
      padding: 40px;
    }

    .content p {
      font-size: 18px;
    }

    .footer {
    background-color: #64747e;
      color: #fff;
      padding: 20px;
      text-align: center;
    }
    .con {
        background-color: rgb(62, 92, 238);
        color: #fff;
        padding-top: 10px;
        padding-bottom: 10px;
        padding-right: 20px;
        padding-left: 20px;
    }
  </style>
</head>
<body>
  <div class="header d-flex justify-content-center pb-2 py-2">
    <img src="{{ asset('storage/images/fania-bg.png') }}" width="110px" class=" mx-3 img-fluid" id="unsplash-img" alt="Unsplash Image">
    <h1 class="my-4 mx-3">SMK FANIA SALSABILA</h1>
    <img src="{{ asset('storage/images/fania-bg.png') }}" width="110px" class=" mx-3 img-fluid" id="unsplash-img" alt="Unsplash Image">
  </div>

  <div class="content">
    <div class="container">
      <div class="row">
        <div class="col-md-6 mt-5">
          <a class="btn btn-info btn-lg" href="http://smkfaniasalsabila.mysch.id/">Klik Disini Untuk Mengetahui Tentang Kami</a>
        </div>
        <div class="col-md-6 mb-5 pb-4">
          <img src="{{ asset('storage/images/tut-wuri.png') }}" width="150px" class="img-fluid" id="unsplash-img" alt="Unsplash Image">
          <img src="{{ asset('storage/images/fania-bg.png') }}" width="150px" class=" mx-3 img-fluid" id="unsplash-img" alt="Unsplash Image">
          <img src="{{ asset('storage/images/jambi.png') }}" width="150px" class="img-fluid" id="unsplash-img" alt="Unsplash Image">
        </div>
    </div>
</div>
<div class="align-center text-center mt-5 mb-0">
  <a class="btn btn-lg mt-5 con" href="{{ route('login') }}"><i class="fa fa-arrow-right"></i> LOGIN <i class="fa fa-arrow-left"></i></a>
</div>
</div>
  <div class="footer">
    <p class="text-center">&copy; PEMBAYARAN SPP SMK FANIA SALSABILA KOTA JAMBI</p>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
  <script>
    // Mengambil gambar dari Unsplash API
    axios.get('https://api.unsplash.com/photos/random?client_id=YOUR_UNSPLASH_API_ACCESS_KEY')
      .then(function (response) {
        document.getElementById('unsplash-img').src = response.data.urls.regular;
      })
      .catch(function (error) {
        console.log(error);
      });
  </script>
</body>
</html>
