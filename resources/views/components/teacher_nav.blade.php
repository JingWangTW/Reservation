
<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="/home"> Reservation System </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#teacherNav" aria-controls="teacherNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="teacherNav">
        <ul class="navbar-nav mr-auto">
	     <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#"id="reservation-drop" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Reservation </a>

                <div class="dropdown-menu" aria-labelledby="reservation-drop">
                    <a class="dropdown-item" href="/teacher/new_reservation"> New Reservation </a>
		    <a class="dropdown-item" href="/teacher/schedule" > Reservation List </a>
		    <a class="dropdown-item" href="/teacher/register_assistant" > Register Assistant </a>
                    <a class="dropdown-item" href="/teacher/register_teacher" > Register Teacher</a>
                </div>
	    </li>
	    <li class="nav-item dropdown">
		<a class="nav-link dropdown-toggle" href="#"id="class-drop" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> About Class </a>

                <div class="dropdown-menu" aria-labelledby="class-drop">
                    <a class="dropdown-item" href="/teacher/create_class"> Create Class </a>
                    <a class="dropdown-item" href="/teacher/add_students" > Add Students  </a>
                </div>
	    </li>
        </ul>
        
       <div class='navbar-nav nav-item dropdown mr-5'>
           <a class='nav-link dropdown-toggle' href='/' id='dropdown01' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'> {{ $NAME }}</a>
           <div class='dropdown-menu' aria-labelledby='dropdown01'>
	      <a class='dropdown-item' href='/teacher/change_password'>Change Password</a>
              <a class='dropdown-item' href='/api/logout'>Logout</a>
           </div>
        </div>
        
    </div>
</nav>
