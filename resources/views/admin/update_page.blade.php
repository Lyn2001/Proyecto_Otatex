<!DOCTYPE html>
<html>
  <head> 
    @include('admin.css')

    <style>

      .div_deg{
        display: flex;
        justify-content: center;
        align-items: center;
      }
      label{
        display: inline-block;
        width: 200px;
        padding: 10px;
      }

      /* input[type='text']{
        width: 300px;
        height: 60px;
      } */

      texarea{
        widows: 400px;
        height: 100px;
      }
    </style>
  </head>
  <body>

    @include('admin.header')
    
    
    @include('admin.sidebar')
      <!-- Sidebar Navigation end-->
      <div class="page-content">
        <div class="page-header">
          <div class="container-fluid">


            <h2>Actualizar Producto</h2>

            <div class="div_deg">

                <form action="{{url('edit_product', $data->id)}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div>
                        <label>Nombre del ´Producto</label>
                        <input type="text" name="product_name" value="{{$data->pro_name}}">
                    </div>

                    <div>
                        <label>Descripción</label>
                        <textarea name="product_description">{{$data->pro_description}}"</textarea>
                    </div>

                    <div>
                        <label>Precio</label>
                        <input type="text" name="product_price" value="{{$data->pro_price}}">
                    </div>

                    <div>
                        <label>Stock</label>
                        <input type="number" name="product_stock" value="{{$data->pro_stock}}">
                    </div>

                    <div>
                      <label>Categoria</label>
                      <select name="category">
                        <option value="{{$data->category}}">{{$data->category}}</option>
                        
                        @foreach($category as $category)
                        
                        <option value="{{$category->cat_name}}">{{$category->cat_name}}</option>

                        @endforeach

                      </select>
                  </div>

                  <div>
                    <label>Imagen Actual</label>
                    <img width="150" src="/products/{{$data->pro_image}}" alt="">
                  </div>

                  <div>

                    <label> Nueva Imagen</label>
                    <input type="file" name="product_image">
                  </div>

                  <div>
                    <input class="btn btn-success" type="submit" value="Actualizar Producto">
                  </div>

                </form>
            </div>

          </div>

      </div>
    </div>
    <!-- JavaScript files-->
    <script src="{{asset('admincss/vendor/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('admincss/vendor/popper.js/umd/popper.min.js')}}"> </script>
    <script src="{{asset('admincss/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('admincss/vendor/jquery.cookie/jquery.cookie.js')}}"> </script>
    <script src="{{asset('admincss/vendor/chart.js/Chart.min.js')}}"></script>
    <script src="{{asset('admincss/vendor/jquery-validation/jquery.validate.min.js')}}"></script>
    <script src="{{asset('admincss/js/charts-home.js')}}"></script>
    <script src="{{asset('admincss/js/front.js')}}"></script>
  </body>
</html>