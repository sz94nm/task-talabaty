<?php

namespace App\Http\Controllers;

use App\Events\TicketChanged;
use App\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $tickets = '';
        $status = 'add';
        $role = Auth::user()->role;
        if ($role == 'add') {
            $tickets = Ticket::select('value as ticketAtAdd', 'id')->where('status', 'add')->get();
        } elseif ($role == 'sub') {

            $tickets = DB::table('tickets')
                ->select(DB::raw("value+addition as ticketAtSub ,id"))
                ->where('status', '=', 'sub')
                ->get();
            $status = 'sub';

        } elseif ($role == 'mul') {
            $tickets = DB::table('tickets')
                ->select(("((value+addition )-subtraction as ticketAtMul ,id"))
                ->where('status', '=', 'mul')
                ->get();;
            $status = 'mul';


        } elseif ($role == 'div') {
            $tickets = DB::table('tickets')
                ->select(("(((value+addition )-subtraction)*multiplication as ticketAtDiv ,id"))
                ->where('status', '=', 'div')
                ->get();
            $status = 'div';


        } elseif ($role == 'supervisor') {
            $tickets = Ticket::where('status', '=', 'pending')->get();
        }
        $data = [
            'status' => $status,
            'tickets' => $tickets,
        ];
        return Response::json($data);
    }


    public function getLiveTickets()
    {
        if (Auth::user()->role == 'admin') {
            $tickets = Ticket::where('status', '!=', 'pending')->where('status', '!=', 'archived')->get();
            return Response::json($tickets);
        }
    }

    public function getDoneTickets()
    {
        if (Auth::user()->role == 'admin') {
            $tickets = Ticket::where('status', 'pending')->orwhere('status', 'archived')->get();
            return Response::json($tickets);
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $data = [
            'value' => $request->value
        ];
        $ticket = Ticket::create($data);
        $data = [
            "ticketAtAdd" => $ticket->value,
            "id" => $ticket->id,
        ];
        broadcast(new TicketChanged($data))->toOthers();
        return Response::json($ticket);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Ticket $ticket
     * @return \Illuminate\Http\Response
     */
    public function updateTicket(Request $request)
    {
        $ticket = Ticket::find($request->id);
        $role = Auth::user()->role;
        $status = '';
        switch ($ticket->status) {
            case 'add':
                {
                    if ($role = 'admin' || $role == 'add') {
                        $data = [
                            'status' => 'sub',
                            'addition' => $request->amount,
                        ];
                        $status = "ticketAtSub";
                    }
                }
                break;
            case 'sub':
                {
                    if ($role = 'admin' || $role == 'sub') {
                        $data = [
                            'status' => 'mul',
                            'subtraction' => $request->amount,
                        ];
                        $status = "ticketAtMul";
                    }
                }
                break;
            case 'mul':
                {
                    if ($role = 'admin' || $role == 'mul') {
                        $data = [
                            'status' => 'div',
                            'multiplication' => $request->amount,
                        ];
                        $status = "ticketAtDiv";
                    }
                }
                break;
            case 'div':
                {
                    if ($role = 'admin' || $role == 'div') {
                        $data = [
                            'status' => 'pending',
                            'division' => $request->amount,
                        ];
                        $status = 'pending';
                    }
                }
                break;
            case 'pending':
                {
                    if ($role = 'supervisor') {
                        $data = [
                            'status' => 'archived',
                        ];
                        $status = 'archived';
                    }
                }
                break;
        }

        $ticket->update($data);
        $data = null;
        if ($status == "ticketAtSub") {
            $data = [
                "ticketAtSub" => $ticket->value + $ticket->addition,
                "id" => $ticket->id,
            ];

        }
        elseif ($status == "ticketAtMul") {
            $data = [
                "ticketAtMul" => ($ticket->value + $ticket->addition) - $ticket->subtraction,
                "id" => $ticket->id,
            ];
        }
        elseif ($status == "ticketAtDiv") {
            $data = [
                "ticketAtDiv" => (($ticket->value + $ticket->addition) - $ticket->subtraction) * $ticket->multiplication,
                "id" => $ticket->id,
            ];
        }
        else{
            $data=$ticket;
        }
        if ($role=='admin'){
            $data=$ticket;
        }
        broadcast(new TicketChanged($data))->toOthers();

    }
}
