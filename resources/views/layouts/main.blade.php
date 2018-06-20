<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <link rel="stylesheet" type="text/css" href="/public/css/app.css" />


    <link rel="stylesheet" type="text/css" href="/public/css/reset.css" />
    <link rel="stylesheet" type="text/css" href="/public/css/layout.css" />
    <link rel="stylesheet" type="text/css" href="/public/css/my.css" />
    <link rel="stylesheet" type="text/css" href="/public/css/mydir.css" />



    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" />
    <script type="text/javascript" src="/public/js/all.js"></script>
    <script type="text/javascript" src="/public/js/my.js"></script>
</head>
<body>
<div id="mask"></div>
@section('header')
<div id="container">
    <div id="header"><div class="inner">
            <div class="lSide">
                <a href="/index.php?connect=sites" class="logo">File<span>Base</span>Test</a>
            </div>
            <div class="rSide">

                <a href="#" class="trigger"><!--//--></a>
            </div>
            <div class="clear"><!--//--></div>
        </div></div>
    @show
    @yield('content')

    @section('footer')
    <div id="subfooter"><div class="inner">
            <ul class="grey">
                <li class="reviews"></li>
                <li class="comments"></li>
                <li class="votes"></li>
            </ul>
        </div></div>
    <div id="footer"><div class="inner">
            <p>All Rights Reserved 2018</p>
        </div></div>
    @show
</div>
</body>
</html>