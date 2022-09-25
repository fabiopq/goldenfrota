@extends('layouts.relatorios')

@section('relatorio')

{{-- {{dd($clientes)}} --}}
@foreach($clientes as $cliente)
@php
//dd($clientes);
@endphp
<tr height="2000">



    <div class="panel-sm">
        <div class="panel-sm">
            <div class="card-header report-subtitle-1">
                <h4> Cliente: {{$cliente->nome_razao}} </h4>
            </div>
            <div class="card-body">

                @foreach($cliente->departamentos as $departamento)


                <div class="panel-sm">
                    <div class="card-header report-subtitle-1">

                        <h5>Departamento: {{$departamento->departamento}}</h5>

                    </div>
                    <div class="card-body">
                        <table class="table table-sm report-table">
                            <thead>
                                <td>Código</td>
                                <td align="left">Placa</td>
                                <td align="left">Modelo</td>
                                <td align="left">Marca</td>
                                <td align="left">Ano</td>
                                <td align="left">Média Minima</td>
                            </thead>
                            <tbody>
                                @foreach($departamento->veiculos as $veiculo)

                                <tr>
                                    <td> {{$veiculo->id}} </td>
                                    <td align="left"> {{$veiculo->placa}} </td>
                                    <td align="left"> {{$veiculo->modelo_veiculo}} </td>
                                    <td align="left"> {{$veiculo->marca_veiculo}} </td>
                                    <td align="left"> {{$veiculo->ano}} </td>
                                    <td align="left"> {{$veiculo->media_minima}} </td>



                                </tr>

                                @endforeach
                                <tr class="success">
                                    <td colspan=2>Total do Departamento</td>
                                    <td align="right"></td>
                                    <td align="right"></td>
                                    <td align="right"></td>
                                    <td align="right"></td>
                                    <td align="right"></td>

                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</tr>
@endforeach

@endsection