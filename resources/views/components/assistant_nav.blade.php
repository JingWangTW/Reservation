
<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="/home"> Reservation System </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#assistantNav" aria-controls="assistantNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="assistantNav">
        <ul class="navbar-nav mr-auto">
            <!--li class="nav-item active">
                <a class="nav-link" href="#">Link</a>
            </li>
            <li class="nav-item">
                <a class="nav-link disabled" href="#">Disabled</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="https://example.com" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
                <div class="dropdown-menu" aria-labelledby="dropdown01">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </li-->
        </ul>
        
       <div class='navbar-nav  nav-item dropdown' style="margin-right: 80px;">
           <a class='nav-link dropdown-toggle' href='/' id='dropdown01' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'> {{ $NAME }}</a>
           <div class='dropdown-menu mr-5' aria-labelledby='dropdown01'>
                <a class='dropdown-item' href='/assistant/edit_profile'>Edit Profile</a>
                <a class='dropdown-item' href='/assistant/change_password'>Change Password</a>
                <a class='dropdown-item' href='/api/logout'>Logout</a>
           </div>
        </div>
        
    </div>
</nav>
