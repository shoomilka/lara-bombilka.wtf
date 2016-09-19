<!DOCTYPE html>
<html>
    <head>
        <meta content="text/html; charset=utf-8" http-equiv="content-type">
        <title>@yield('title')</title>
        <meta name="keywords" content="">
        <meta name="description" content="">
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
 
		<!-- Bootstrap -->
        <link rel="stylesheet" href="/css/boot.css">
		<link rel="stylesheet" href="/css/comment.css">
		
        <script src="js/jquery-1.11.0.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
        <!-- jQuery & jQuery UI 
		
		
		
        <script src="/js/jquery-1.11.0.min.js"></script>
        <script src="/js/jquery-ui.min.js" type="text/javascript" charset="utf-8"></script>
		
		<script src="/js/bootstrap.min.js"></script>
		<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
		-->
		
        <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!--[if lt IE 9]
        <script src="/js/html5shiv.js"></script>
        <script src="/js/respond.min.js"></script>
        <!--[endif]-->
        
        @yield('headExtra')
    </head>
    <body>
        <div class="navbar navbar-fixed-top navbar-inverse" role="navigation">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="/">bombilka.wtf</a>
                    <a class="navbar-text" href="/post">post</a>
					<a class="navbar-text" href="/best">best</a>
					<a class="navbar-text" href="/bad">bad</a>
                </div>
            </div>
        </div>
        
		<div class="container-fluid">
			<div class="navbar navbar-top" role="navigation">
				<div class="container-fluid">
					<div class="navbar-header">
						<a class="navbar-brand" href="/">bombilka.wtf</a>
						<a class="navbar-text" href="/post">post</a>
					</div>
				</div>
			</div>
			
			@yield('content')
		</div>
			
		<div id="footer" align="center">
			<div class="col-sm-12">
				&copy; 2016 bombilka.wtf
			</div>
		</div>
    </body>
</html>
