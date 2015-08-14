@extends('layouts.default')

@section('content')

<div class="col-lg-12">
    <h3 class="page-header">Email Setting</h3>
</div>
<div class="col-lg-12">
    {!! Form::open(['url' => '/settings/email/create']) !!}
    <div class="row">
        <div class="form-group col-md-6 is-required">
            <label>Sender Name</label>
            <input type="text" class="form-control" name="mail[sender_name]" value="{{ $settingMail ? $settingMail->sender_name : 'Administrator' }}">
        </div>
        <div class="form-group col-md-6 is-required">
            <label>Sender Email</label>
            <input type="email" class="form-control" name="mail[sender_email]" value="{{ $settingMail ? $settingMail->sender_email : 'admin@admin.com' }}">
        </div>
        <div class="form-group col-md-12">
            <label>Mail Method</label>
            <!-- <select class="form-control" name="mail[mail_method]">
                <option value="mail">PHP Mail</option>
                <option value="log">Log</option>
                <option value="smtp">SMTP</option>
                <option value="sendmail">Sendmail</option>
                <option value="mailgun">Mailgun</option>
                <option value="mandrill">Mandrill</option>
            </select> -->
            {!! Form::select('mail[mail_method]', $mailMethodOptions, $settingMail ? $settingMail->mail_method : null , ['class' => 'form-control']) !!}
        </div>
        <!-- SENDMAIL -->
        <div class="form-group col-md-6" data-trigger-action="show" data-trigger='[name="mail[mail_method]"]' data-trigger-condition="value[sendmail]">
            <label>Sendmail path</label>
            <input type="text" class="form-control" name="mail[sendmail_path]" value="{{ $settingMail ? $settingMail->sendmail_path : '/usr/sbin/sendmail -bs' }}">
        </div>
        <!-- SMTP -->
        <div class="form-group col-md-6" data-trigger-action="show" data-trigger='[name="mail[mail_method]"]' data-trigger-condition="value[smtp]">
            <label>SMTP Address</label>
            <input type="text" class="form-control" name="mail[smtp_address]" value="{{ $settingMail ? $settingMail->smtp_address : 'smtp.mailgun.org' }}">
        </div>
        <div class="form-group col-md-12" data-trigger-action="show" data-trigger='[name="mail[mail_method]"]' data-trigger-condition="value[smtp]">
            <div class="checkbox">
                <label>
                    <input type="checkbox" class="form-controls" name="mail[smtp_authorization]" value="1" {{ isset($settingMail->smtp_authorization) ? 'checked' : '' }}>
                    SMTP authorization required
                </label>
            </div>
        </div>
        <div class="form-group col-md-12" data-trigger-action="show" data-trigger='[name="mail[mail_method]"]' data-trigger-condition="value[smtp]">
            <div class="checkbox">
                <label>
                    <input type="checkbox" class="form-controls" name="mail[smtp_ssl]" value="1" {{ isset($settingMail->smtp_ssl) ? 'checked' : '' }}>

                    SSL connection required
                </label>
            </div>
        </div>
        <div class="form-group col-md-6" data-trigger-action="show" data-trigger='[name="mail[mail_method]"]' data-trigger-condition="value[smtp]">
            <label>SMTP Username</label>
            <input type="text" class="form-control" name="mail[smtp_username]" value="{{ $settingMail ? $settingMail->smtp_username : '' }}">
        </div>
        <div class="form-group col-md-6" data-trigger-action="show" data-trigger='[name="mail[mail_method]"]' data-trigger-condition="value[smtp]">
            <label>SMTP Password</label>
            <input type="text" class="form-control" name="mail[smtp_password]" value="{{ $settingMail ? $settingMail->smtp_password : '' }}">
        </div>
        <div class="form-group col-md-6" data-trigger-action="show" data-trigger='[name="mail[mail_method]"]' data-trigger-condition="value[smtp]">
            <label>SMTP Port</label>
            <input type="text" class="form-control" name="mail[smtp_port]" value="{{ $settingMail ? $settingMail->smtp_port : '587' }}">
        </div>
        <!-- MAILGUN -->
        <div class="form-group col-md-6" data-trigger-action="show" data-trigger='[name="mail[mail_method]"]' data-trigger-condition="value[mailgun]">
            <label>Mailgun domain</label>
            <input type="text" class="form-control" name="mail[mailgun_domain]" value="{{ $settingMail ? $settingMail->mailgun_domain : '' }}">
        </div>
        <div class="form-group col-md-6" data-trigger-action="show" data-trigger='[name="mail[mail_method]"]' data-trigger-condition="value[mailgun]">
            <label>Mailgun Secret Key</label>
            <input type="text" class="form-control" name="mail[mailgun_secret]" value="{{ $settingMail ? $settingMail->mailgun_secret : '' }}">
        </div>
        <!-- MANDRILL -->
        <div class="form-group col-md-6" data-trigger-action="show" data-trigger='[name="mail[mail_method]"]' data-trigger-condition="value[mandrill]">
            <label>Mailgun Secret Key</label>
            <input type="text" class="form-control" name="mail[mandrill_secret]" value="{{ $settingMail ? $settingMail->mandrill_secret : '' }}">
        </div>
        <div class="form-group col-md-12">
            <button class="btn btn-primary">Simpan</button>
            <a href="/settings/email/reset" onclick="return confirm('Hapus Setting Email?')" class="btn btn-danger">Reset</a>
        </div>
    </div>
    {!! Form::close() !!}
</div>

@stop
