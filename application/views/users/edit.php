<div class="container-fluid mt-2">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <h2 class="">Edit User</h2>
                </div>
            </div>
            <hr>

            <div class="row">
                <div class="col-md-8">
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
                    <form role="form" action="<?php base_url('users/create') ?>" method="post">

                        <?php if(validation_errors()){ ?>
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><?php echo validation_errors(); ?>
                            </div>
                        <?php } ?>

                        <div class="form-group">
                            <label for="groups">Groups</label>
                            <select class="form-control form-control-sm" id="groups" name="groups" style="width:100%">
                                <option value="">Select Groups</option>
                                <?php foreach ($group_data as $k => $v): ?>
                                    <option value="<?php echo $v['id'] ?>" <?php if($user_group['id'] == $v['id']) { echo 'selected'; } ?> ><?php echo $v['group_name'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control form-control-sm" id="username" name="username" placeholder="Username" value="<?php echo $user_data['username'] ?>" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control form-control-sm" id="email" name="email" placeholder="Email" value="<?php echo $user_data['email'] ?>" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label for="fname">First name</label>
                            <input type="text" class="form-control form-control-sm" id="fname" name="fname" placeholder="First name" value="<?php echo $user_data['firstname'] ?>" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label for="lname">Last name</label>
                            <input type="text" class="form-control form-control-sm" id="lname" name="lname" placeholder="Last name" value="<?php echo $user_data['lastname'] ?>" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" class="form-control form-control-sm" id="phone" name="phone" placeholder="Phone" value="<?php echo $user_data['phone'] ?>" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label for="gender">Gender</label>
                            <div class="radio">
                                <label>
                                    <input type="radio" name="gender" id="male" value="1" <?php if($user_data['gender'] == 1) {
                                        echo "checked";
                                    } ?>>
                                    Male
                                </label>
                                <label>
                                    <input type="radio" name="gender" id="female" value="2" <?php if($user_data['gender'] == 2) {
                                        echo "checked";
                                    } ?>>
                                    Female
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="factory_id">Factory</label>
                            <select class="form-control form-control-sm" id="factory_id" name="factory_id" style="width:100%">
                                <option value="">Select Factory</option>
                                <?php foreach ($factory_data as $k => $v): ?>
                                    <option value="<?php echo $v['id'] ?>" <?php if($user_data['factory_id'] == $v['id']) { echo 'selected'; } ?>><?php echo $v['br_name'] ?></option>
                                <?php endforeach ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <div class="alert alert-info alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                Leave the password field empty if you don't want to change.
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control form-control-sm" id="password" name="password" placeholder="Password" autocomplete="off">
                        </div>

                        <div class="form-group">
                            <label for="cpassword">Confirm password</label>
                            <input type="password" class="form-control form-control-sm" id="cpassword" name="cpassword" placeholder="Confirm Password" autocomplete="off">
                        </div>


                        <div class="">
                            <button type="submit" class="btn btn-primary btn-sm">Save Changes</button>
                            <a href="<?php echo base_url('users/') ?>" class="btn btn-warning btn-sm">Back</a>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>


<script type="text/javascript">
    $(document).ready(function() {
        $('#users_main_nav_link').prop('aria-expanded', 'true').removeClass('collapsed');
        $('#collapseLayoutsUsers').addClass('show');
        $('#manage_users_nav_link').addClass('active');
    });
</script>
