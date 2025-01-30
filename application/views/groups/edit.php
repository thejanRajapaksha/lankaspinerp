<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="container-fluid mt-2">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <h2 class="">Edit Group</h2>
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
            <?php if(validation_errors()){ ?>
                <div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo validation_errors(); ?>

                </div>
            <?php } ?>
            <form role="form" action="<?php base_url('groups/update') ?>" method="post">

                    <div class="form-group">
                        <label for="group_name">Group Name</label>
                        <input type="text" class="form-control form-control-sm" id="group_name" name="group_name" placeholder="Enter group name" value="<?php echo $group_data['group_name']; ?>" autocomplete="off">
                    </div>
                    <div class="form-group">
                        <label for="permission">Permission</label>

                        <?php $serialize_permission = unserialize($group_data['permission']); ?>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                <?php
                                //get permission array 1st array key
                                $permission_keys = array_keys($permissions[0]);
                                ?>
                                <tr>
                                    <?php
                                    foreach ($permission_keys as $pk){
                                        echo "<th>".$pk."</th>";
                                    }
                                    ?>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                foreach ($permissions as $perm) {
                                    echo "<tr>";
                                    //foreach array key value
                                    foreach ($perm as $key => $value) {
                                        //show if key is id
                                        if ($key == 'id') {
                                            echo "<td>".$value."</td>";
                                        }
                                        elseif ($key == 'name') {
                                            echo "<td>".$value."</td>";
                                        }
                                        elseif ($key == 'module') {
                                            echo "<td>".$value."</td>";
                                        }
                                        else{
                                            if($value == 1){
                                                $id = rand();
                                                echo "<td><div class='custom-control custom-switch'><input type='checkbox' name='permission[]'
                                                                                                 class='custom-control-input'
                                                                                                 id='customSwitch".$id."'
                                                                                                 value='".$key.$perm['name']."' ";
                                                                                                 if($serialize_permission) {
                                                                                                     if(in_array($key.$perm['name'], $serialize_permission)) { echo "checked"; }
                                                                                                 }
                                                                                         echo ">
                                                                                                 <label
                                                    class='custom-control-label' for='customSwitch".$id."'>&nbsp;</label></div></td>";
                                            }else{
                                                echo '<td>&nbsp;</td>';
                                            }
                                        }

                                    }

                                    echo "</tr>";
                                }
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                <div class="">
                    <button type="submit" class="btn btn-primary btn-sm">Update Changes</button>
                    <a href="<?php echo base_url('groups/') ?>" class="btn btn-warning btn-sm">Back</a>
                </div>
            </form>
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

