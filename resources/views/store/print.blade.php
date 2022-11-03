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
				<td>Empresa:</td>
				<td>Deqas Encomiendas</td>
			</tr>
			<tr>
				<td>Destinatario:</td>
				<td>{{ $data['customer'] }}</td>
			</tr>
			<tr>
				<td>Direccion:</td>
				<td>{{ $data['address'] }}</td>
			</tr>
			<tr>
				<td>Fono:</td>
				<td>
					@if($data['phone'] != 'null')
						{{ $data['phone'] }}
					@endif
				</td>
			</tr>
		</table>
		<center>
			<button type="button" onclick="javascript:print();">Imprimir</button>
		</center>
	</div>
</body>
</html>