<?php

namespace App\Http\Controllers;

use App\Dashboard;
use App\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function index()
    {
        //dummy
        if (Auth::check()) {
            $role = Auth::user()->role;
        } else {
            $role = 'guest';
        }

        if ($role == 'admin') {
            return view('dashboard.admin');
        } elseif ($role == 'supervisor') {
            return view('dashboard.supervisor');
        } elseif ($role == 'guest') {
            return Response::redirectTo('/');
        } else {
            return view('dashboard.user');
        }
    }


    public
    function operationAccess(Dashboard $operation)
    {
        if ($role = Auth::user()->role == 'admin') {
            return view('dashboard.partial.admin_access');
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public
    function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public
    function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Dashboard $dashboard
     * @return \Illuminate\Http\Response
     */
    public
    function show(Dashboard $dashboard)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Dashboard $dashboard
     * @return \Illuminate\Http\Response
     */
    public
    function edit(Dashboard $dashboard)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Dashboard $dashboard
     * @return \Illuminate\Http\Response
     */
    public
    function update(Request $request, Dashboard $dashboard)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Dashboard $dashboard
     * @return \Illuminate\Http\Response
     */
    public
    function destroy(Dashboard $dashboard)
    {
        //
    }
}
