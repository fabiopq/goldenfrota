<?php

namespace App\Http\Controllers;

use App\Veiculo;
use App\Cliente;
use App\Parametro;
use App\GrupoVeiculo;
use App\MarcaVeiculo;
use App\Departamento;
use App\ModeloVeiculo;
use App\Abastecimento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use ConsoleTVs\Charts\Facades\Charts;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use App\Events\NovoRegistroAtualizacaoApp;
use Illuminate\Support\Facades\Log;
use App\AtualizacaoApp;
use App\VeiculoStatus;

class VeiculoStatusController extends Controller
{
    public $fields = array(
        'id' => 'ID',
        'data' => ['label' => 'Data/Hora', 'type' => 'datetime'],
        'placa' => 'Placa',
        'status_id' => ['label' => 'Status', 'type' => 'tag'],
        'historico' => 'Historico',
        'ativo' => ['label' => 'Ativo', 'type' => 'bool']
    );

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        if (isset($request->searchField)) {
            $veiculoStatus = DB::table('veiculo_status')
                ->select('veiculo_status.*', 'veiculos.placa')
                ->join('veiculos', 'veiculos.id', 'veiculo_status.veiculo_id')
                ->where('placa', 'like', '%' . $request->searchField . '%')
                ->orderBy('veiculos.id', 'desc')
                ->paginate();
        } else {
            $veiculoStatus = DB::table('veiculo_status')
                ->select('veiculo_status.*', 'veiculos.placa')
                ->join('veiculos', 'veiculos.id', 'veiculo_status.veiculo_id')
                ->orderBy('veiculos.id', 'desc')
                ->paginate();
        }


        return View('veiculo_status.index')->withVeiculoStatus($veiculoStatus)->withFields($this->fields);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //$veiculos = Veiculo::all();
        $veiculos = Veiculo::select(DB::raw("concat(veiculos.placa, ' - ', marca_veiculos.marca_veiculo, ' ', modelo_veiculos.modelo_veiculo) as veiculo"), 'veiculos.id')
            ->join('modelo_veiculos', 'modelo_veiculos.id', 'veiculos.modelo_veiculo_id')
            ->join('marca_veiculos', 'marca_veiculos.id', 'modelo_veiculos.marca_veiculo_id')
            ->where('veiculos.ativo', true)
            ->get();

        return View('veiculo_status.create', [
            'veiculos' => $veiculos
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /*
        $this->validate($request, [
            'grupo_veiculo_id' => 'required|integer|min:1',
            'cliente_id' => 'required',
            'placa' =>  'required||unique:veiculos',
            'marca_veiculo_id' => 'required',
            'modelo_veiculo_id' => 'required',
            'ano' => 'required|integer',
            'renavam' => 'nullable|integer',
            'hodometro' => 'required|integer',
            'media_minima' => 'required'
        ]);
        */

        try {
            //dd($request->all());   
            $veiculoStatus = new VeiculoStatus();
            $veiculoStatus->veiculo_id = strtoupper($request->veiculo_id);
            $veiculoStatus->status_id = $request->status_id;
            $veiculoStatus->data = \DateTime::createFromFormat('d/m/Y H:i:s', $request->data)->format('Y-m-d H:i:s');
            $veiculoStatus->historico = $request->historico;


            if ($veiculoStatus->save()) {

                event(new NovoRegistroAtualizacaoApp($veiculoStatus));

                Session::flash('success', 'Veiculo ' . $veiculoStatus->veiculo_id . ' cadastrado com sucesso.');
                return redirect()->action('VeiculoStatusController@index');
            }
        } catch (\Exception $e) {
            Session::flash('error', 'Ocorreu um erro ao salvar os dados. ' . $e->getMessage());
            return Redirect::back()->withInput(Input::all());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Veiculo  $veiculo
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Veiculo  $veiculo
     * @return \Illuminate\Http\Response
     */
    public function edit(VeiculoStatus $veiculoStatus)
    {


        $veiculoStatus = VeiculoStatus::find($veiculoStatus->id);
        $veiculos = Veiculo::select(DB::raw("concat(veiculos.placa, ' - ', marca_veiculos.marca_veiculo, ' ', modelo_veiculos.modelo_veiculo) as veiculo"), 'veiculos.id')
            ->join('modelo_veiculos', 'modelo_veiculos.id', 'veiculos.modelo_veiculo_id')
            ->join('marca_veiculos', 'marca_veiculos.id', 'modelo_veiculos.marca_veiculo_id')
            ->where('veiculos.ativo', true)
            ->get();



        return View('veiculo_status.edit', [

            'veiculoStatus' => $veiculoStatus,
            'veiculos' => $veiculos,

        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Veiculo  $veiculo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, VeiculoStatus $veiculoStatus)
    {

        $this->validate($request, [
            'data' => 'required',
            'veiculo_id' => 'required',

            'status_id' => 'required'
        ]);



        try {

            $veiculoStatus = Veiculo::find($veiculoStatus->id);



            if ($veiculoStatus->save()) {

                event(new NovoRegistroAtualizacaoApp($veiculoStatus));

                Session::flash('success', 'Veiculo ' . $veiculoStatus->veiculo_id . ' alterado com sucesso.');
                return redirect()->action('VeiculoStatusController@index');
            }
        } catch (\Exception $e) {
            Session::flash('error', 'Ocorreu um erro ao salvar os dados. ' . $e->getMessage());
            return Redirect::back()->withInput(Input::all());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Veiculo  $veiculo
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
    }

    public function getVeiculosJson(Request $request)
    {
    }

    public function getVeiculosComponenteJson(Request $request)
    {
    }
}
