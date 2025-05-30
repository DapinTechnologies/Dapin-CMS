<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Traits\EnvironmentVariable;
use Illuminate\Http\Request;
use App\Models\MailSetting;
use Toastr;

class MailSettingController extends Controller
{
    use EnvironmentVariable;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Module Data
        $this->title = trans_choice('module_mail_setting', 1);
        $this->route = 'admin.mail-setting';
        $this->view = 'admin.mail-setting';
        $this->access = 'setting';


        $this->middleware('permission:'.$this->access.'-mail');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['access'] = $this->access;

        $data['row'] = MailSetting::where('status', '1')->first();

        return view($this->view.'.index', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Field Validation
        $request->validate([
            'driver' => 'required',
            'host' => 'required',
            'port' => 'required',
            'username' => 'required',
            'password' => 'required',
            'encryption' => 'required',
            'sender_email' => 'required|email',
            'sender_name' => 'required',
            // 'reply_email' => 'required|email',
        ]);



        $id = $request->id;

        // -1 means no data row found
        if($id == -1){
            // Insert Data
            $input = $request->all();
            $data = MailSetting::create($input);
        }
        else{
            // Update Data
            $data = MailSetting::find($id);

            $input = $request->all();
            $data->update($input);
        }

        // Update to Env
        $this->updateEnvVariable('MAIL_DRIVER', '"'.$request->driver.'"' ?? '"none"');
        $this->updateEnvVariable('MAIL_HOST', '"'.$request->host.'"' ?? '"none"');
        $this->updateEnvVariable('MAIL_PORT', '"'.$request->port.'"' ?? '"none"');
        $this->updateEnvVariable('MAIL_USERNAME', '"'.$request->username.'"' ?? '"none"');
        $this->updateEnvVariable('MAIL_PASSWORD', '"'.$request->password.'"' ?? '"none"');
        $this->updateEnvVariable('MAIL_ENCRYPTION', '"'.$request->encryption.'"' ?? '"none"');


        Toastr::success(__('msg_updated_successfully'), __('msg_success'));

        return redirect()->back();
    }
}
