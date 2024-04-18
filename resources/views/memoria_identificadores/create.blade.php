@extends('layouts.app')

@section('content')

<div class="card m-0 border-0">


    <form action="{{ route('memoria_identificadores_upload') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="card-header"><h4>Importar Arquivo de Identificadores</h4></div>



        <div class="container-fluid">
            <div class="col">

                @component('components.form-group', [
                'inputs' => [
                [
                'type' => 'file',
                'field' => 'file',
                'label' => 'Enviar Arquivo CSV Horus',
                'required' => false,
                'autofocus' => true,
                'inputSize' => 8
                ]
                ]
                ])
                @endcomponent


                <button type="submit" class="btn btn-success">Enviar</button>

            </div>
        </div>

    </form>
</div>
@endsection