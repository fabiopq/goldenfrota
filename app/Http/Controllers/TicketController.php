<?php

namespace App\Http\Controllers;


use App\Atendente;
use App\User;
use App\Cliente;
use App\Atendentes;
use App\TicketPrioridadeStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Ticket;
use App\TicketPrioridade;
use App\TicketStatus;
use App\Events\NovoRegistroAtualizacaoApp;

class TicketController extends Controller
{
    public $fields = [
        'id' => 'ID',
        'nome_razao' => 'Cliente',
        'titulo' => 'Título',
        'name' => 'Usuário',
        'data_abertura' => ['label' => 'Data', 'type' => 'datetime'],

    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)

    {
        $teste = 'a';
        //if (Auth::user()->canListarticket()) {
        if ($teste) {

            $data_inicial = $request->data_inicial;
            $data_final = $request->data_final;

            if ($data_inicial && $data_final) {
                $whereData = 'tickets.data_abertura between \'' . date_format(date_create_from_format('d/m/Y H:i:s', $data_inicial . '00:00:00'), 'Y-m-d H:i:s') . '\' and \'' . date_format(date_create_from_format('d/m/Y H:i:s', $data_final . '23:59:59'), 'Y-m-d H:i:s') . '\'';
            } elseif ($data_inicial) {
                $whereData = 'tickets.data_abertura >= \'' . date_format(date_create_from_format('d/m/Y H:i:s', $data_inicial . '00:00:00'), 'Y-m-d H:i:s') . '\'';
            } elseif ($data_final) {
                $whereData = 'tickets.data_abertura <= \'' . date_format(date_create_from_format('d/m/Y H:i:s', $data_final . '23:59:59'), 'Y-m-d H:i:s') . '\'';
            } else {
                $whereData = '1 = 1'; //busca qualquer coisa
            }

            if ($request->searchField) {

                $ticketStatus = DB::table('ticket_status')
                    ->select('ticket_status.*');

                $tickets = DB::table('tickets')
                    ->select('tickets.*', 'clientes.nome_razao', 'users.name', 'ticket_status.descricao')
                    ->leftJoin('clientes', 'clientes.id', 'tickets.cliente_id')
                    ->leftJoin('users', 'users.id', 'tickets.user_id')
                    ->leftJoin('ticket_status', 'ticket_status.id', 'tickets.ticket_status_id')
                    //->where('tickets.titulo','like', '%' . $request->searchField . '%')
                    //->orWhere('clientes.nome_razao', 'like', '%' . $request->searchField . '%')
                    // ->whereRaw('((tickets.tickets_status_id = ' . (isset($request->abast_local) ? $request->abast_local : 1) . ') or (' . (isset($request->abast_local) ? $request->abast_local : 1) . ' = 1))')
                    ->whereRaw($whereData)
                    ->where('tickets.titulo', 'like', '%' . $request->searchField . '%')
                    ->orderBy('id', 'desc')
                    ->paginate();
                    //dd($tickets);
            } else {

                $ticketStatus = DB::table('ticket_status')
                    ->select('descricao.*');

                $tickets = DB::table('tickets')
                    ->select('tickets.*', 'clientes.nome_razao',  'users.name', 'ticket_status.descricao')
                    ->leftJoin('clientes', 'clientes.id', 'tickets.cliente_id')
                    ->leftJoin('users', 'users.id', 'tickets.user_id')
                    ->leftJoin('ticket_status', 'ticket_status.id', 'tickets.ticket_status_id')
                    //->whereRaw('((ordem_servicos.ordem_servico_status_id = ' . (isset($request->abast_local) ? $request->abast_local : 1) . ') or (' . (isset($request->abast_local) ? $request->abast_local : 1) . ' = -1))')
                    ->whereRaw($whereData)
                    ->orderBy('id', 'desc')
                    ->paginate();
                    
            }



            return View('ticket.index', [
                'tickets' => $tickets,
                'fields' => $this->fields
            ])->withticketsStatus($ticketStatus);
        } else {
            Session::flash('error', __('messages.access_denied'));
            return redirect()->back();
        }
    }

