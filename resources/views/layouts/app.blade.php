<!doctype html>

<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="author" content="Jing, Wang">
        <meta name="keywords" content="Reservation System,Chinese Language Center,CLC,NTOU,NTOU CLC">
        <meta name="google-site-verification" content="Ods78NXwYwcdrG1uVlWcTF0nxJl2as858g8m6mOFiIk" />
        <meta name="msvalidate.01" content="A7CC1E8FDA7058BEAA0230829F6726A1" />

        <meta name="theme-color" content="#000000">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        
        <link rel="stylesheet" type="text/css" href="//stackpath.bootstrapcdn.com/bootstrap/4.1.2/css/bootstrap.min.css" integrity=
        "sha384-Smlep5jCw/wG7hdkwQ/Z5nLIefveQRIY9nfy6xoR1uRYBtpZgI6339F5dgvm/e9B" crossorigin="anonymous">
        
        <link rel="preload" type="text/css" href="//fonts.googleapis.com/earlyaccess/notosanstc.css" as="style" onload="this.rel='stylesheet'">
        
        @yield('custom_head_file')
        
        <title> @yield('title') - Reservation System </title>
        
        <style>
            
            body {
                padding-top: 5rem;
                font-family: 'Noto Sans TC';
            }
            main {
                min-height: 100vh;
            }
            
            
            @yield('custom_css')
            
        </style>
    </head>
    
    <body>
        
        @yield ('custom_nav')

        <main role="main" class="mb-5">
            @yield('content')
        </main>
        <div class="bg-dark text-muted row justify-content-between mx-0">
            <div class="col-md-auto col-sm-12 text-sm-center col-12 px-3 my-2">
                Copyright © {{date('Y')}} All Rights Reserved.
            </div>
            <div class="col-md-auto col-sm-12 text-sm-center col-12 my-2">
                 Build by Jing, Wang.
            </div>
        </div>
    
        <script src="//code.jquery.com/jquery-3.3.1.min.js" integrity="sha384-tsQFqpEReu7ZLhBV2VZlAu7zcOV+rXbYlF2cqB8txI/8aZajjp4Bqd+V6D5IgvKT" crossorigin="anonymous"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="//stackpath.bootstrapcdn.com/bootstrap/4.1.2/js/bootstrap.min.js" integrity="sha384-o+RDsa0aLu++PJvFqy8fFScvbHFLtbvScb8AjopnFD+iEQ7wo/CG0xlczd+2O/em" crossorigin="anonymous"></script>
        
        @yield('custom_head_file_body')
        
        <script>
            @yield('custom_js')
        </script>
    </body>

</html>
