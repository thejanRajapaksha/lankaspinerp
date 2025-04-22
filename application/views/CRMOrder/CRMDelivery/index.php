<style>
  .select2-container {
    width: 260px !important;
  }
</style>
<main>
    <div class="page-header page-header-light bg-white shadow">
        <div class="container-fluid">
            <div class="page-header-content py-3">
                <h1 class="page-header-title font-weight-bold text-dark">
                    <div class="page-header-icon"><i class="fas fa-quote-left"></i></div>
                    <span>Delivery Details</span>
                </h1>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-2 p-0 p-2">
        <div class="card">
            <div class="card-body p-0 p-2">
                <table class="table table-bordered table-striped table-sm nowrap" id="dataTableAccepted" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>Porder Id</th>
                            <th>Customer</th>
                            <th>Order Date</th>
                            <th>Total Quantity</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</main>



<!-- Delivery Plan Modal -->
<div class="modal fade" id="deliveryPlanModal" tabindex="-1" aria-labelledby="deliveryPlanModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Delivery Plan</h5>
        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
      </div>
      <div class="modal-body">
        <form id="deliveryPlanForm" method="post" action="<?= site_url('CRMDeliverydetail/Deliverydetailinsertupdate') ?>">
          <div class="mb-2 text-right">
            <button type="button" class="btn btn-sm btn-primary" id="addDeliveryRow">+ Add Delivery</button>
          </div>

          <table class="table table-bordered table-sm">
            <thead>
              <tr>
                <th>Delivery Date</th>
                <th>Quantity</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody id="deliveryRows"></tbody>
          </table>

          <div class="text-right">
            <input type="hidden" name="inquiryid" id="inquiryid">
            <input type="hidden" name="orderid" id="orderid">
            <button type="submit" class="btn btn-success btn-sm">Save Delivery Plan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- Delivery Detail View Modal -->
<div class="modal fade" id="deliverydetail" tabindex="-1" aria-labelledby="deliverydetailLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deliverydetailLabel">Delivery Plan Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered table-sm" id="deliverydetailtable">
          <thead class="thead-light">
            <tr>
              <!-- <th>#</th> -->
              <th>Dilevary Id</th>
              <th>Delivery Quantity</th>
              <th>Delivery Date</th>
            </tr>
          </thead>
          <tbody>
            <!-- data -->
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

