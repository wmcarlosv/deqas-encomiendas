<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Shipment;
use Session;

class ShipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */



    public function index()
    {
        $shipments = Shipment::all();
        return view('admin.shipments.index',compact('shipments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $shipment = Shipment::findorfail($id);
        $shipment->delete();
        return redirect()->route('shipments.index');
    }

    public function delete_multiple(Request $request){
        $ids = explode(',',$request->seleccionados_eliminar);
        foreach($ids as $id){
            $shipment = Shipment::findorfail($id);
            $shipment->delete();
        }
        return redirect()->route('shipments.index');
    }

    public function store_from_home(Request $request){
        $request->validate([
            'shipment_code'=>'required',
            'customer_name'=>'required',
            'contact_email'=>'required',
            'contact_phone'=>'required',
            'region'=>'required',
            'comune'=>'required',
            'address'=>'required',
            'observation'=>'required'
        ]);

        $shipment = new Shipment();
        $shipment->shipment_code = "#".$request->shipment_code;
        $shipment->customer_name = $request->customer_name;
        $shipment->contact_email = $request->contact_email;
        $shipment->contact_phone = $request->contact_phone;
        $shipment->region = $request->region;
        $shipment->comune = $request->comune;
        $shipment->address = $request->address;
        $shipment->observation = $request->observation;
        
        if($shipment->save()){
            Session::flash('success','Orden Creada con Exito!!');
        }else{
            Session::flash('error','Error al intentar crear la Orden!!');
        }

        return redirect()->route('the_home');
    }


    public function update_from_home(Request $request, $id)
    {
         $request->validate([
            'shipment_code'=>'required',
            'customer_name'=>'required',
            'contact_email'=>'required',
            'contact_phone'=>'required',
            'region'=>'required',
            'comune'=>'required',
            'address'=>'required',
            'observation'=>'required'
        ]);

        $shipment = Shipment::findorfail($id);
        $shipment->shipment_code = $request->shipment_code;
        $shipment->customer_name = $request->customer_name;
        $shipment->contact_email = $request->contact_email;
        $shipment->contact_phone = $request->contact_phone;
        $shipment->region = $request->region;
        $shipment->comune = $request->comune;
        $shipment->address = $request->address;
        $shipment->observation = $request->observation;
        
        if($shipment->update()){
            Session::flash('success','Orden Actualizada con Exito!!');
        }else{
            Session::flash('error','Error al intentar Actualizar la Orden!!');
        }

        return redirect()->route('the_home');
    }

    public function multiple_impresion($ids){
        $data = explode(",",$ids);
        $shipments = Shipment::whereIn('id',$data)->get();
        return view('store.print-multiple',compact('shipments'));
    }
}
