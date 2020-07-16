<table class="table table-bordered">
  <thead>
      <tr>
          <th>FirstName</th>
          <th>LastName</th>
          <th>Email</th>
          <th>PhoneNumber</th>
          <th>RoleType</th>
          <th>Status</th>
          <th>Action</th>
      </tr>
  </thead>
  <tbody>
   <?php foreach ($data as $user) { ?>      
      <tr>
          <td><?php echo $user['firstName']; ?></td>
          <td><?php echo $user['lastName']; ?></td>
          <td><?php echo $user['email']; ?></td>
          <td><?php echo $user['phoneNumber']; ?></td>
          <td><?php echo $user['roleType']; ?></td>
          <td><?php echo $user['isActive'] ? 'Active' : 'Inactive'; ?></td>
      <td>
          <?php if($user['isActive']) { ?>
        <form method="DELETE" action="<?php echo base_url('users/delete/'.$user['id']);?>">
         <a class="btn btn-info btn-xs" href="<?php echo base_url('users/edit/'.$user['id']) ?>"><i class="glyphicon glyphicon-pencil"></i></a>
          <button type="submit" class="btn btn-danger btn-xs"><i class="glyphicon glyphicon-remove"></i></button>
        </form>
          <?php } ?>
      </td>     
      </tr>
      <?php } if(empty($data)) { ?>
        <tr><td colspan="6">No Record Found</td></tr>
      <?php } ?>
  </tbody>
</table>