<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>My Starter</title>

    <!-- Bootstrap Core CSS -->
    <link href="/vendor/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- MetisMenu CSS -->
    <link href="/vendor/metisMenu/dist/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="/css/sb-admin-2.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
    <!-- <link href="/css/build.css" rel="stylesheet"> -->

    <!-- Custom Fonts -->


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        @include('partials.nav')

        <!-- Page Content -->
        <div id="page-wrapper">
            <div class="container-fluid">
                <div class="row">
                    @yield('content')
                    <!-- /.col-lg-12 -->
                </div>
                <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    @if (count($errors) > 0)
        <p data-control="flash-message" class="error" data-interval="5">{{ $errors->all()[0]}}</p>
    @endif
    @if (Session::has('flash_notification.message'))
        <p data-control="flash-message" class="{{ Session::get('flash_notification.level') }}" data-interval="5">{{ Session::get('flash_notification.message') }}</p>
    @endif

    <script src="/vendor/jquery/dist/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="/vendor/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Metis Menu Plugin JavaScript -->
    <script src="/vendor/metisMenu/dist/metisMenu.min.js"></script>

    <!-- Custom Theme JavaScript -->
    <script src="/js/sb-admin-2.js"></script>
    <script src="/js/checkbox.balloon.js"></script>
    <script src="/js/flashmessage.js"></script>
    <script src="/js/input.trigger.js"></script>

</body>

</html>
