<?php

namespace App\Http\Controllers;

use App\Uf;
use App\Motorista;
use App\Parametro;
use App\Rules\cpfCnpj;
use App\Rules\telefoneComDDD;
use App\Veiculo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Events\NovoRegistroAtualizacaoApp;
use App\PostoAbastecimento;
use Illuminate\Support\Facades\DB;

class PostoAbastecimentoController extends Controller
{
    public $fields = array(
        'id' => 'ID',
        'nome' => 'Nome',
        'ftp_server' => 'Servidor Ftp',
        'ativo' => ['label' => 'Ativo', 'type' => 'bool']

    );

    /**
     * Display a listing of the resource.b
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {


        if (Auth::user()->canListarPostoAbastecimento()) {



            if ($request->searchField) {

                $posto_abastecimentos = DB::table('posto_abastecimentos')
                    ->select('posto_abastecimentos.*')
                    //->whereRaw('((abastecimentos.abastecimento_local = '.(isset($request->abast_local) ? $request->abast_local : -1).') or ('.(isset($request->abast_local) ? $request->abast_local : -1).' = -1))')
                    ->where('nome', 'like', '%' . $request->searchField . '%')
                    ->orderBy('nome', 'desc')
                    ->paginate();
            } else {
                $posto_abastecimentos = DB::table('posto_abastecimentos')
                    ->select('posto_abastecimentos.*')
                    ->paginate();
            }

            return View('posto_abastecimento.index', [
                'posto_abastecimentos' => $posto_abastecimentos,
                'fields' => $this->fields
            ]);
        } else {
            Session::flash('error', __('messages.access_denied'));
            return redirect()->back();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (Auth::user()->canCadastrarPostoAbastecimento()) {


            return View('posto_abastecimento.create', []);
        } else {
            Session::flash('error', __('messages.access_denied'));
            return redirect()->back();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if (Auth::user()->canCadastrarPostoAbastecimento()) {
            
            $this->validate($request, [
                'nome' => 'required|string|unique:posto_abastecimentos,id,',
                'ftp_user' => 'nullable|string',
                'ftp_pass' => 'nullable|string',
                'ftp_port' => 'nullable|integer',
                'ftp_root' => 'nullable|string',
                'ftp_passive' => 'nullable|string',
                'ftp_ssl' => 'nullable|string',
                'ftp_timeout' => 'nullable|integer',
               


            ]);

            try {
                $posto_abastecimento = new PostoAbastecimento($request->all());

                
                if ($posto_abastecimento->save()) {

                    event(new NovoRegistroAtualizacaoApp($posto_abastecimento));

                    Session::flash('success', __('messages.create_success', [
                        'model' => __('models.posto_abastecimento'),
                        'name' => $posto_abastecimento->nome
                    ]));
                    return redirect()->action('PostoAbastecimentoController@index');
                }
            } catch (\Exception $e) {
                Session::flash('error', __('messages.exception', [
                    'exception' => $e->getMessage()
                ]));
                return redirect()->back()->withInput();
            }
        } else {
            Session::flash('error', __('messages.access_denied'));
            return redirect()->back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Motorista  $motorista
     * @return \Illuminate\Http\Response
     */

    public function edit(PostoAbastecimento $posto_abastecimento)
    {
        //dd($motorista);
        if (Auth::user()->canAlterarPostoAbastecimento()) {



            return View('posto_abastecimento.edit', [
                
               
                'posto_abastecimento' => $posto_abastecimento
            ]);
        } else {
            Session::flash('error', __('messages.access_denied'));
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\PostoAbastecimento  $motorista
     * @return \Illuminate\Http\Response 
     */
    public function update(Request $request, PostoAbastecimento $posto_abastecimento)
    {

        if (Auth::user()->canAlterarPostoAbastecimento()) {
            $this->validate($request, [
                'nome' => 'required|string|unique:posto_abastecimentos,id,' . $posto_abastecimento->id,
                'ftp_user' => 'nullable|string',
                'ftp_pass' => 'nullable|string',
                'ftp_port' => 'nullable|integer',
                'ftp_root' => 'nullable|string',
                'ftp_passive' => 'nullable|string',
                'ftp_ssl' => 'nullable|string',
                'ftp_timeout' => 'nullable|integer',
               


            ]);

            try {


                $posto_abastecimento->nome = $request->nome;
                $posto_abastecimento->ftp_server = $request->ftp_server;
                $posto_abastecimento->ftp_user = $request->ftp_user;
                $posto_abastecimento->ftp_pass = $request->ftp_pass;
                $posto_abastecimento->ftp_port = $request->ftp_port;
                $posto_abastecimento->ftp_root = $request->ftp_root;
                $posto_abastecimento->ftp_passive = $request->ftp_passive;

                $posto_abastecimento->ftp_ssl = $request->ftp_ssl;
                $posto_abastecimento->ftp_timeout = $request->ftp_timeout;
                

                if ($posto_abastecimento->save()) {

                    event(new NovoRegistroAtualizacaoApp($posto_abastecimento));

                    Session::flash('success', __('messages.update_success', [
                        'model' => __('models.posto_abastecimento'),
                        '$cliente->nome_razao'
                    ]));
                    return redirect()->action('PostoAbastecimentoController@index');
                }
            } catch (\Exception $e) {
                Session::flash('error', __('messages.exception', [
                    'exception' => $e->getMessage()
                ]));
                return redirect()->back()->withInput();
            }
        } else {
            Session::flash('error', __('messages.access_denied'));
            return redirect()->back();
        }
    }

    public function listagemMotoristas()
    {
        return View('relatorios.motoristas.listagem_motoristas')->withMotoristas(Motorista::all())->withTitulo('Listagem de Motoristas')->withParametro(Parametro::first());
    }

    public function destroy(Motorista $motorista)
    {
        if (Auth::user()->canExcluirMotorista()) {
            try {
                if ($motorista->delete()) {

                    event(new NovoRegistroAtualizacaoApp($motorista, true));

                    Session::flash('success', __('messages.delete_success', [
                        'model' => __('models.motorista'),
                        'name' => $motorista->nome
                    ]));
                    return redirect()->action('MotiristaController@index');
                }
            } catch (\Exception $e) {
                switch ($e->getCode()) {
                    case 23000:
                        Session::flash('error', __('messages.fk_exception'));
                        break;
                    default:
                        Session::flash('error', __('messages.exception', [
                            'exception' => $e->getMessage()
                        ]));
                        break;
                }
                return redirect()->action('MotoristaController@index');
            }
        } else {
            Session::flash('error', __('messages.access_denied'));
            return redirect()->back();
        }
    }

    public function apiMotoristas()
    {
        return response()->json(DB::table('motoristas')
            ->select('motoristas.*')->get());
    }
    public function apiMotoristaid($id)
    {
        return response()->json(Motorista::ativo()->where('id', $id)->get());
    }
}
