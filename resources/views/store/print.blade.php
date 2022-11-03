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
		}
		body{
			background:  white;
		}

		div#contenedor{
			width: 500px;
			height: auto;
			overflow: hidden;
			padding: 10px;
			margin: 10px auto;
			border: 1px solid black;
		}

		table{
			width: 100% !important;
		}

		table tr td:first-child{
			font-weight: bold;
			text-align: center;
		}

		table tr td{
			padding: 10px;
		}
	</style>
</head>
<body>
	<div id="contenedor">
		<table>
			<tr>
				<td>
					Deqas Encomiendas
				</td>
				<td>
					<p>Codigo de Seguimiento</p>
					<p>{{ $data[0]->shipment_code }}</p>
				</td>
				<td>
					<h3>Enviame</h3>
				</td>
			</tr>
						<tr>
				<td>
					<p>Fecha</p>
					<p>{{ date('d/m/Y',strtotime($data[0]->created_at)) }}</p>
				</td>
				<td>
					<p>Remitente</p>
					<p>{{ $data[0]->addressee }}</p>
				</td>
				<td>
					<p>Tienda</p>
					<p>wmcarlosv</p>
				</td>
			</tr>
			<tr>
				<td>
					<td colspan="3">
						{!! DNS1D::getBarcodeHTML(str_replace('#','',$data[0]->shipment_code), 'CODABAR') !!}
					</td>
				</td>
			</tr>
			<tr>
				<td colspan="3">
					<p>Destinatario</p>
					<p>{{ $data[0]->customer_name }}</p>
				</td>
			</tr>
			<tr>
				<td colspan="3">
					<p>Direccion</p>
					<p>{{ $data[0]->customer_name }}</p>
				</td>
			</tr>
			<tr>
				<td colspan="3">
					<p>Fono</p>
					<p>{{ $data[0]->contact_phone }}</p>
				</td>
			</tr>
		</table>
		<center>
			<button type="button" onclick="javascript:print();">Imprimir</button>
		</center>
	</div>
</body>
</html>