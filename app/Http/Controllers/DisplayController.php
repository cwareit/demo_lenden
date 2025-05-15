<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DisplayController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function display1()
    {
        $this->toggleDisplay('display1');
        return back();
    }

    public function display2()
    {
        $this->toggleDisplay('display2');
        return back();
    }

    public function display3()
    {
        $this->toggleDisplay('display3');
        return back();
    }

    /**
     * Toggle the session value for display
     *
     * @param string $displayKey
     */
    private function toggleDisplay(string $displayKey)
    {
        $currentValue = session($displayKey, false);
        session()->put($displayKey, !$currentValue);
    }
}
