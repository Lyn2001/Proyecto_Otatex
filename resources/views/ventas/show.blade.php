<!DOCTYPE html>
<html>

<head>
    @include('admin.css')

    <style type="text/css">
        .div_deg {
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            margin-top: 50px;
        }

        .details_container {
            width: 80%;
            border: 3px solid greenyellow;
            padding: 20px;
            border-radius: 10px;
            background-color: #f9f9f9;
        }

        .detail_group {
            margin-bottom: 20px;
        }

        .detail_group label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        .table_deg {
            border: 2px solid #ccc;
            width: 100%;
            margin-top: 20px;
        }

        th {
            background-color: skyblue;
            color: black;
            font-size: 19px;
            font-weight: bold;
            padding: 10px;
        }

        td,
        tr {
            border: 1px solid #ccc;
            text-align: center;
            padding: 10px;
        }

        .total-display {
            font-size: 20px;
            font-weight: bold;
            margin-top: 20px;
        }

        .back-button {
            margin-top: 30px;
            align-self: flex-start;
        }
    </style>
</head>

<body>

    @include('admin.header')
    @include('admin.sidebar')

    <div class="page-content">
        <div class="page-header">
            <div class="container-fluid">
                <div class="div_deg">
                    <div class="details_container">
                        <h2>Detalles de la Venta</h2>

                        <div class="detail_group">
                            <label>Cliente:</label>
                            <p>{{ $venta->user->firstname }} {{ $venta->user->firstlastname }}</p>
                        </div>

                        <div class="detail_group">
                            <label>Fecha de Venta:</label>
                            <p>{{ $venta->fecha_venta }}</p>
                        </div>

                        <div class="detail_group">
                            <label>Método de Pago:</label>
                            <p>{{ $venta->metodo_pago }}</p>
                        </div>

                        <div class="detail_group">
                            <label>Productos:</label>
                            <table class="table_deg">
                                <tr>
                                    <th>Producto</th>
                                    <th>Cantidad</th>
                                    <th>Precio Unitario</th>
                                    <th>Subtotal</th>
                                </tr>
                                @foreach ($venta->products as $product)
                                    <tr>
                                        <td>{{ $product->pro_name }}</td>
                                        <td>{{ $product->pivot->cantidad }}</td>
                                        <td>${{ number_format($product->pivot->precio_unitario, 2) }}</td>
                                        <td>${{ number_format($product->pivot->subtotal, 2) }}</td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>

                        <div class="detail_group">
                            <label>IVA:</label>
                            <p>{{ $venta->iva }}%</p>
                        </div>

                        <div class="total-display">
                            Total: ${{ number_format($venta->total_venta, 2) }}
                        </div>

                        <div class="back-button">
                            <a href="{{ route('ventas.index') }}" class="btn btn-primary">Volver a la lista de
                                ventas</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript files -->
    @include('admin.js')

</body>

</html>
