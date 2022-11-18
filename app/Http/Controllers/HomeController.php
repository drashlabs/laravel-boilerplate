<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use App\Models\Task;
class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index()
    {
        return view('home');
      // return redirect()->route('tasks');

    }
    public function GiveMytaskdash()
    {
        return view('my_dash');


    }
}
