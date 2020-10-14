<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    
        $this->middleare(function($request,$next){
            $out = new \Symfony\Component\Console\Output\ConsoleOutput();
            $out->writeln("Stations:aaa ".Auth::user());   
            $this->user=Auth::user(); // here the user should exist from the session
            return $next($request);
        });
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
}
