@extends('adminlte::page')

@section('title', 'Entregas')

@section('content_header')
    <h1>Entregas</h1>
@stop

@section('content')
   <div class="card card-success">
       <div class="card-header">
           <h3>Listado de Entregas</h3>
       </div>
       <div class="card-body">
           <table class="table table-striped table-bordered">
               <thead>
                   <th>Codigo Despacho</th>
                   <th>Nombre Destinatario</th>
                   <th>Nombre Cliente</th>
                   <th>Direccion</th>
                   <th>Comuna</th>
                   <th>Region</th>
                   <th>Pais</th>
                   <th>Telefono Contacto</th>
                   <th>Email Contacto</th>
               </thead>
               <tbody>
                   @foreach($shipments as $shipment)
                    <tr>
                        <td>{{ $shipment->shipment_code }}</td>
                        <td>{{ $shipment->addressee }}</td>
                        <td>{{ $shipment->customer_name }}</td>
                        <td>{{ $shipment->address }}</td>
                        <td>{{ $shipment->comune }}</td>
                        <td>{{ $shipment->region }}</td>
                        <td>{{ $shipment->country }}</td>
                        <td>{{ $shipment->contact_phone }}</td>
                        <td>{{ $shipment->contact_email }}</td>
                    </tr>
                   @endforeach
               </tbody>
           </table>
       </div>
   </div>
@stop

@section('js')
    <script>
        $(document).ready(function(){
            $("table").DataTable();
        });
    </script>
@stop
