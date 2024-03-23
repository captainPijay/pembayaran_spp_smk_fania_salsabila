<!DOCTYPE html>
   <html lang="en">
   <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">

      <!--=============== REMIXICONS ===============-->
      <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">

      <!--=============== CSS ===============-->
      <link rel="stylesheet" href="{{ asset('sneat') }}/assets/css/login.css">

      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

      <title>{{ settings()->get('app_name', 'My APP') }}</title>
   </head>
   <body>
      <div class="login">
         <img src="https://source.unsplash.com/1100x470?school" alt="login image" class="login__img" width="10px">

         <form action="{{ route('login') }}" class="login__form" method="POST">
            @csrf
            <h1 class="login__title">Selamat Datang Bapak/Ibu Silahkan Login</h1>

            <div class="login__content">
               <div class="login__box">
                  <i class="ri-user-3-line login__icon"></i>

                  <div class="login__box-input">
                     <input type="email" required class="login__input"type="text"
                     class="form-control"
                     id="email"
                     name="email"
                     autofocus>
                     <label for="" class="login__label">Email</label>
                     @error('email')
                        <span class="text-danger">{{ $message }}</span>
                     @enderror
                  </div>
               </div>

               <div class="login__box">
                  <i class="ri-lock-2-line login__icon"></i>

                  <div class="login__box-input">
                     <input type="password" required class="login__input" id="login-pass" placeholder=" " name="password">
                     <label for="password" class="login__label">Password</label>
                     @error('password')
                     <span class="text-danger">{{ $message }}</span>
                     @enderror
                     <i class="ri-eye-off-line login__eye" id="login-eye"></i>
                  </div>
               </div>
            </div>

            <div class="login__check">
               <div class="login__check-group">
               </div>

               <a href="{{ route('password.request') }}" class="login__forgot" style="font-weight: bold">Lupa Password?</a>
            </div>

            <button type="submit" class="login__button">Login</button>

            <p class="login__register" style="font-weight: bold; font-size:18px">
               Jika Bapak/Ibu Belum Memiliki Akun, Segera Hubungi Whatsapp Dibawah Ini
               <br>
               <br>
               <a href="https://wa.me/+62895421041474" target="blank" style="font-weight: bold; color:green">
                Whatsapp <i class="fab fa-whatsapp" style="font-weight: bold; color:green"></i></a>
            </p>
         </form>
      </div>

      <!--=============== MAIN JS ===============-->
      <script src="{{ asset('sneat') }}/assets/js/newlogin.js"></script>
   </body>
</html>
