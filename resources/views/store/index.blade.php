@extends('layouts.app')

@section('content')
	<div class="card card-success">
		<div class="card-header">
			<h3>Ordenes</h3>
		</div>
		<div class="card-body">
			<a href="#" class="btn btn-success" data-action-url="{{ route('store_from_home') }}" id="new_shipment_button">Nueva Orden</a>
			<a class="btn btn-info" href="#" data-ids="" id="link-multiple-impresion">Imprimir Multiples</a>
			<br />
			<br />
			<table class="table table-striped table-bordered">
				<thead>
					<th>#</th>
					<th>ID Orden</th>
					<th>Nombre Cliente</th>
					<th>Email Cliente</th>
					<th>Telefono Cliente</th>
					<th>Direccion de Envio</th>
					<th>Detalle de Orden</th>
					<th>Etiqueta</th>
					<th>Accion</th>
				</thead>
				<tbody id="load_data">
					@foreach($shipments as $ship)
						<tr>
							<td><input type="checkbox" class="select-multiple-impresion" name="multiple_impresion[]" value="{{ $ship->id }}"></td>
							<td>{{ $ship->shipment_code }}</td>
							<td>{{ $ship->customer_name }}</td>
							<td>{{ $ship->contact_email }}</td>
							<td>{{ $ship->contact_phone }}</td>
							<td>{{ $ship->address.', '.$ship->comune.' '.$ship->region }}</td>
							<td><a target="_blank" href="https://{{$ship->vendor}}.myshopify.com/admin/orders/{{$ship->order_shopify_id}}" class="btn btn-success">Ver</a></td>
							<td><a href="/print-sticker/{{ str_replace('#','',$ship->shipment_code) }}" class='btn btn-success'>Imprimir</a></td>
							<td>
								<a href="#" data-action-url="{{ route('update_from_home',$ship->id) }}" data-order='{{ json_encode($ship) }}' class="btn btn-info edit-order">Editar</a>
							</td>
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
	</div>

	<!-- The Modal -->
	<div class="modal" id="new_shipment">
	  <div class="modal-dialog">
	    <div class="modal-content">

	      <!-- Modal Header -->
	      <div class="modal-header">
	        <h4 class="modal-title">Nueva Orden</h4>
	        <button type="button" class="close" data-dismiss="modal">&times;</button>
	      </div>

	      <!-- Modal body -->
	      <form id="form_action" method="POST">
	      	@method('POST')
	      	@csrf
	      <div class="modal-body">

	      	@if($errors->any())
			    <div class="alert alert-danger" style="width: margin: 10x auto 10px auto;">
			        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
			        <ul>
			            @foreach($errors->all() as $error)
			            <li><b>{{ $error }}</b></li>
			            @endforeach
			        </ul>
			    </div>
			@endif

	       	<div class="form-group">
	       		<label for="">ID Orden</label>
	       		<input type="text" name="shipment_code" class="form-control" />
	       	</div>
	       	<div class="form-group">
	       		<label for="">Nombre Cliente</label>
	       		<input type="text" name="customer_name" class="form-control" />
	       	</div>

	       	<div class="form-group">
	       		<label for="">Email Cliente</label>
	       		<input type="text" name="contact_email" class="form-control" />
	       	</div>

	       	<div class="form-group">
	       		<label for="">Telefono Cliente</label>
	       		<input type="text" name="contact_phone" class="form-control" />
	       	</div>

	       	<div class="form-group">
	       		<label for="">Region</label>
	       		<input type="text" name="region" class="form-control">
	       	</div>

	       	<div class="form-group">
	       		<label for="">Comuna</label>
	       		<input type="text" name="comune" class="form-control">
	       	</div>

	       	<div class="form-group">
	       		<label for="">Direccion de Envio</label>
	       		<textarea name="address" id="address" class="form-control"></textarea>
	       	</div>

	       	<div class="form-group">
	       		<label for="">Observacion</label>
	       		<textarea name="observation" id="observation" class="form-control"></textarea>
	       	</div>
	      </div>
	      <!-- Modal footer -->
	      <div class="modal-footer">
	      	<button type="submit" class="btn btn-success">Save</button>
	        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
	      </div>
	      </form>
	    </div>
	  </div>
	</div>
@stop

@section('js')
	<script>
		$(document).ready(function(){

			@if($errors->any())
				$("#new_shipment").modal("show");
			@endif

			$("#new_shipment_button").click(function(){
				let action = $(this).attr("data-action-url");
				clear_fields();
				$(".modal-title").text("Nueva Orden");
				$("#form_action").attr("action", action);
				$("#new_shipment").modal("show");
			});

			$("#link-multiple-impresion").click(function(){
				let ids = $(this).attr("data-ids");
				if(ids){
					location.href="/multiple-impresion/"+ids;
				}
			});

			$(".select-multiple-impresion").click(function(){
				let elements = $(".select-multiple-impresion");
				let lista = "";
				$.each(elements, function(v,e){
					if($(this).is(":checked")){
						lista+=$(this).val()+",";
					}
				});

				lista = lista.slice(0, -1);
				$("#link-multiple-impresion").attr("data-ids",lista);
			});

			$("body").on('click','a.edit-order', function(){
				let data = JSON.parse($(this).attr("data-order"));
				let action = $(this).attr("data-action-url");
				$("input[name='shipment_code']").val(data.shipment_code);
				$("input[name='customer_name']").val(data.customer_name);
				$("input[name='contact_email']").val(data.contact_email);
				$("input[name='contact_phone']").val(data.contact_phone);
				$("input[name='region']").val(data.region);
				$("input[name='comune']").val(data.comune);
				$("textarea[name='address']").val(data.address);
				$("textarea[name='observation']").val(data.observation);
				$("#form_action").attr("action", action);
				$("#new_shipment").modal("show");
				$(".modal-title").text("Actualizar Orden");
			});
		});

		function clear_fields(){
			$("input[name='shipment_code']").val("");
			$("input[name='customer_name']").val("");
			$("input[name='contact_email']").val("");
			$("input[name='contact_phone']").val("");
			$("input[name='region']").val("");
			$("input[name='comune']").val("");
			$("textarea[name='address']").val("");
			$("textarea[name='observation']").val("");
		}
	</script>
@stop