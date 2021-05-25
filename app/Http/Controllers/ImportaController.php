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
       
            return $this->create();
        
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
           // dd($request);
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

        if ($request->hasFile('arquivo_cliente')) {
            
            $handle = \fopen($request->arquivo_cliente,"r");
            $row = 0;
            while ($line = fgetcsv($handle, 10000, ";")) {
                if ($row++ == 0) {
                    continue;
                }
        
                $peoples[] = [
                'nome_razao' => $line[1],
                'fantasia' => $line[2],
                'cpf_cnpj' => $line[3],
                'rg_ie' => $line[4],
                'fone1' => $line[6],
                'fone2' => $line[6],
                'email1' => $line[7],
                'email2' => $line[8],
                'endereco' => $line[9],
                'numero' => $line[10],
                'bairro' => $line[11],
                'cidade' => $line[12],
                'cep' => $line[13],
                'uf_id' => 24,
                'tipo_pessoa_id' => 2

                
                ];
            
            
            }

             //dd($peoples);
             
            foreach ($peoples as $people) {
                $cliente = new Cliente();
                $cliente->nome_razao = strtoupper($people['nome_razao']);
                $cliente->fantasia = strtoupper($people['fantasia']);
                $cliente->cpf_cnpj = strtoupper($people['cpf_cnpj']);
                $cliente->rg_ie = strtoupper($people['rg_ie']);
                $cliente->fone1 = strtoupper($people['fone1']);
                $cliente->email1 = strtoupper($people['email1']);
                $cliente->email2 = strtoupper($people['email2']);
                $cliente->endereco = strtoupper($people['endereco']);
                $cliente->numero = strtoupper($people['numero']);
                $cliente->bairro = strtoupper($people['bairro']);
                $cliente->cidade = strtoupper($people['cidade']);
                $cliente->cep = strtoupper($people['cep']);
                $cliente->uf_id = 24;
                $cliente->tipo_pessoa_id = 2;
               
        
                $cliente->save();
        
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
        return View('importa.create');
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
