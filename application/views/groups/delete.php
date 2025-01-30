<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="container-fluid mt-2">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <h2 class="">Delete Group</h2>
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

            <h1>Do you really want to remove ?</h1>

            <form action="<?php echo base_url('groups/delete/'.$id) ?>" method="post">
                <input type="submit" class="btn btn-primary btn-sm" name="confirm" value="Confirm">
                <a href="<?php echo base_url('groups') ?>" class="btn btn-warning btn-sm">Cancel</a>
            </form>
        </div>
    </div>
</div>

  <script type="text/javascript">
    $(document).ready(function() {
       $("#li-groups").addClass('menu-open');
    $("#link-groups").addClass('active');
    $("#manage-groups").addClass('active');
    });
  </script>  

