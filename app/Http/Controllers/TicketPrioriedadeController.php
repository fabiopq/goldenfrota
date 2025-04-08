<?php

namespace App\Http\Controllers;

use App\TicketPrioriedade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class TicketPrioriedadeController extends Controller
{
    public $fields = array(
        'id' => 'ID',
        'descricao' => 'Prioriedade',
        'ativo' => ['label' => 'Ativo', 'type' => 'bool']
    );

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::user()->canListarTicketPrioriedade()) {
            if (isset($request->searchField)) {
                $ticket_prioriedade = TicketPrioriedade::where('descricao', 'like', '%' . $request->searchField . '%')->paginate();
            } else {
                $ticket_prioriedade = TicketPrioriedade::paginate();
            }
            return View('ticket_prioriedade.index', [
                'ticket_prioriedade' => $ticket_prioriedade,
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
        if (Auth::user()->canCadastrarTicketPrioriedade()) {
            return View('ticket_prioriedade.create');
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
      
        if (Auth::user()->canCadastrarTicketPrioriedade()) {
            
            $this->validate($request, [
                //'tickets_prioridade_id' => 'required|integer|min:1',
                'descricao' => 'required|unique:ticket_prioridade'
                
            ]);
            try {
                $ticket_prioriedade = new TicketPrioriedade($request->all());
                
                if ($ticket_prioriedade->save()) {
                    Session::flash('success', __('messages.create_success', [
                        'model' => __('models.ticket_prioriedade'),
                        'name' => $ticket_prioriedade->descricao
                    ]));

                    return redirect()->action('TicketPrioriedadeController@index');
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
    public function edit(TicketPrioriedade $ticketPrioriedade)
    {
        
        
        if (Auth::user()->canAlterarTicketPrioriedade()) {
            return View('ticket_prioriedade.edit', [
                'ticket_prioriedade' => $ticketPrioriedade
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
    public function update(Request $request, TicketPrioriedade $ticketPrioridade)
    {
        
        if (Auth::user()->canAlterarTicketPrioriedade()) {
           // $this->validate($request, [
           //     'descricao' => 'required|string|unique:ticket_prioridade,id,' . $ticketPrioridade->id
           // ]);
          // dd($request);
            try {
                $ticketPrioridade->fill($request->all());
                
           
                if ($ticketPrioridade->save()) {
                    Session::flash('success', __('messages.update_success', [
                        'model' => __('models.ticket_prioriedade'),
                        'name' => $ticketPrioridade->descricao
                    ]));

                    return redirect()->action('TicketPrioriedadeController@index');
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
    public function destroy(TicketPrioriedade $ticketPrioridade)
    {
        if (Auth::user()->canAlterarTicketPrioriedade()) {
            try {
                if ($ticketPrioridade->delete()) {
                    Session::flash('success', __('messages.delete_success', [
                        'model' => __('models.ticket_prioriedade'),
                        'name' => $ticketPrioridade->descricao
                    ]));

                    return redirect()->action('TicketPrioriedadeController@index');
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
                return redirect()->action('TicketPrioriedadeController@index');
            }
        } else {
            Session::flash('error', __('messages.access_denied'));
            return redirect()->back();
        }
    }
}
