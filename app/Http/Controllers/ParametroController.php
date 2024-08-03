<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\Parametro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;

class ParametroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $parametro = Parametro::first();
        if ($parametro == null) {
            return $this->create();
        } else {
            return $this->edit($parametro);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clientes = Cliente::where('ativo', true)->get();
        $parametro = Parametro::first();

        return View('parametro.create')->withClientes($clientes)->withParametro($parametro);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        $this->validate($request, [
            'cliente_id' => 'required',
            'logotipo' => 'image|mimes:png'
        ]);

        try {
            if ($request->hasFile('logotipo')) {
                                
                $logtipo_relatorio = $request->logotipo->storeAs('images', 'logo_relatorio.png');
                $request->logotipo->move(public_path('images'), 'logo_relatorio.png');
            }

            $parametro = Parametro::firstOrNew(['cliente_id' => $request->cliente_id]);
            $parametro->fill($request->all());
            $parametro->logotipo = 'images/'. 'logo_relatorio.png';
            //$parametro->logotipo = Storage::url('logo_relatorio.png');

            if ($parametro->save()) {
                
                Session::flash('success', 'Parâmetros cadastrados com sucesso.');
            }

            return redirect()->route('home');
        } catch (\Exception $e) {
            Storage::delete('logo_relatorio.png');
            Session::flash('error', 'Ocorreu um erro ao cadastrar os parâmetros. '.$e->getMessage());
        }

        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Parametro  $parametro
     * @return \Illuminate\Http\Response
     */
    public function show(Parametro $parametro)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Parametro  $parametro
     * @return \Illuminate\Http\Response
     */
    public function edit(Parametro $parametro)
    {
        $clientes = Cliente::where('ativo', true)->get();

        return View('parametro.edit')->withParametro($parametro)->withClientes($clientes);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Parametro  $parametro
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Parametro $parametro)
    {
        $this->validate($request, [
            'cliente_id' => 'required',
            'logotipo' => 'image|mimes:png'
        ]);

        try {
            if ($request->hasFile('logotipo')) {
                
                $request->logotipo->storeAs('public', 'logo_relatorio.png');

                //dd(Storage::url('logo_relatorio.png'));
            }

            $parametro = Parametro::find($parametro->id);

            $parametro->cliente_id = $request->cliente_id;
            $parametro->logotipo = Storage::url('logo_relatorio.png');

            if ($parametro->save()) {
                Session::flash('success', 'Parâmetros cadastrados com sucesso.');
                return redirect()->action('ParametroController@index');
            }
        } catch (\Exception $e) {
            Storage::delete('logo_relatorio.png');
            Session::flash('error', 'Ocorreu um erro ao cadastrar os parâmetros. '.$e->getMessage());
                
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Parametro  $parametro
     * @return \Illuminate\Http\Response
     */
    public function destroy(Parametro $parametro)
    {
        //
    }
}
