<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Beranda Operator</title>

    <!-- CSS Utama -->
    <link rel="stylesheet" href="css/app.css" />
    <!-- Font Awesome 5.15.4 -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
      integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ=="
      crossorigin="anonymous"
      referrerpolicy="no-referrer"
    />
  </head>
  <body>
    <header class="navbar-container">
      <div class="logo">
        <img src="storage/images/logo-Kemdikbud-1.png" alt="Dicoding Indonesia" />
      </div>
      <nav class="nav-list">
        <ul>
          @auth
          <li><a href="{{ auth()->user()->akses == 'operator' ? '/operator/beranda':'/walimurid/beranda' }}">Beranda</a></li>
          <li>
            <form action="{{ route('logout') }}" method="POST">
            <button type="submit">Logout</button>
            </form>
          </li>
          @else
          <li><a href="/login">Login</a></li>
          @endauth
        </ul>
      </nav>
    </header>

    <main>
      <div class="content">
        <div class="content-description">
          <h1 class="title">SMA Megatama</h1>
          <p>
            SMA Megatama adalah sebuah institusi pendidikan SMA swasta yang beralamat di Jl. Damai No. 47 Rt. 32, Kota Jambi.
            SMA swasta ini memulai kegiatan pendidikan belajar mengajarnya pada tahun 2016. Pada saat ini SMA Megatama memakai panduan kurikulum belajar pemerintah yaitu SMA 2013 MIPA. SMA Megatama ditangani oleh seorang operator yang bernama Rizal Afrans.
          </p>

          <a href="https://sekolahloka.com/data/smas-megatama/" target="blank"><button>Lebih lanjut</button></a>
        </div>

        <div class="content-image">
          <img src="storage/images/megatama-no-bg.png" alt="Dicoding Indonesia" />
        </div>
      </div>

      <aside>
        <div class="social-media">
          <ul>
            <li>
              <a href="https://youtu.be/lq6Aho2jfEI?si=ZbwrDq-6Dli2fUzG" target="blank"><i class="fab fa-youtube"></i></a>
            </li>
            <li>
              <a href="https://www.linkedin.com/in/rindi-laraswati-b1ba42263?utm_source=share&utm_campaign=share_via&utm_content=profile&utm_medium=ios_app" target="blank"><i class="fab fa-linkedin-in"></i></a>
            </li>
            <li>
              <a href="https://www.facebook.com/yayasan.megatama/?locale=id_ID" target="blank"><i class="fab fa-facebook"></i></a>
            </li>
          </ul>
        </div>
      </aside>
    </main>
  </body>
</html>
