<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="container-fluid mt-2">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col">
                    <h2 class="">Company Information</h2>
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

            <?php if(validation_errors()): ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <?php echo validation_errors(); ?>
            </div>
            <?php endif; ?>

            <form role="form" action="<?php base_url('company/update') ?>" method="post">

                <div class="form-group">
                    <label for="company_name">Company Name</label>
                    <input type="text" class="form-control form-control-sm" id="company_name" name="company_name" placeholder="Enter company name" value="<?php echo $company_data['company_name'] ?>" autocomplete="off">
                </div>

                <div class="form-group">
                    <label for="service_charge_value">Service Charge if applicable (%)</label>
                    <input type="text" class="form-control form-control-sm" id="service_charge_value" name="service_charge_value" placeholder="Enter service charge amount %" value="<?php echo $company_data['service_charge_value'] ?>" autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="vat_charge_value">GST Charge (%)</label>
                    <input type="text" class="form-control form-control-sm" id="vat_charge_value" name="vat_charge_value" placeholder="Enter GST charge %" value="<?php echo $company_data['vat_charge_value'] ?>" autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" class="form-control form-control-sm" id="address" name="address" placeholder="Enter address" value="<?php echo $company_data['address'] ?>" autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" class="form-control form-control-sm" id="phone" name="phone" placeholder="Enter phone" value="<?php echo $company_data['phone'] ?>" autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="country">Country</label>
                    <input type="text" class="form-control form-control-sm" id="country" name="country" placeholder="Enter country" value="<?php echo $company_data['country'] ?>" autocomplete="off">
                </div>
                <div class="form-group">
                    <label for="permission">Message</label>
                    <textarea class="form-control" id="message" name="message">
                 <?php echo $company_data['message'] ?>
              </textarea>
                </div>
                <div class="form-group">
                    <label for="currency">Currency</label>
                    <?php ?>
                    <select class="form-control form-control-sm" id="currency" name="currency">
                        <option value="">~~SELECT~~</option>

                        <?php foreach ($currency_symbols as $k => $v): ?>
                            <option value="<?php echo trim($k); ?>" <?php if($company_data['currency'] == $k) {
                                echo "selected";
                            } ?>><?php echo $k ?></option>
                        <?php endforeach ?>
                    </select>
                </div>

                <div class="">
                    <button type="submit" class="btn btn-primary btn-sm">Save Changes</button>
                </div>
            </form>

        </div>
    </div>
</div>

<script type="text/javascript">
  $(document).ready(function() {
    $("#companyMainNav").addClass('active');
  });
</script>

