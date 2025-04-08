<?php

namespace App\Http\Controllers;

use App\TicketPrioridade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class TicketPrioridadeController extends Controller
{
    public $fields = array(
        'id' => 'ID',
        'descricao' => 'Prioridade',
        'ativo' => ['label' => 'Ativo', 'type' => 'bool']
    );

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::user()->canListarTicketPrioridade()) {
            if (isset($request->searchField)) {
                $ticket_prioridade = TicketPrioridade::where('descricao', 'like', '%' . $request->searchField . '%')->paginate();
            } else {
                $ticket_prioridade = TicketPrioridade::paginate();
            }
            return View('ticket_prioridade.index', [
                'ticket_prioridade' => $ticket_prioridade,
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
        if (Auth::user()->canCadastrarTicketPrioridade()) {
            return View('ticket_prioridade.create');
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
      
        if (Auth::user()->canCadastrarTicketPrioridade()) {
            
            $this->validate($request, [
                //'tickets_prioridade_id' => 'required|integer|min:1',
                'descricao' => 'required|unique:ticket_prioridade'
                
            ]);
            try {
                $ticket_prioridade = new TicketPrioridade($request->all());
                
                if ($ticket_prioridade->save()) {
                    Session::flash('success', __('messages.create_success', [
                        'model' => __('models.ticket_prioridade'),
                        'name' => $ticket_prioridade->descricao
                    ]));

                    return redirect()->action('TicketPrioridadeController@index');
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
     * @param  \App\TipoBomba  $tipoBomba
     * @return \Illuminate\Http\Response
     */
    public function edit(TicketPrioridade $ticketPrioridade)
    {
        
        
        if (Auth::user()->canAlterarTicketPrioridade()) {
            return View('ticket_prioridade.edit', [
                'ticket_prioridade' => $ticketPrioridade
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
     * @param  \App\TipoBomba  $tipoBomba
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TicketPrioridade $ticketPrioridade)
    {
        
        if (Auth::user()->canAlterarTicketPrioridade()) {
           // $this->validate($request, [
           //     'descricao' => 'required|string|unique:ticket_prioridade,id,' . $ticketPrioridade->id
           // ]);
          // dd($request);
            try {
                $ticketPrioridade->fill($request->all());
                
           
                if ($ticketPrioridade->save()) {
                    Session::flash('success', __('messages.update_success', [
                        'model' => __('models.ticket_prioridade'),
                        'name' => $ticketPrioridade->descricao
                    ]));

                    return redirect()->action('TicketPrioridadeController@index');
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
     * @param  \App\TipoBomba  $tipoBomba
     * @return \Illuminate\Http\Response
     */
    public function destroy(TicketPrioridade $ticketPrioridade)
    {
        if (Auth::user()->canAlterarTicketPrioridade()) {
            try {
                if ($ticketPrioridade->delete()) {
                    Session::flash('success', __('messages.delete_success', [
                        'model' => __('models.ticket_prioridade'),
                        'name' => $ticketPrioridade->descricao
                    ]));

                    return redirect()->action('TicketPrioridadeController@index');
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
                return redirect()->action('TicketPrioridadeController@index');
            }
        } else {
            Session::flash('error', __('messages.access_denied'));
            return redirect()->back();
        }
    }
}
