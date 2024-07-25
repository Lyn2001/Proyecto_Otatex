<!DOCTYPE html>
<html>

<head>

    @include('home.css')
</head>

<body>
  <div class="hero_area">
    <!-- header section strats -->
    @include('home.header')
    <!-- end header section -->
    <!-- slider section -->

     <!-- client section -->
  <section class="client_section layout_padding">
    <div class="container">
      <div class="heading_container heading_center">
        <h2>
          Testimonio
        </h2>
      </div>
    </div>
    <div class="container px-0">
      <div id="customCarousel2" class="carousel  carousel-fade" data-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <div class="box">
              <div class="client_info">
                <div class="client_name">
                  <h5>
                    José
                  </h5>
                  <h6>
                    Cliente
                  </h6>
                </div>
                <i class="fa fa-quote-left" aria-hidden="true"></i>
              </div>
              <p>
                "La atención al cliente en Otatex es excelente. Me ayudaron a elegir la gorra perfecta y llegó en perfectas condiciones. ¡Totalmente recomendado!"
              </p>
            </div>
          </div>
          <div class="carousel-item">
            <div class="box">
              <div class="client_info">
                <div class="client_name">
                  <h5>
                    Adamaris
                  </h5>
                  <h6>
                    Clienta
                  </h6>
                </div>
                <i class="fa fa-quote-left" aria-hidden="true"></i>
              </div>
              <p>
                "Compré una gorra de lana en Otatex y estoy encantada. La calidad es excepcional y el diseño es muy bonito. Sin duda, volveré a comprar aquí."
              </p>
            </div>
          </div>
          <div class="carousel-item">
            <div class="box">
              <div class="client_info">
                <div class="client_name">
                  <h5>
                    Alejandro
                  </h5>
                  <h6>
                    Cliente
                  </h6>
                </div>
                <i class="fa fa-quote-left" aria-hidden="true"></i>
              </div>
              <p>
                "He comprado varias gorras de lana en Otatex y siempre he quedado satisfecho. Buena calidad y precio justo. ¡Muy recomendable!"
              </p>
            </div>
          </div>
        </div>
        <div class="carousel_btn-box">
          <a class="carousel-control-prev" href="#customCarousel2" role="button" data-slide="prev">
            <i class="fa fa-angle-left" aria-hidden="true"></i>
            <span class="sr-only">Anterios</span>
          </a>
          <a class="carousel-control-next" href="#customCarousel2" role="button" data-slide="next">
            <i class="fa fa-angle-right" aria-hidden="true"></i>
            <span class="sr-only">Siguiente</span>
          </a>
        </div>
      </div>
    </div>
  </section>
  <!-- end client section -->

   
  
  <!-- info section -->

 @include('home.footer')

</body>

</html>