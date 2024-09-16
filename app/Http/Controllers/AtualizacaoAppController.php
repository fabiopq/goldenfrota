<?php

namespace App\Http\Controllers;

use App\AtualizacaoApp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AtualizacaoAppController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\AtualizacaoApp  $atualizacaoApp
     * @return \Illuminate\Http\Response
     */
    public function show(AtualizacaoApp $atualizacaoApp)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\AtualizacaoApp  $atualizacaoApp
     * @return \Illuminate\Http\Response
     */
    public function edit(AtualizacaoApp $atualizacaoApp)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AtualizacaoApp  $atualizacaoApp
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AtualizacaoApp $atualizacaoApp)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AtualizacaoApp  $atualizacaoApp
     * @return \Illuminate\Http\Response
     */
    public function destroy(AtualizacaoApp $atualizacaoApp)
    {
        //
    }

    public function obterAtualizacoes($idUltimaAtualizacao = 0) {
        return response()->json(AtualizacaoApp::naoImportado($idUltimaAtualizacao)->get());
    } 

   
}
