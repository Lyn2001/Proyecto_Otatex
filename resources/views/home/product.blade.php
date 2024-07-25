<section class="shop_section layout_padding">
  <div class="container">
      <div class="heading_container heading_center">
          <h2>
              Productos
          </h2>
      </div>
      <div class="row">
          @foreach($product as $products)
              <div class="col-sm-6 col-md-4 col-lg-3">
                  <div class="box">
                      
                          <div class="img-box">
                              <img src="products/{{$products->pro_image}}" alt="">
                          </div>
                          <div class="detail-box">
                              <h6>{{$products->pro_name}}</h6>
                              <h6> Precio
                                  <span>${{$products->pro_price}}</span>
                              </h6>
                          </div>

                          <div style="padding:15px">
                            <a class="btn btn-danger" href="{{url('product_details' ,$products->id)}}">Detalles</a>
                          </div>

                          <a  class="btn btn-primary" href="{{url('add_cart', $products->id)}}">Añadir al carrito

                          </a>
                      
                  </div>
              </div>
          @endforeach
      </div>
  </div>
</section>
