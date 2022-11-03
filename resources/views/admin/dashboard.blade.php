@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>Escritorio</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <a href="{{ route('shipments.index') }}">
                <div class="info-box">
                  <span class="info-box-icon bg-info"><i class="fas fa-arrow-right"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">Entregas</span>
                    <span class="info-box-number">{{ $shipments->count() }}</span>
                  </div>
                </div>
            </a>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="info-box">
              <span class="info-box-icon bg-success"><i class="fas fa-store"></i></span>
              <div class="info-box-content">
                <span class="info-box-text">Tiendas</span>
                <span class="info-box-number">{{ $stores->count() }}</span>
              </div>
            </div>
        </div>
    </div>
@stop
