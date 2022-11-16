<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Imprimir Etiqueta</title>
	<style>
		* {
			margin: 0px;
			padding: 0px;
			box-sizing: border-box;
			font-size: 10px;
		}
		body{
			background:  white;
		}

		div#contenedor{
			width: 400px !important;
			height: auto;
			overflow: hidden;
			margin: 0px auto !important;
		}

		table{
			width: 100% !important;
			margin: 5px auto !important;
		}

		table tr td{
			padding: 3px 7px;
			border: 1px solid black;
		}
	</style>
</head>
<body>
	<div id="contenedor">
		@foreach($shipments as $shipment)
		<table>
			<tr>
				<td>
					
				</td>
				<td>
					<p>Codigo de Seguimiento:</p>
					<p style="text-align: center;"><b>{{ $shipment->shipment_code }}</b></p>
				</td>
				<td>
					<h3 style="text-transform: uppercase;">Deqas</h3>
				</td>
			</tr>
						<tr>
				<td>
					<p>Fecha:</p>
					<p><b>{{ date('d/m/Y',strtotime($shipment->created_at)) }}</b></p>
				</td>
				<td colspan="2">
					<p>Remitente</p>
					<p><b>{{ $shipment->vendor }}</b></p>
				</td>
			</tr>
			<tr>
				<td colspan="3" align="center">
					{!! DNS1D::getBarcodeSVG(str_replace('#','',$shipment->shipment_code), 'CODABAR',5,50) !!}
				</td>
			</tr>
			<tr>
				<td colspan="3" style="text-align: left;">
					<p>Destinatario:</p>
					<p><b>{{ $shipment->customer_name }}</b></p>
				</td>
			</tr>
			<tr>
				<td colspan="3" style="text-align: left;">
					<p>Direccion:</p>
					<p><b>{{ $shipment->address.', '.$shipment->comune.' '.$shipment->region }}</b></p>
				</td>
			</tr>
			<tr>
				<td colspan="3" style="text-align: left;">
					<p>Observacion:</p>
					<p><b>{{ $shipment->observation }}</b></p>
				</td>
			</tr>
			<tr>
				<td colspan="3">
					<p>Fono:</p>
					<p><b>{{ $shipment->contact_phone }}</b></p>
				</td>
			</tr>
		</table>
		@endforeach
		<center>
			<button type="button" onclick="javascript:print();">Imprimir</button>
		</center>
	</div>
</body>
</html>