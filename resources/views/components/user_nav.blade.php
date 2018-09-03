
<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="/home"> Reservation System </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#userNav" aria-controls="userNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="userNav">
        <ul class="navbar-nav mr-auto">
            
        </ul>
        
        <form class='form-inline my-2 my-lg-0' action='/api/login' method='post'>
            <input class='form-control mr-sm-2' name='account' type='text' placeholder='Account' required>
            <input class='form-control mr-sm-2' name='password' type='password' placeholder='Password' required>
            <button class='btn btn-outline-primary my-2 my-sm-0' type='submit'>Login</button>
            <a class='btn btn-outline-success ml-1 my-2 my-sm-0' href="/forget"> Forget </a>
        </form>
        
    </div>
</nav>