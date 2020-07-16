<div class="row">
    <div class="col-lg-12">           
        <h2>User Details           
            <div class="pull-right">
               <a class="btn btn-primary" href="<?php echo base_url('users/add') ?>"> Add New User Detail</a>
            </div>
        </h2>
     </div>
</div>
<div class="table-responsive">
<h4>Filters</h4>
<input type="text" name="firstName" id="firstName" placeholder="FirstName" onKeyup="applyFilter();"/>
<input type="text" name="lastName" id="lastName" placeholder="LastName" onKeyup="applyFilter();"/>
<input type="text" name="email" id="email" placeholder="Email" onKeyup="applyFilter();"/>
<input type="text" name="phoneNumber" id="phoneNumber" placeholder="PhoneNumber" onKeyup="applyFilter();"/>
<input type="text" name="roleType" id="roleType" placeholder="RoleType" onKeyup="applyFilter();"/>
<!--<button id="search-button" onclick="applyFilter();">Go</button>-->
<div class="clearfix"></div>
<br>
<div id="data-div">
</div>
</div>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script>
applyFilter();
function applyFilter(){
    var data = {
        firstName: $('#firstName').val(),
        lastName: $('#lastName').val(),
        email: $('#email').val(),
        phoneNumber : $('#phoneNumber').val(),
        roleType : $('#roleType').val()
    };
    $.ajax({
        type : 'POST',
        url  : 'users/filter',
        data : data,
        success : function(data){
            $('#data-div').html(data);
        }  
    });
}
</script>