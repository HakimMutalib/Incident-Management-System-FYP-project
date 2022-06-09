<?php

namespace App\Http\Controllers\Tickets;

use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Inertia\Inertia;
use App\Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Notification;
use App\Notifications\TicketNotification;
use App\Notifications\UpdateTicket;
use App\Notifications\DeleteTicket;
use App\Notifications\AdminTicketMake;
use App\Notifications\AdminTicketUpdate;
use Illuminate\Support\Facades\Auth;


class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Tickets/Index',[
            'assignee' => User::where('is_admin', 1)->get(['name']),
            // 'tickets' => Ticket::all(),
            'tickets' => Ticket::latest($column = 'created_at')->paginate(20)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $admin = User::where('is_admin', '=' ,'1')->get();
        $user = Auth::user();
        $ticket = Ticket::create([
            'name' => $request->name,
            'email' => $request->email,
            'description'=>$request->description,
            'category'=>$request->category,
            'priority' =>$request->priority,
            'status' =>$request->status ?? 'In Progress',
            'assignee' =>$request->assignee ?? 'Not Assigned',
        ]);

        Notification::sendNow($admin,new AdminTicketMake($ticket));
        Notification::sendNow($user,new TicketNotification($ticket));



        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Ticket $ticket)
    {

        $admin = User::where('is_admin', '=' ,'1')->get();
        $user = User::where ('email','=',$request->email)->get();

        if ($request->has('name')){
            $ticket->givePermissionTo(collect($request->assignee)->pluck('id')->toArray());
        }
        $ticket->update([
            'assignee' => $request->assignee['name'],
            'status' => $request->status,
        ]);

        Notification::sendNow($admin,new AdminTicketUpdate($ticket));
        Notification::sendNow($user,new UpdateTicket($ticket));
       // $ticket->notify(new UpdateTicket($ticket));


        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $ticket)
    {

        $admin = User::where('is_admin', '=' ,'1')->get();

        $ticket->delete();
        Notification::sendNow($admin,new DeleteTicket($ticket));
        return back();
    }
}
