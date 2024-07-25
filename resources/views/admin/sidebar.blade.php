<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<div class="d-flex align-items-stretch">
    <!-- Sidebar Navigation-->
    <nav id="sidebar">
        <!-- Sidebar Header-->
        <div class="sidebar-header d-flex align-items-center">
            {{-- <div class="avatar"><img src="{{asset('/admincss/img/avatar-5.jpg" alt="..." class="img-fluid rounded-circle')}}"></div> --}}
            <div class="title">
                <h1 class="h5">Lizbeth Saransig</h1>
                <p>Web Designer</p>
            </div>
        </div>
        <!-- Sidebar Navidation Menus--><span class="heading">Main</span>
        <ul class="list-unstyled">
            @if(Auth::user()->rol_id === 1) <!--Verifica si es admin-->
            <li><a href="{{ url('admin/dashboard') }}">
                    <i class="icon-home"></i>Inicio </a></li>
            <li>
                <a href="{{ url('view_category') }}"> <i class="icon-grid">
                    </i>Categoria </a>
            </li>

            <li><a href="#exampledropdownDropdown" aria-expanded="false" data-toggle="collapse"> <i
                        class="icon-windows"></i>Productos </a>
                <ul id="exampledropdownDropdown" class="collapse list-unstyled ">
                    <li><a href="{{ url('add_product') }}">Añadir Producto</a></li>
                    <li><a href="{{ url('view_product') }}">Ver Producto</a></li>
                </ul>
            </li>

            <li>
                <a href="{{ url('view_user') }}"> <i class="icon-user">
                    </i>Usuarios</a>
            </li>

            <li>
                <a href="{{ url('view_rol') }}"> <i class="fas fa-user-shield">
                    </i>Rol</a>
            </li>

            <li>
                <a href="{{ url('view_permissions') }}"> <i class="fas fa-shield-alt">
                    </i>Permisos</a>
            </li>

            <li>
                <a href="{{ url('manage_roles_permissions') }}"> <i class="fas fa-shield-alt">
                    </i>Permisos_Roles</a>
            </li>

            <li>
                <a href="{{ url('view_orders') }}"> <i class="fas fa-sort-alpha-down">
                    </i>Pedidos</a>
            </li>
            <li>
                <a href="{{ route('ventas.index') }}">
                    <i class="fas fa-sort-alpha-up"></i> Venta
                </a>
            </li>
            @elseif(Auth::user()->rol_id === 3)<!--Verifica si es auditor -->
            <li>
                <a href="{{ route('audits.index') }}">
                    <i class="fas fa-sort-alpha-up"></i> Auditoría
                </a>
            </li>
            <li><a href="{{ route('audits.dashboard') }}">
                <i class="fas fa-chart-bar"></i> Dashboard Auditoría
            </a></li>
            @endif
        </ul>
    </nav>