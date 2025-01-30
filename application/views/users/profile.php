<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="container-fluid mt-2">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <h2 class="">Profile</h2>
                </div>
                <div class="col">
                    <a href="<?php echo base_url('users/setting');?>" class="btn btn-sm btn-primary float-right">Edit Profile</a>
                </div>
            </div>
            <hr>
            <div id="messages"></div>
            <div class="table-responsive">
                <table class="table table-bordered table-condensed table-hovered">
                    <tr>
                        <th>Username</th>
                        <td><?php echo $user_data['username']; ?></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><?php echo $user_data['email']; ?></td>
                    </tr>
                    <tr>
                        <th>First Name</th>
                        <td><?php echo $user_data['firstname']; ?></td>
                    </tr>
                    <tr>
                        <th>Last Name</th>
                        <td><?php echo $user_data['lastname']; ?></td>
                    </tr>
                    <tr>
                        <th>Gender</th>
                        <td><?php echo ($user_data['gender'] == 1) ? 'Male' : 'Gender'; ?></td>
                    </tr>
                    <tr>
                        <th>Phone</th>
                        <td><?php echo $user_data['phone']; ?></td>
                    </tr>
                    <tr>
                        <th>Group</th>
                        <td><span class="label label-info"><?php echo $user_group['group_name']; ?></span></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

  <script type="text/javascript">
    $(document).ready(function() {
      $("#profileMainNav").addClass('active');
    });
  </script>

