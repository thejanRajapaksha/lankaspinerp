<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="container-fluid mt-2">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <h2 class="">Manage Group</h2>
                </div>
                <div class="col">
                    <?php if(in_array('createGroup', $user_permission)): ?>
                        <a href="<?php echo base_url('groups/create') ?>" class="btn btn-primary btn-sm float-right">Add Group</a>
                        <br /> <br />
                    <?php endif; ?>
                </div>
            </div>
            <hr>
            <div id="messages"></div>
            <?php if($this->session->flashdata('success')): ?>
                <div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
            <?php elseif($this->session->flashdata('error')): ?>
                <div class="alert alert-error alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <?php echo $this->session->flashdata('error'); ?>
                </div>
            <?php endif; ?>
            <div class="table-responsive">
                <table id="groupTable" class="table table-sm table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>Group Name</th>
                        <?php if(in_array('updateGroup', $user_permission) || in_array('deleteGroup', $user_permission)): ?>
                            <th>Action</th>
                        <?php endif; ?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if($groups_data): ?>
                        <?php foreach ($groups_data as $k => $v): ?>
                            <tr>
                                <td><?php echo $v['group_name']; ?></td>

                                <?php if(in_array('updateGroup', $user_permission) || in_array('deleteGroup', $user_permission)): ?>
                                    <td>
                                        <?php if(in_array('updateGroup', $user_permission)): ?>
                                            <a href="<?php echo base_url('groups/edit/'.$v['id']) ?>" class="btn btn-default"><i class="text-primary fa fa-edit"></i></a>
                                        <?php endif; ?>
                                        <?php if(in_array('deleteGroup', $user_permission)): ?>
                                            <a href="<?php echo base_url('groups/delete/'.$this->atri->en($v['id'])) ?>" class="btn btn-default"><i class="text-danger fa fa-trash"></i></a>
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
          $('#groups_main_nav_link').prop('aria-expanded', 'true').removeClass('collapsed');
          $('#collapseLayoutsGroups').addClass('show');
          $('#manage_groups_nav_link').addClass('active');

      });
  </script>
