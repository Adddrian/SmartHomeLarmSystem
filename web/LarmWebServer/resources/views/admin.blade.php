@extends('master')
@section('admin_active')
        active
@stop


@section('main_content')
<meta name="csrf-token" content="{{ Session::token() }}">
<h1 style="text-align: center;"><b>Admin</b></h1>

<div class="col-lg-12">
	<div class="form-panel">
<h4>Create new user</h4>
<hr>
        <form class="form-horizontal" >
                        {!! csrf_field() !!}

                        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Name</label>

                            <div class="col-md-6">
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">E-Mail Address</label>

                            <div class="col-md-6">
                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}">
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Password</label>

                            <div class="col-md-6">
                                <input type="password" id="password1" class="form-control" name="password">
                            </div>
                        </div>

                        <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                            <label class="col-md-4 control-label">Confirm Password</label>

                            <div class="col-md-6">
                                <input type="password" id="password2" class="form-control" name="password_confirmation">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button style="float:left"  type="button" onclick="registerUser()" class="btn btn-primary">
                                    <i class="fa fa-btn fa-user"></i>Register
                                </button><p style="float:left; padding-left:20px" id="newUserSatatus"></p>
                            </div>
                        </div>
        </form>
</div>
</div>


<script>
    function registerUser() {

$.ajax({
    url: "newUser",
    type: 'POST',
    data:  {name:$("#name").attr('value'),email: $("#email").attr('value'), password:$("#password1").attr('value'),password_confirmation:$("#password2").attr('value'), _token:$('meta[name=csrf-token]').attr('content')},
    success: function(data){
        // Success...
	$("#name").val("");
	$("#email").val("");
	$("#password1").val("");
	$("#password2").val("");
        document.getElementById('newUserSatatus').innerText = "Created a new user";
       updateUserManagement();
    },
    error: function(data){
         // Error...
    var errors = $.parseJSON(data.responseText);

    console.log(errors);

    $.each(errors, function(index, value) {
        $.gritter.add({
            title: 'Error',
            text: value
        });
    });
    }
});
    }
</script>

<div class="col-lg-12">

    <section class="task-panel tasks-widget">
        <div class="panel-heading">
            <div class="pull-left"><h4>Manage User</h4></div>
            <br>
        </div>
        <div class="panel-body">
            <div class="task-content">
                <ul class="task-list" id="userManagement">
                </ul>
            </div>

        </div>
    </section>
</div>

<script>
    function updateUserManagement(){
	
$.get( "userManagement", function( data ) {  
document.getElementById('userManagement').innerHTML= data;

});
}

updateUserManagement();

    function removeUser(email) {
        $.get("removeUser/"+email,function(){
       updateUserManagement();
});
    }
</script>


<div class="col-lg-12">

                      <section class="task-panel tasks-widget">
	                	<div class="panel-heading">
	                        <div class="pull-left"><h4>Sensors</h4></div>
	                        <br>
	                 	</div>
                          <div class="panel-body">
                              <div class="task-content">
                                  <ul class="task-list" id="sensorList">
                                  </ul>
                              </div>
<script>
    function removeSensor(id) {
        alert("removeing " + id + "test")
    }

    function getSensors() {
        $.get( "getSensors", function( data ) {
            document.getElementById('sensorList').innerHTML = data;
        })
    }
    getSensors();
</script>
                              <div class=" add-task-row">
				<div>
                    <table><tr>
                            <td>
                                <select>
                                    <option value="tellstick">Tellstick</option>
                                </select>
                            </td>
                            <td>  Token:</td><td><input type="text"></td>
                        </tr></table>
				</div>
                                  <a class="btn btn-success btn-sm pull-left" href="todo_list.html#">Add New Sensor</a>
				               </div>
                          </div>
                      </section>

</div>


@stop
