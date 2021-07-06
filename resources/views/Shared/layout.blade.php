<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="description" content="">
        <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
        <meta name="generator" content="Jekyll v3.8.5">
        <title>@yield('title')</title>
        <!-- Bootstrap core CSS -->
        <link href="/css/bootstrap.min.css" rel="stylesheet">
        <!---->
        <link href="https://cdn.jsdelivr.net/npm/sweetalert2@8.10.0/dist/sweetalert2.min.css" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="/css/app.css" rel="stylesheet">
        <!---->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css" integrity="sha384-50oBUHEmvpQ+1lW4y57PTFmhCaXp0ML5d60M1M7uH2+nqUivzIebhndOJK28anvf" crossorigin="anonymous">
        <!---->
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.18/datatables.min.css"/>
        <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/b-1.5.6/b-colvis-1.5.6/b-flash-1.5.6/b-html5-1.5.6/datatables.min.css"/>
        <style type="text/css">

        </style>

      </head>
    <body>
        <script src="/js/jquery-3.4.1.min.js"></script>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script src="/js/bootstrap.bundle.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/feather-icons/4.9.0/feather.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
        <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.18/b-1.5.6/b-colvis-1.5.6/b-flash-1.5.6/b-html5-1.5.6/datatables.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8.10.0/dist/sweetalert2.all.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/promise-polyfill@7.1.0/dist/promise.min.js"></script>
        <script src="/js/app.js"></script>
        @include('Shared.navbar')
        <div class="container-fluid">
            @yield('content')
        </div>
        <script type="text/javascript">
            $(document).ready(function(){
                console.log($(window).width());

                if($(window).width()<738){
                    $('#navbar-toggler-button').show();
                    $('#sidebar-left').removeClass('col-md-2');
                    $('#sidebar-left').css({'overflow-y': 'visible'});
                    $('#navbarSupportedContent').removeClass('show');
                    $('#sidebar-left').addClass('mt-5');
                    $('.sidebar-sticky').addClass('mt-3');
                }else{
                    $('#navbar-toggler-button').hide();
                }
            });
        </script>
    </body>
</html>
