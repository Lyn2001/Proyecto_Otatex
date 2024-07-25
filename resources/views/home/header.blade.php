<header class="header_section">
    <nav class="navbar navbar-expand-lg custom_nav-container ">
      <a class="navbar-brand" href="index.html">
        <span>
          GORRAS-OTATEX
        </span>
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class=""></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav  ">
          <li class="nav-item active">
            <a class="nav-link" href="{{url('/')}}">Inicio <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{url('shop')}}">
              Compras
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{url('why')}}">
              ¿Por qué Nosotros?
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{url('testimonial')}}">
              Testimonio
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{url('contact2')}}">
              Contáctanos</a>
          </li>
        </ul>
        <div class="user_option">

          @if (Route::has('login'))


            @auth

            
            <a href="{{url('myorders')}}">
              Mis Pedidos
            </a>


          
            <a href="{{url('mycart')}}">
              <i class="fa fa-shopping-bag" aria-hidden="true"></i>
              [{{$count}}]
            </a>
          
          <!-- Authentication -->
            <form style="padding: 15px" method="POST" action="{{ route('logout') }}">
              @csrf
  
              <input class="btn btn-success" type="submit" value="logout">
  
            </form>

          @else

          <a href="{{url('/login')}}">
            <i class="fa fa-user" aria-hidden="true"></i>
            <span>
              Iniciar Sesión
            </span>
          </a>

          <a href="{{url('/register')}}">
            <i class="fa fa-vcard" aria-hidden="true"></i>
            <span>
              Registrar
            </span>
          </a>

          @endauth

        @endif


        </div>
      </div>
    </nav>
  </header>