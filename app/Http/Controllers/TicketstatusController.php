<?php
namespace App\Http\Controllers;

use App\TicketStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class TicketstatusController extends Controller
{
    public $fields = array(
        'id' => 'ID',
        'descricao' => 'Status',
        'ativo' => ['label' => 'Ativo', 'type' => 'bool']
    );

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::user()->canListarTicketStatus()) {
            if (isset($request->searchField)) {
                $ticket_status = TicketStatus::where('descricao', 'like', '%' . $request->searchField . '%')->paginate();
            } else {
                $ticket_status = TicketStatus::paginate();
            }
            return View('ticket_status.index', [
                'ticket_status' => $ticket_status,
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
        if (Auth::user()->canCadastrarTicketStatus()) {
            return View('ticket_status.create');
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
      
        if (Auth::user()->canCadastrarTicketStatus()) {
            
            $this->validate($request, [
                //'tickets_Status_id' => 'required|integer|min:1',
                'descricao' => 'required|unique:ticket_status'
                
            ]);
            try {
                $ticket_status = new TicketStatus($request->all());
                
                if ($ticket_status->save()) {
                    Session::flash('success', __('messages.create_success', [
                        'model' => __('models.ticket_status'),
                        'name' => $ticket_status->descricao
                    ]));

                    return redirect()->action('TicketStatusController@index');
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
    public function edit(TicketStatus $ticketStatus)
    {
        
        
        if (Auth::user()->canAlterarTicketStatus()) {
            return View('ticket_status.edit', [
                'ticket_status' => $ticketStatus
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
    public function update(Request $request, TicketStatus $ticketStatus)
    {
        
        if (Auth::user()->canAlterarTicketStatus()) {
           // $this->validate($request, [
           //     'descricao' => 'required|string|unique:ticket_Status,id,' . $ticketStatus->id
           // ]);
          // dd($request);
            try {
                $ticketStatus->fill($request->all());
                
           
                if ($ticketStatus->save()) {
                    Session::flash('success', __('messages.update_success', [
                        'model' => __('models.ticket_status'),
                        'name' => $ticketStatus->descricao
                    ]));

                    return redirect()->action('TicketStatusController@index');
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
    public function destroy(TicketStatus $ticketStatus)
    {
        if (Auth::user()->canAlterarTicketStatus()) {
            try {
                if ($ticketStatus->delete()) {
                    Session::flash('success', __('messages.delete_success', [
                        'model' => __('models.ticket_status'),
                        'name' => $ticketStatus->descricao
                    ]));

                    return redirect()->action('TicketStatusController@index');
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
                return redirect()->action('TicketStatusController@index');
            }
        } else {
            Session::flash('error', __('messages.access_denied'));
            return redirect()->back();
        }
    }

}
