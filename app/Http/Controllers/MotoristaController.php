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
use Illuminate\Support\Facades\DB;

class MotoristaController extends Controller
{
    public $fields = array(
        'id' => 'ID',
        'nome' => 'Nome',
        'cpf' => 'CPF',
        'fone' => 'Fone',
        'data_validade_habilitacao' => ['label' => 'Validade Habilitação', 'type' => 'date'],
        'ativo' => ['label' => 'Ativo', 'type' => 'bool']

    );
   
        /**
     * Display a listing of the resource.b
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        
    if (Auth::user()->canListarMotorista()) {
        $data_inicial = $request->data_inicial;
            $data_final = $request->data_final;

            if($data_inicial && $data_final) {
                $whereData = 'motoristas.data_validade_habilitacao between \''.date_format(date_create_from_format('d/m/Y H:i:s', $data_inicial.'00:00:00'), 'Y-m-d H:i:s').'\' and \''.date_format(date_create_from_format('d/m/Y H:i:s', $data_final.'23:59:59'), 'Y-m-d H:i:s').'\'';
            } elseif ($data_inicial) {
                $whereData = 'motoristas.data_validade_habilitacao >= \''.date_format(date_create_from_format('d/m/Y H:i:s', $data_inicial.'00:00:00'), 'Y-m-d H:i:s').'\'';
            } elseif ($data_final) {
                $whereData = 'motoristas.data_validade_habilitacao <= \''.date_format(date_create_from_format('d/m/Y H:i:s', $data_final.'23:59:59'), 'Y-m-d H:i:s').'\'';
            } else {
                $whereData = '1 = 1'; //busca qualquer coisa
            }
        if ($request->searchField) {
            
            $motoristas = DB::table('motoristas')
            ->select('motoristas.*')
            //->whereRaw('((abastecimentos.abastecimento_local = '.(isset($request->abast_local) ? $request->abast_local : -1).') or ('.(isset($request->abast_local) ? $request->abast_local : -1).' = -1))')
            ->whereRaw($whereData)
            ->where('nome', 'like', '%'.$request->searchField.'%')
            ->orWhere('cpf', 'like', '%'.$request->searchField.'%')
            /* ->orderBy('abastecimentos.id', 'desc') */
            ->orderBy('nome', 'desc')
            ->paginate();
        }else if ($request->data_inicial){
                $motoristas = DB::table('motoristas')
                ->select('motoristas.*')
                //->whereRaw('((abastecimentos.abastecimento_local = '.(isset($request->abast_local) ? $request->abast_local : -1).') or ('.(isset($request->abast_local) ? $request->abast_local : -1).' = -1))')
                ->whereRaw($whereData)
                ->orderBy('nome', 'desc')
                ->paginate();
                //dd($motoristas);
        } else {
            $motoristas = Motorista::paginate();
        }

        return View('motorista.index', [
            'motoristas' => $motoristas,
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
        if (Auth::user()->canCadastrarMotorista()) {
            $veiculos = Veiculo::select(DB::raw("concat(veiculos.placa, ' - ', marca_veiculos.marca_veiculo, ' ', modelo_veiculos.modelo_veiculo) as veiculo"), 'veiculos.id')
                                ->join('modelo_veiculos', 'modelo_veiculos.id', 'veiculos.modelo_veiculo_id')
                                ->join('marca_veiculos', 'marca_veiculos.id', 'modelo_veiculos.marca_veiculo_id')
                                ->where('veiculos.ativo', true)
                                ->get();
           
            return View('motorista.create', [
                'ufs' => Uf::all()])->withveiculos($veiculos);
          
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
        
        if (Auth::user()->canCadastrarMotorista()) {
            $this->validate($request, [
                'nome' => 'required|string|unique:motoristas',
                'apelido' => 'nullable|string',
                'cpf' => ['required', new cpfCnpj],
                'rg' => 'nullable',
                'habilitacao' => 'nullable|string',
                'categoria' => 'nullable',
               // 'data_validade_habilitacao' => 'required|date_format:d/m/Y H:i:s',
                'pontos_habilitacao' => 'nullable|string',
                'observacoes' => 'nullable|string',
                'endereco' => 'nullable|string|min:3|max:200',
                'numero' => 'nullable',
                'bairro' => 'nullable|string|min:3|max:200',
                'cidade' => 'nullable|string|min:3|max:200',
                'uf_id' => 'nullable',
                'cep' => 'nullable',
                'fone' => 'nullable|string',
                //'fone' =>  ['required', new telefoneComDDD],
                'email' => 'nullable|string',
               // 'data_nascimento' => 'required|date_format:d/m/Y H:i:s',
               // 'data_admissao' => 'required|date_format:d/m/Y H:i:s',
                'estado_civil' => 'nullable|estado_civil',
                'tipo_sanguineo' => 'nullable|string',
                'veiculo_padrao_id' => 'nullable|numeric',
                'tag' => 'nullable|string'
    
            ]);

            try {
                $motorista = new Motorista($request->all());
                
                $motorista->data_nascimento = \DateTime::createFromFormat('d/m/Y H:i:s', $request->data_nascimento)->format('Y-m-d H:i:s');
                $motorista->data_admissao = \DateTime::createFromFormat('d/m/Y H:i:s', $request->data_admissao)->format('Y-m-d H:i:s');
                $motorista->data_validade_habilitacao =  \DateTime::createFromFormat('d/m/Y H:i:s', $request->data_validade_habilitacao)->format('Y-m-d H:i:s');


                if ($motorista->save()) {

                    event(new NovoRegistroAtualizacaoApp($motorista));

                    Session::flash('success', __('messages.create_success', [
                        'model' => __('models.motorista'),
                        'name' => $motorista->nome
                    ]));
                    return redirect()->action('MotoristaController@index');
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

    public function edit(Motorista $motorista)
    {
       //dd($motorista);
        if (Auth::user()->canAlterarMotorista()) {
       

            
            return View('motorista.edit', [
                'ufs' => Uf::all(),
                //'veiculos' => Veiculo::all(),
                'veiculos' => Veiculo::select(DB::raw("concat(veiculos.placa, ' - ', marca_veiculos.marca_veiculo, ' ', modelo_veiculos.modelo_veiculo) as veiculo"), 'veiculos.id')
                ->join('modelo_veiculos', 'modelo_veiculos.id', 'veiculos.modelo_veiculo_id')
                ->join('marca_veiculos', 'marca_veiculos.id', 'modelo_veiculos.marca_veiculo_id')
                ->where('veiculos.ativo', true)
                ->get(),
                'motorista' => $motorista
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
     * @param  \App\Motorista  $motorista
     * @return \Illuminate\Http\Response 
     */
    public function update(Request $request, Motorista $motorista)
    {
        
        if (Auth::user()->canAlterarMotorista()) {
            $this->validate($request, [
                'nome' => 'required|string|unique:motoristas,id,' . $motorista->id,
                'apelido' => 'nullable|string',
                'cpf' => ['required', new cpfCnpj],
                'rg' => 'nullable',
                'habilitacao' => 'nullable|string',
                'categoria' => 'nullable',
                'data_validade_habilitacao' => 'required|date_format:d/m/Y H:i:s',
                'data_nascimento' => 'required|date_format:d/m/Y H:i:s',
                'data_admissao' => 'required|date_format:d/m/Y H:i:s',
                'pontos_habilitacao' => 'nullable|string',
                'observacoes' => 'nullable|string',
                'endereco' => 'nullable|string|min:3|max:200',
                'numero' => 'nullable',
                'bairro' => 'nullable|string|min:3|max:200',
                'cidade' => 'nullable|string|min:3|max:200',
                'uf_id' => 'nullable',
                'cep' => 'nullable',
                'fone' => 'nullable|string',
                //'fone' =>  ['required', new telefoneComDDD],
                'email' => 'nullable|string',

                'estado_civil' => 'nullable|estado_civil',
                'tipo_sanguineo' => 'nullable|string',
                'veiculo_padrao_id' => 'nullable|numeric',
                

            ]);

            try {
                
               
                $motorista->data_nascimento = \DateTime::createFromFormat('d/m/Y H:i:s', $request->data_nascimento)->format('Y-m-d H:i:s');
                $motorista->data_admissao = \DateTime::createFromFormat('d/m/Y H:i:s', $request->data_admissao)->format('Y-m-d H:i:s');
                $motorista->data_validade_habilitacao =  \DateTime::createFromFormat('d/m/Y H:i:s', $request->data_validade_habilitacao)->format('Y-m-d H:i:s');

                $motorista->nome = $request->nome;
                $motorista->apelido = $request->apelido;
                $motorista->cpf = $request->cpf;
                $motorista->rg = $request->rg;
                $motorista->habilitacao = $request->habilitacao;
                $motorista->categoria = $request->categoria;
               
                $motorista->pontos_habilitacao = $request->pontos_habilitacao;
                $motorista->endereco = $request->endereco;
                $motorista->numero = $request->numero;
                $motorista->bairro = $request->bairro;
                $motorista->cidade = $request->cidade;
                $motorista->cep = $request->cep;
                $motorista->uf_id = $request->uf_id;
                $motorista->ativo = $request->ativo;
                $motorista->observacoes = $request->observacoes;
                $motorista->veiculo_id = $request->veiculo_id;
                $motorista->tag = $request->tag;


                if ($motorista->save()) {
                    
                    event(new NovoRegistroAtualizacaoApp($motorista));

                    Session::flash('success', __('messages.update_success', [
                        'model' => __('models.motorista'),
                        '$cliente->nome_razao'
                    ]));
                    return redirect()->action('MotoristaController@index');
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

    public function apiMotoristas() {
        return response()->json(  DB::table('motoristas')
        ->select('motoristas.*')->get());
    }
    public function apiMotoristaid($id) {
        return response()->json(Motorista::ativo()->where('id', $id)->get());
    }



}
