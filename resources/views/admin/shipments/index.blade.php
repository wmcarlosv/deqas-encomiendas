@extends('adminlte::page')

@section('title', 'Entregas')

@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.3/css/buttons.dataTables.min.css">
@stop

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
                   <th>Estado</th>
                   <th>Fecha</th>
               </thead>
               <tbody>
                   @foreach($shipments as $shipment)
                    <tr>
                        <td>{{ $shipment->shipment_code }}</td>
                        <td>{{ $shipment->addressee }}</td>
                        <td>{{ $shipment->vendor }}</td>
                        <td>{{ $shipment->address }}</td>
                        <td>{{ $shipment->comune }}</td>
                        <td>{{ $shipment->region }}</td>
                        <td>{{ $shipment->country }}</td>
                        <td>{{ $shipment->contact_phone }}</td>
                        <td>{{ $shipment->contact_email }}</td>
                        <td>
                            @if($shipment->status)
                                Preparado
                            @else
                                No Preparado
                            @endif
                        </td>   
                        <td>
                            {{ date('d-m-Y',strtotime($shipment->created_at)) }}
                        </td>
                    </tr>
                   @endforeach
               </tbody>
           </table>
       </div>
   </div>
@stop

@section('js')
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>

    <script>
        $(document).ready(function(){
            $("table").DataTable({
                 dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
        });
    </script>
@stop
