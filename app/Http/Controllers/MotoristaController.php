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
        'data_validade_habilitacao' => ['label' => 'Validade Habilitação', 'type' => 'datetime'],
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
        if ($request->searchField) {
            $motoristas = Motorista::where('nome', 'like', '%' . $request->searchField . '%')
                ->orWhere('apelido', 'like', '%' . $request->searchField . '%')
                ->orWhere('cpf', 'like', '%' . $request->searchField . '%')
                ->orWhere('rg', 'like', '%' . $request->searchField . '%')
                ->orWhere('endereco', 'like', '%' . $request->searchField . '%')
                ->orWhere('fone', 'like', '%' . $request->searchField . '%')
                ->orWhere('habilitacao', 'like', '%' . $request->searchField . '%')
                ->paginate();
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
        //dd($request);
        if (Auth::user()->canCadastrarMotorista()) {
            $this->validate($request, [
                'nome' => 'required|string|unique:motoristas',
                'apelido' => 'nullable|string',
                'cpf' => ['required', new cpfCnpj],
                'rg' => 'required',
                'habilitacao' => 'required|string',
                'categoria' => 'required',
               // 'data_validade_habilitacao' => 'required|date_format:d/m/Y H:i:s',
                'pontos_habilitacao' => 'nullable|string',
                'observacoes' => 'nullable|string',
                'endereco' => 'required|string|min:3|max:200',
                'numero' => 'required',
                'bairro' => 'required|string|min:3|max:200',
                'cidade' => 'required|string|min:3|max:200',
                'uf_id' => 'required',
                'cep' => 'required',
                'fone' => 'nullable|string',
                //'fone' =>  ['required', new telefoneComDDD],
                'email' => 'nullable|string',
               // 'data_nascimento' => 'required|date_format:d/m/Y H:i:s',
               // 'data_admissao' => 'required|date_format:d/m/Y H:i:s',
                'estado_civil' => 'nullable|estado_civil',
                'tipo_sanguineo' => 'nullable|string',
                'veiculo_padrao_id' => 'nullable|numeric'
                


            ]);

            try {
                $motorista = new Motorista($request->all());
                $data_nascimento = \DateTime::createFromFormat('d/m/Y H:i', $request->data_nascimento);
                $data_admissao = \DateTime::createFromFormat('d/m/Y H:i', $request->data_admissao);
                $data_validade_habilitacao = \DateTime::createFromFormat('d/m/Y H:i', $request->data_validade_habilitacao);

                $motorista->data_nascimento = $data_nascimento->format('Y-m-d H:i:s');
                $motorista->data_admissao = $data_admissao->format('Y-m-d H:i:s');
                $motorista->data_validade_habilitacao = $data_validade_habilitacao->format('Y-m-d H:i:s');


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
                'veiculos' => Veiculo::all(),
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
                'rg' => 'required',
                'habilitacao' => 'required|string',
                'categoria' => 'required',
               // 'data_validade_habilitacao' => 'required|date_format:d/m/Y H:i:s',
                'pontos_habilitacao' => 'nullable|string',
                'observacoes' => 'nullable|string',
                'endereco' => 'required|string|min:3|max:200',
                'numero' => 'required',
                'bairro' => 'required|string|min:3|max:200',
                'cidade' => 'required|string|min:3|max:200',
                'uf_id' => 'required',
                'cep' => 'required',
                'fone' => 'nullable|string',
                //'fone' =>  ['required', new telefoneComDDD],
                'email' => 'nullable|string',
               // 'data_nascimento' => 'required|date_format:d/m/Y H:i:s',
               // 'data_admissao' => 'required|date_format:d/m/Y H:i:s',
                'estado_civil' => 'nullable|estado_civil',
                'tipo_sanguineo' => 'nullable|string',
                'veiculo_padrao_id' => 'nullable|numeric'

            ]);

            try {


                $data_nascimento = \DateTime::createFromFormat('d/m/Y H:i', $request->data_nascimento);
                $data_admissao = \DateTime::createFromFormat('d/m/Y H:i', $request->data_admissao);
                $data_validade_habilitacao = \DateTime::createFromFormat('d/m/Y H:i', $request->data_validade_habilitacao);

                $motorista->data_nascimento = $data_nascimento->format('Y-m-d H:i:s');
                $motorista->data_admissao = $data_admissao->format('Y-m-d H:i:s');
                $motorista->data_validade_habilitacao = $data_validade_habilitacao->format('Y-m-d H:i:s');

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
                $motorista->veiculo_id;


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
        return response()->json(Motorista::ativo()->get());
    }

    public function apiMotorista($id) {
        return response()->json(Motorista::ativo()->where('id', $id)->get());
    }


}
