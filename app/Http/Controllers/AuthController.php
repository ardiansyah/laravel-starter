<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Sentinel;

class AuthController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function getLogin()
    {
        return view('login');
    }

    public function postLogin()
    {
        try{
            Sentinel::authenticateAndRemember($this->request->all());

            return redirect('dashboard');

        }catch(\Exception $e){

        }
    }

    public function getLogout()
    {
        Sentinel::logout();

        return redirect('/');
    }
}
