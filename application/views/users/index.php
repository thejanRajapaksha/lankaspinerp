<div class="container-fluid mt-2">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <h2 class="">Manage Users</h2>
                </div>
                <div class="col">
                    <?php if(in_array('createUser', $user_permission)): ?>
                        <a href="<?php echo base_url('users/create') ?>" class="btn btn-primary btn-sm float-right">Add User</a>
                    <?php endif; ?>
                </div>
            </div>
            <hr>
            <div id="messages"></div>
            <?php if($this->session->success): ?>
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <?php echo $this->session->success; ?>
                    <?php $this->session->unset_userdata('success'); ?>
                </div>
            <?php elseif($this->session->error): ?>
                <div class="alert alert-error alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <?php echo $this->session->error; ?>
                    <?php $this->session->unset_userdata('error'); ?>
                </div>
            <?php endif; ?>
            <div class="table-responsive">
                <table id="userTable" class="table table-hover text-nowrap table-sm">
                    <thead>
                    <tr>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Group</th>

                        <?php if(in_array('updateUser', $user_permission) || in_array('deleteUser', $user_permission)): ?>
                            <th>Action</th>
                        <?php endif; ?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if($user_data): ?>
                        <?php foreach ($user_data as $k => $v): ?>
                            <tr>
                                <td><?php echo $v['user_info']['username']; ?></td>
                                <td><?php echo $v['user_info']['email']; ?></td>
                                <td><?php echo $v['user_info']['firstname'] .' '. $v['user_info']['lastname']; ?></td>
                                <td><?php echo $v['user_info']['phone']; ?></td>
                                <td><?php echo $v['user_group']['group_name']; ?></td>

                                <?php if(in_array('updateUser', $user_permission) || in_array('deleteUser', $user_permission)): ?>

                                    <td>
                                        <?php if(in_array('updateUser', $user_permission)): ?>
                                            <a href="<?php echo base_url('users/edit/'.$v['user_info']['id']) ?>" class="btn btn-default"><i class="text-primary fa fa-edit"></i></a>
                                        <?php endif; ?>
                                        <?php if(in_array('deleteUser', $user_permission)): ?>
                                            <a href="<?php echo base_url('users/delete/'.$this->atri->en($v['user_info']['id'])) ?>" class="text-danger btn btn-default"><i class="fa fa-trash"></i></a>
                                        <?php endif; ?>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

  <script type="text/javascript">
      $(document).ready(function() {
          $('#users_main_nav_link').prop('aria-expanded', 'true').removeClass('collapsed');
          $('#collapseLayoutsUsers').addClass('show');
      });
  </script>
