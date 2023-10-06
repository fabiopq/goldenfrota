<?php

namespace App\Http\Controllers;

use App\Atendente;
use App\User;
use App\Cliente;
use App\Atendentes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Events\UtilizadoProdutoControleVencimento;
use App\Http\Controllers\MovimentacaoProdutoController;
use App\TicketStatus;

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
                $whereData = 'ticket.data_abertura between \'' . date_format(date_create_from_format('d/m/Y H:i:s', $data_inicial . '00:00:00'), 'Y-m-d H:i:s') . '\' and \'' . date_format(date_create_from_format('d/m/Y H:i:s', $data_final . '23:59:59'), 'Y-m-d H:i:s') . '\'';
            } elseif ($data_inicial) {
                $whereData = 'ticket.data_abertura >= \'' . date_format(date_create_from_format('d/m/Y H:i:s', $data_inicial . '00:00:00'), 'Y-m-d H:i:s') . '\'';
            } elseif ($data_final) {
                $whereData = 'ticket.data_abertura <= \'' . date_format(date_create_from_format('d/m/Y H:i:s', $data_final . '23:59:59'), 'Y-m-d H:i:s') . '\'';
            } else {
                $whereData = '1 = 1'; //busca qualquer coisa
            }

            if ($request->searchField) {

                $ticketStatus = DB::table('ticket_status')
                    ->select('ticket_status.*');

                $tickets = DB::table('tickets')
                    ->select('tickets.*', 'clientes.nome_razao', 'users.name', 'ticket_status.status')
                    ->leftJoin('clientes', 'clientes.id', 'tickets.cliente_id')
                    ->leftJoin('users', 'users.id', 'tickets.user_id')
                    ->leftJoin('ticket_status', 'ticket_status.id', 'tickets.ticket_status_id')
                    ->where('tickets.id', $request->searchField)
                    ->orWhere('clientes.nome_razao', 'like', '%' . $request->searchField . '%')
                    // ->whereRaw('((tickets.tickets_status_id = ' . (isset($request->abast_local) ? $request->abast_local : 1) . ') or (' . (isset($request->abast_local) ? $request->abast_local : 1) . ' = 1))')
                    ->whereRaw($whereData)
                    ->orderBy('id', 'desc')
                    ->paginate();
            } else {

                $ticketStatus = DB::table('ticket_status')
                    ->select('ticket_status.*');

                $tickets = DB::table('tickets')
                    ->select('tickets.*', 'clientes.nome_razao',  'users.name', 'ticket_status.status')
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

            return View('ticket.create')->withClientes($clientes)->withTicketStatus($ticketStatus)
            ->withAtendentes($atendentes);
        } else {
            Session::flash('error', __('messages.access_denied'));
            return redirect()->back();
        }
    }
}
