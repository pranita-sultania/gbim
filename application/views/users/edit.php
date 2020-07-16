<div class="row">
    <div class="col-md-8 col-md-offset-5">           
        <h2>Edit User Details
        </h2>
     </div>
</div>
<form method="post" action="<?php echo base_url('users/edit/'.$user['id']);?>">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="form-group">
                <label class="col-md-3">FirstName</label>
                <div class="col-md-9">
                    <input type="text" name="firstName" class="form-control" value="<?php echo $user['firstName']; ?>">
                </div>
            </div>
        </div>
		<div class="col-md-8 col-md-offset-2">
            <div class="form-group">
                <label class="col-md-3">LastName</label>
                <div class="col-md-9">
                    <input type="text" name="lastName" class="form-control" value="<?php echo $user['lastName']; ?>">
                </div>
            </div>
        </div>
       <div class="col-md-8 col-md-offset-2">
            <div class="form-group">
                <label class="col-md-3">Email</label>
                <div class="col-md-9">
                    <input type="email" name="email" class="form-control" required value="<?php echo $user['email']; ?>" readonly>
                </div>
            </div>
        </div>
        <div class="col-md-8 col-md-offset-2">
            <div class="form-group">
                <label class="col-md-3">PhoneNumber</label>
                <div class="col-md-9">
                    <input type="text" name="phoneNumber" max="11" class="form-control" required value="<?php echo $user['phoneNumber']; ?>" readonly>
                </div>
            </div>
        </div>
        <div class="col-md-8 col-md-offset-2">
            <div class="form-group">
                <label class="col-md-3">RoleType</label>
                <div class="col-md-9">
                    <select name="roleType" class="form-control" required>
                        <option value="">Select</option>
                        <?php foreach ($roles as $role) { ?>
                            <option value="<?php echo $role['code']; ?>" <?php echo ($user['roleType'] == $role['code'] ? 'selected' : ''); ?>><?php echo $role['name']; ?></option>        
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <br>
        <div class="col-md-8 col-md-offset-2 pull-right">
            <input type="submit" name="Save" class="btn">
        </div>
    </div>
    
</form>