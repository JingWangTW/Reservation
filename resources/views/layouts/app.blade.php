<!doctype html>

<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="author" content="Jing, Wang">
        <meta name="theme-color" content="#000000">

        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity=
        "sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">
        
        <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/earlyaccess/notosanstc.css">
        
        @yield('custom_head_file')
        
        <title> @yield('title') - Reservation System </title>
        
        <style>
            
            body {
                padding-top: 5rem;
                font-family: 'Noto Sans TC';
            }
            
            
            @yield('custom_css')
            
        </style>
    </head>
    
    <body>
        
        @yield ('custom_nav')

        <main role="main">
            @yield('content')
        </main>
    
        <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha384-tsQFqpEReu7ZLhBV2VZlAu7zcOV+rXbYlF2cqB8txI/8aZajjp4Bqd+V6D5IgvKT" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js" integrity="sha384-o+RDsa0aLu++PJvFqy8fFScvbHFLtbvScb8AjopnFD+iEQ7wo/CG0xlczd+2O/em" crossorigin="anonymous"></script>
        
        @yield('custom_head_file_body')
        
        <script>
            @yield('custom_js')
        </script>
    </body>

</html>