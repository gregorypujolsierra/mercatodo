<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    /**
     * Show the application dashboard.
     *
     * @param Request $request
     * @return Renderable
     */
    public function index(Request $request)
    {
        if (Gate::denies('is-enabled')) {
            $request->session()->flash('error', 'Your user is disabled. Please contact us: admin@mercatodo.store');
        }

        return view('home');
    }
}
