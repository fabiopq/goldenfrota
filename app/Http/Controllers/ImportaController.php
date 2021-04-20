<?php

namespace App\Http\Controllers;

use App\Cliente;
use App\GrupoProduto;
use App\GrupoServico;
use App\Parametro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;

class ImportaController extends Controller
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
      
        return View('importa.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
    try {
        if ($request->hasFile('arquivo')) {
            
            $handle = \fopen($request->arquivo,"r");
            $row = 0;
            while ($line = fgetcsv($handle, 1000, ";")) {
                if ($row++ == 0) {
                    continue;
                }
        
                $peoples[] = [
                'modelo' => $line[0],
                'marca' => $line[1]
                
                ];
            
            
            }
            // dd($peoples);
            foreach ($peoples as $people) {
                $grupoProduto = new GrupoProduto();
                $grupoProduto->grupo_produto = strtoupper($people['modelo']);
        
                $grupoProduto->save();
        
            }
            
            
            fclose($handle);
        } 

        if ($request->hasFile('arquivo_servico')) {
            
            $handle = \fopen($request->arquivo_servico,"r");
            $row = 0;
            while ($line = fgetcsv($handle, 1000, ";")) {
                if ($row++ == 0) {
                    continue;
                }
        
                $peoples[] = [
                'modelo' => $line[0],
                'marca' => $line[1]
                
                ];
            
            
            }
            // dd($peoples);
            foreach ($peoples as $people) {
                $gruposervico = new GrupoServico();
                $gruposervico->grupo_servico = strtoupper($people['modelo']);
        
                $gruposervico->save();
        
            }
            
            
            fclose($handle);
        } 
    } catch (\Exception $e) {
        
        Session::flash('error', 'Ocorreu um erro ao importar . '.$e->getMessage());
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
    {    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Parametro  $parametro
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Parametro $parametro)
    {
     
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
