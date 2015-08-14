<?php

namespace App\Http\Controllers\Setting;

use App;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Setting;
use Flash;

class EmailController extends Controller
{
    protected $request;

    public function __construct(Request $request)
    {
        parent::__construct();

        $this->request = $request;
    }

    public function getIndex()
    {
        if(!$this->hasPermission('setting.email')){
            return  response()->view('errors.401', [], 401);
        }
        Setting::forget('app.name');
        $mailMethodOptions = [
            'log'      => 'Log',
            'mail'     => 'PHP Mail',
            'sendmail' => 'Sendmail',
            'smtp'     => 'SMTP',
            'mailgun'  => 'Mailgun',
            'mandrill' => 'Mandrill',
        ];

        $settingMail = Setting::get('system_mail') !== null ? Setting::get('system_mail') : '';
        return view('setting.email', compact('settingMail', 'mailMethodOptions'));
    }

    public function postCreate()
    {
        $this->validate($this->request, [
            'mail.sender_name' => 'required',
            'mail.sender_email' => 'required',
        ]);

        Setting::set('system_mail', $this->request->get('mail'));
        Flash::success('Setting Email telah di ubah');
        return redirect()->back();
    }

    public function getReset()
    {
        Setting::forget('system_mail');
        Flash::success('Setting Email telah di reset');
        return redirect()->back();
    }
}
