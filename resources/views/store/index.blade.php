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
					<th>Lista de Productos</th>
					<th>Sub Total</th>
					<th>Total</th>
					<th>Etiqueta</th>
				</thead>
				<tbody id="load_data"></tbody>
			</table>
		</div>
	</div>


	<!-- The Modal -->
<div class="modal" id="product-modal">
  <div class="modal-dialog">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">Lista de Productos</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <table class="table table-bordered table-striped">
        	<thead>
        		<th>Nombre</th>
        		<th>Precio</th>
        		<th>Cantidad</th>
        		<th>Total</th>
        	</thead>
        	<tbody id="load_product_data"></tbody>
        </table>
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
      </div>

    </div>
  </div>
</div>
@stop

@section('js')
<script type="text/javascript">
	$(document).ready(function(){

		$.post("{{ route('orders') }}",{ ShopUrl:"{{ $config['ShopUrl'] }}", AccessToken: "{{ $config['AccessToken'] }}", ApiVersion:'{{ $config['ApiVersion'] }}' }, function(response){
			let data = response;
			let html = "";
			console.log(data);
			$("#load_data").html("<tr><td colspan='8' align='center'>Cargando...</td></tr>");
			if(data.length > 0){
				for(let i = 0; i < data.length; i++){
					html+="<tr>";
						html+="<td>#"+data[i].order_number+"</td>";
						html+="<td>"+data[i].customer.first_name+" "+data[i].customer.last_name+"</td>";
						html+="<td>"+data[i].customer.email+"</td>";
						html+="<td>"+(data[i].customer.phone ? data[i].customer.phone: 'Sin Telefono')+"</td>";
						html+="<td>"+(data[i].shipping_address.address1+' '+data[i].shipping_address.address1+' '+data[i].shipping_address.zip+' '+data[i].shipping_address.city+' '+data[i].shipping_address.province+' '+data[i].shipping_address.country)+"</td>";
						html+="<td><a href='#' data-products='"+JSON.stringify(data[i].line_items)+"' class='btn btn-info get-products'>Ver</a></td>";
						html+="<td>"+data[i].subtotal_price+"</td>";
						html+="<td>"+data[i].total_price+"</td>";
						html+="<td><a href='/print-sticker/"+data[i].name.replace("#","")+"' class='btn btn-success'>Imprimir</a></td>";
					html+="</tr>";
				}

				$("#load_data").html(html);
			}else{
				$("#load_data").html("<tr><td colspan='9' align='center'>Sin Resultados</td></tr>");
			}
			
		});

		$("body").on('click','a.get-products', function(){
			let data = JSON.parse($(this).attr('data-products'));
			let html = "";
			for(let i=0;i<data.length;i++){
				html+="<tr>";
					html+="<td>"+data[i].name+"</td>";
					html+="<td>"+data[i].price+"</td>";
					html+="<td>"+data[i].quantity+"</td>";
					html+="<td>"+parseFloat((data[i].price * data[i].quantity))+"</td>";
				html+="</tr>";
			}
			$("#load_product_data").html(html);
			$("#product-modal").modal('show');
		})

	});
</script>
@stop