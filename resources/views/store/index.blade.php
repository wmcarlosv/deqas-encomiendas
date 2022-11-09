@extends('layouts.app')

@section('content')
	<div class="card card-success">
		<div class="card-header">
			<h3>Ordenes</h3>
		</div>
		<div class="card-body">
			<table class="table table-striped table-bordered">
				<thead>
					<th>ID Orden</th>
					<th>Nombre Cliente</th>
					<th>Email Cliente</th>
					<th>Telefono Cliente</th>
					<th>Direccion de Envio</th>
					<th>Detalle de Orden</th>
					<th>Etiqueta</th>
				</thead>
				<tbody id="load_data">
					@foreach($shipments as $ship)
						<tr>
							<td>{{ $ship->shipment_code }}</td>
							<td>{{ $ship->customer_name }}</td>
							<td>{{ $ship->contact_email }}</td>
							<td>{{ $ship->contact_phone }}</td>
							<td>{{ $ship->address.', '.$ship->comune.' '.$ship->region }}</td>
							<td><a target="_blank" href="https://{{$ship->vendor}}.myshopify.com/admin/orders/{{$ship->order_shopify_id}}" class="btn btn-success">Ver</a></td>
							<td><a href="/print-sticker/{{ str_replace('#','',$ship->shipment_code) }}" class='btn btn-success'>Imprimir</a></td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>
@stop