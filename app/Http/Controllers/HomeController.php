<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stakeholder;
use App\Models\Transaction;

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
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()


    {

        return redirect()
        ->route('stakeholders');

        // $stakeholders = Stakeholder::orderBy('id', 'desc')->get();

        // foreach ($stakeholders as $stakeholder) {
        //     $total = Transaction::where('stakeholderId', $stakeholder->id)->sum('amount');
        //     $stakeholder->total = $total;  
        // }
        // return view('home', [
        //     'stakeholders' => $stakeholders
        // ]);
    }
}
