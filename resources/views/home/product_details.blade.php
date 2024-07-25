<!DOCTYPE html>
<html>

<head>

    @include('home.css')

    <style type="text/css">
    
    .div_center{
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 30px;
    }
    
    .detail-box{
        padding: 15px;
    }

    </style>
</head>

<body>
  <div class="hero_area">
    <!-- header section strats -->
    @include('home.header')
    <!-- end header section -->

  </div>

{{-- Product details start --}}

<section class="shop_section layout_padding">
    <div class="container">
        <div class="heading_container heading_center">
            <h2>
                Productos
            </h2>
        </div>
        <div class="row">
            
                <div class="col-md-12">
                    <div class="box">
                        
                            <div class="div_center">
                                <img width="400" src="/products/{{$data->pro_image}}" alt="">
                            </div>


                            <div class="detail-box">
                                <h6>{{$data->pro_name}}</h6>
                                <h6> Price
                                    <span>${{$data->pro_price}}</span>
                                </h6>
                            </div>


                            <div class="detail-box">
                                <h6>Categoria: {{$data->category}}</h6>

                                <h6> Disponibilidad de stock
                                    <span>{{$data->pro_stock}}</span>
                                </h6>
                            </div>
                        

                            <div class="detail-box">

                                    <p>{{$data->pro_description}}</p>
                                
                            </div>
                    </div>
                </div>
            
        </div>
    </div>
  </section>
  




{{-- products details end --}}

   

  <!-- info section -->

 @include('home.footer')

</body>

</html>