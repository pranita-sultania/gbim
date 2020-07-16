<div class="row">
    <div class="col-md-8 col-md-offset-5">           
        <h2>Add User Details
        </h2>
     </div>
</div>
<form method="post" action="<?php echo base_url('users/add');?>">
    <div class="row">
        <?php if(isset($message) && !empty($message)) {
                echo $message;
              }            
        ?>
        <div class="col-md-8 col-md-offset-2">
            <div class="form-group">
                <label class="col-md-3">FirstName</label>
                <div class="col-md-9">
                    <input type="text" name="firstName" max="100" class="form-control" required>
                </div>
            </div>
        </div>
        <div class="col-md-8 col-md-offset-2">
            <div class="form-group">
                <label class="col-md-3">LastName</label>
                <div class="col-md-9">
                    <input type="text" name="lastName" max="100" class="form-control" required>
                </div>
            </div>
        </div>
        <div class="col-md-8 col-md-offset-2">
            <div class="form-group">
                <label class="col-md-3">Email</label>
                <div class="col-md-9">
                    <input type="email" name="email" class="form-control" required>
                </div>
            </div>
        </div>
        <div class="col-md-8 col-md-offset-2">
            <div class="form-group">
                <label class="col-md-3">Password</label>
                <div class="col-md-9">
                    <input type="password" name="password" class="form-control" required>
                </div>
            </div>
        </div>
        <div class="col-md-8 col-md-offset-2">
            <div class="form-group">
                <label class="col-md-3">PhoneNumber</label>
                <div class="col-md-9">
                    <input type="text" name="phoneNumber" max="11" class="form-control" required>
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
                                <option value="<?php echo $role['code']; ?>"><?php echo $role['name']; ?></option>        
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