     /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket)
    {

     

        if (Auth::user()->canAlterarCliente()) {
            return View('ticket.edit', [
                
                'usuario' => User::all(),
                'clientes' => Cliente::all(),
                'ticketStatus' => TicketStatus::all(),
                'ticketPrioridade' => TicketPrioridade::all(),
                'atendentes' => Atendente::all(),
                'ticket' => $ticket,

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
        if (Auth::user()->canCadastrarTicket()) {
            $clientes = Cliente::where('ativo', true)->orderBy('nome_razao', 'asc')->get();
            $ticketStatus = TicketStatus::orderBy('descricao', 'asc')->get();
            $atendentes = Atendente::orderBy('nome_atendente', 'asc')->get();
            $ticketPrioridade = TicketPrioridade::orderBy('id', 'asc')->get();

            return View('ticket.create')->withClientes($clientes)->withTicketStatus($ticketStatus)
            ->withAtendentes($atendentes)->withTicketPrioridade($ticketPrioridade);
        } else {
            Session::flash('error', __('messages.access_denied'));
            return redirect()->back();
        }
    }

    public function store(Request $request)
    {


        $this->validate($request, [
            //'tickets_prioridade_id' => 'required|integer|min:1',
            'titulo' => 'required|min:1'
            
        ]);
       

        try {
         //   dd($request->all());   
         //   $ticket = new Ticket();
            //data_abertura
            //data_fechamento
/*
            $ticket->cliente_id = $request->cliente_id;
            $ticket->cliente_nome = $request->cliente_nome;
            $ticket->solicitante = $request->solicitante;
            $ticket->user_id = $request->user_id;
            $ticket->atendente_atribuido_id = $request->atendente_atribuido_id;
            $ticket->titulo = $request->titulo;
            $ticket->problema = $request->problema;
            $ticket->solucao = $request->solucao;
            $ticket->atendente_id = $request->atendente_id;
            $ticket->ticket_categoria_id = $request->ticket_categoria_id;
            $ticket->ticket_status_id = $request->ticket_status_id;
            $ticket->tickets_prioridade_id = $request->ticket_prioridade_id;
*/
            $ticket = new Ticket($request->all());
            $ticket->data_abertura = \DateTime::createFromFormat('d/m/Y H:i:s', $request->data_abertura)->format('Y-m-d H:i:s');
          

            //dd($ticket);

            if ($ticket->save()) {

                event(new NovoRegistroAtualizacaoApp($ticket));

                    Session::flash('success', __('messages.create_success', [
                        'model' => __('models.ticket'),
                        'name' => $ticket->titulo
                    ]));
                    return redirect()->action('TicketController@index');
                }
            } catch (\Exception $e) {
                Session::flash('error', __('messages.exception', [
                    'exception' => $e->getMessage()
                ]));
                return redirect()->back()->withInput();
            }
    }

    public function update(Request $request, Ticket $ticket)
    {
        if (Auth::user()->canAlterarCliente()) {
           /* $this->validate($request, [
                'nome_razao' => 'required|string|unique:clientes,id,' . $cliente->id,
                'fantasia' => 'nullable|string',
                'cpf_cnpj' => ['required', new cpfCnpj],
                'rg_ie' => 'required',
                'fone1' =>  ['nullable', new telefoneComDDD],
                'fone2' => ['nullable', new telefoneComDDD],
                'email1' => 'nullable|email',
                'email2' => 'nullable|email',
                //'site' => 'nullable|site',
                'endereco' => 'required|string|min:1|max:200',
                'numero' => 'required',
                'bairro' => 'required|string|min:1|max:200',
                'cidade' => 'required|string|min:1|max:200',
                'cep' => 'required',
                'uf_id' => 'required'
            ]);
*/
            try {
                $ticket->cliente_id = $request->cliente_id;
                $ticket->titulo = $request->titulo;
                
                $ticket->cliente_id = $request->cliente_id;
                
                $ticket->ticket_status_id = $request->ticket_status_id;
                $ticket->ticket_prioridade_id = $request->ticket_prioridade_id;
                $ticket->solicitante = $request->solicitante;
                $ticket->atendente_atribuido_id = $request->atendente_atribuido_id;
                $ticket->problema = $request->problema;
                $ticket->solucao = $request->solucao;
                $ticket->solicitante = $request->solicitante;
                /*
                $ticket->numero = $request->numero;
                $ticket->bairro = $request->bairro;
                $ticket->cidade = $request->cidade;
                $ticket->cep = $request->cep;
                $ticket->uf_id = $request->uf_id;
                $ticket->site = $request->site;
                $ticket->ativo = $request->ativo;
                $ticket->controla_credito = $request->controla_credito;
                $ticket->tag = $request->tag;
                $ticket->limite = $request->limite;
*/
                //dd($request);
                if ($ticket->save()) {

                    event(new NovoRegistroAtualizacaoApp($ticket));

                    Session::flash('success', __('messages.update_success', [
                        'model' => __('models.ticket'),
                        '$ticket->titulo'
                    ]));
                    return redirect()->action('TicketController@index');
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
     * Remove the specified resource from storage.
     *
     * @param  \App\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $ticket)
    {
        if (Auth::user()->canExcluirTicket()) {
            try {
                if ($ticket->delete()) {

                    event(new NovoRegistroAtualizacaoApp($ticket, true));

                    Session::flash('success', __('messages.delete_success', [
                        'model' => __('models.ticket'),
                        'name' => $ticket->titulo
                    ]));
                    return redirect()->action('TicketController@index');
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
                return redirect()->action('TicketController@index');
            }
        } else {
            Session::flash('error', __('messages.access_denied'));
            return redirect()->back();
        }
    }

}
