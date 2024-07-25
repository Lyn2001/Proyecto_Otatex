<!DOCTYPE html>
<html>
  <head>
    @include('admin.css')
  </head>
  <body>

    @include('admin.header')
    
    <style type="text/css">
    
    .div_deg {
        display: flex;
        justify-content: center;
        align-items: center;
        margin: 60px;
        flex-direction: column;
    }

    .form-group {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
        width: 100%; /* Asegura que el contenedor ocupe todo el ancho disponible */
    }

    .form-group label {
        width: 200px; /* Ajusta este valor según tus necesidades */
        text-align: right;
        margin-right: 10px;
    }

    input[type='text'] {
        width: 350px;
        height: 40px;
    }

    textarea.large-textbox {
        width: 500px; /* Ajusta este valor según tus necesidades */
        height: 100px; /* Ajusta este valor según tus necesidades */
    }

    .form-group input, .form-group textarea {
        flex: 1;
    }

    </style>
    
    @include('admin.sidebar')
    <!-- Sidebar Navigation end-->
    <div class="page-content">
        <div class="page-header">
          <div class="container-fluid">

            <h1 style="color: black">Actualizar Categoria</h1>
            <div class="div_deg">

                <form action="{{url('update_category',$data->id)}}" method="post">
                    
                    @csrf

                    <div class="form-group">
                        <label for="category">Nombre de la Categoría:</label>
                        <input type="text" name="category" value="{{$data->cat_name}}">
                    </div>
                    <div class="form-group">
                        <label for="category_description">Descripción:</label>
                        <textarea name="category_description" class="large-textbox">{{$data->cat_description}}</textarea>
                    </div>
                    <div class="form-group">
                        <input class="btn btn-primary" type="submit" value="Actualizar Categoria">
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
