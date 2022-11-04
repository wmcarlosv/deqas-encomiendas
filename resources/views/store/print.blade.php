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
			width: 800px;
			height: auto;
			overflow: hidden;
			padding: 10px;
			margin: 10px auto;
		}

		table{
			width: 100% !important;
		}

		table tr td{
			padding: 10px 20px;
			border: 3px solid black;
		}
	</style>
</head>
<body>
	<div id="contenedor">
		<table>
			<tr>
				<td>
					
				</td>
				<td>
					<p>Codigo de Seguimiento:</p>
					<p style="text-align: center;"><b>{{ $data[0]->shipment_code }}</b></p>
				</td>
				<td>
					<h3 style="text-transform: uppercase;">Deqas</h3>
				</td>
			</tr>
						<tr>
				<td>
					<p>Fecha:</p>
					<p><b>{{ date('d/m/Y',strtotime($data[0]->created_at)) }}</b></p>
				</td>
				<td colspan="2">
					<p>Remitente</p>
					<p><b>{{ $data[0]->vendor }}</b></p>
				</td>
			</tr>
			<tr>
				<td colspan="3" align="center">
					{!! DNS1D::getBarcodeSVG(str_replace('#','',$data[0]->shipment_code), 'CODABAR',10,100) !!}
				</td>
			</tr>
			<tr>
				<td colspan="3" style="text-align: left;">
					<p>Destinatario:</p>
					<p><b>{{ $data[0]->customer_name }}</b></p>
				</td>
			</tr>
			<tr>
				<td colspan="3" style="text-align: left;">
					<p>Direccion:</p>
					<p><b>{{ $data[0]->address.', '.$data[0]->comune.' '.$data[0]->region }}</b></p>
				</td>
			</tr>
			<tr>
				<td colspan="3" style="text-align: left;">
					<p>Observacion:</p>
					<p><b>{{ $data[0]->observation }}</b></p>
				</td>
			</tr>
			<tr>
				<td colspan="3">
					<p>Fono:</p>
					<p><b>{{ $data[0]->contact_phone }}</b></p>
				</td>
			</tr>
		</table>
		<center>
			<button type="button" onclick="javascript:print();">Imprimir</button>
		</center>
	</div>
</body>
</html>