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
			font-size: 18px;
		}
		body{
			background:  white;
		}

		div#contenedor{
			width: 520px !important;
			height: 510px !important;
			overflow: hidden;
			margin: 0px auto !important;
			margin-bottom: 35px !important;
		}

		table{
			width: 100% !important;
		}

		table tr td{
			padding: 10px 0px;
			border: 2px solid black;
		}

		text#code{
			font-size: 15px !important;
			font-weight: bold !important;
		}

		@page {
		    margin: 0 !important;
		}

		@media print {
		  #print_button {
		    display: none;
		  }

		  div#contenedor{
				width: 98% !important;
				height: 510px !important;
				overflow: hidden;
				margin: 0px auto !important;
				margin-bottom: 35px !important;
			}
		}
	</style>
</head>
<body>
	<center>
		<button type="button" id="print_button" onclick="javascript:print();">Imprimir</button>
	</center>
	@foreach($shipments as $shipment)
	<div id="contenedor">
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
	</div>
	@endforeach
</body>
</html>