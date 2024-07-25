<!DOCTYPE html>
<html>

<head>
    @include('admin.css')

    <style type="text/css">
        .div_deg {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-top: 50px;
            flex-direction: column;
        }

        .table_deg {
            border: 3px solid greenyellow;
            width: 90%;
            margin-top: 20px;
        }

        th {
            background-color: skyblue;
            color: black;
            font-size: 19px;
            font-weight: bold;
            padding: 15px;
        }

        td,
        tr {
            border: 2px solid skyblue;
            text-align: center;
            padding: 10px;
        }

        input[type='search'] {
            width: 500px;
            height: 50px;
            margin-bottom: 20px;
        }

        .add-sale-button {
            margin: 20px;
            align-self: flex-end;
        }
    </style>
</head>

<body>

    @include('admin.header')
    @include('admin.sidebar')

    <div class="page-content">
        <div class="page-header">
            <div class="container-fluid">
                <!-- Search form -->
                <form action="{{ url('ventas_search') }}" method="get">
                    @csrf
                    <input type="search" name="search" placeholder="Buscar ventas...">
                    <input type="submit" class="btn btn-secondary" value="Buscar">
                </form>

                <!-- Add Sale Button -->
                <div class="add-sale-button">
                    <a href="{{ route('ventas.create') }}" class="btn btn-primary">Agregar Venta</a>
                </div>

                <div class="div_deg">
                    <!-- Sales Table -->
                    <table class="table_deg">
                        <tr>
                            <th>ID Venta</th>
                            <th>Cliente</th>
                            <th>Fecha de Venta</th>
                            <th>Método de Pago</th>
                            <th>Total</th>
                            <th>Detalles</th>
                            <th>Editar</th>
                            <th>Eliminar</th>
                        </tr>

                        <!-- Loop through sales -->
                        @foreach ($ventas as $venta)
                            <tr>
                                <td>{{ $venta->id }}</td>
                                <td>{{ $venta->user->firstname }} {{ $venta->user->firstlastname }}</td>
                                <td>{{ \Carbon\Carbon::parse($venta->fecha_venta)->format('d/m/Y') }}</td>
                                <td>{{ $venta->metodo_pago }}</td>
                                <td>${{ number_format($venta->total_venta, 2) }}</td>
                                <td>
                                    <!-- Link to show the sale details -->
                                    <a class="btn btn-info" href="{{ route('ventas.show', $venta->id) }}">Ver
                                        Detalles</a>
                                </td>
                                <td>
                                    <!-- Link to edit the sale -->
                                    <a class="btn btn-success" href="{{ route('ventas.edit', $venta->id) }}">Editar</a>
                                </td>
                                <td>
                                    <!-- Button to delete the sale -->
                                    <form action="{{ route('ventas.destroy', $venta->id) }}" method="post"
                                        onsubmit="return confirm('¿Está seguro de eliminar esta venta?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Eliminar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                    </table>

                    <!-- Pagination -->
                    <div class="pagination">
                        {{ $ventas->onEachSide(1)->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript files -->
    @include('admin.js')
</body>

</html>
