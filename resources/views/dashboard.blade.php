@extends('layouts.default')

@section('content')

{{ dump(Navigation::render()) }}

{{ dump(NavigationSetting::render()) }}

@stop
