
        <main>
            <div class="page-header page-header-light bg-white shadow">
                <div class="container-fluid">
                    <div class="page-header-content py-3">
                        <h1 class="page-header-title font-weight-bold text-dark">
                            <div class="page-header-icon"><i class="fas fa-quote-left"></i></div>
                            <span>Quotation</span>
                        </h1>
                    </div>
                </div>
            </div>
            <div class="container-fluid mt-2 p-0 p-2">
                <div class="card">
                    <div class="card-body p-0 p-2">
                        <table class="table table-bordered table-striped table-sm nowrap" id="dataTable" style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Date</th>
                                    <th class="d-none"></th>
                                    <th class="text-right">Actions</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="inquirydetail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="page-header-title font-weight-bold">
                    <div class="page-header-icon"><i class="fas fa-address-book"></i> <span>Inquiry Details</span></div>
                </h1>
                <button type="button" class="close" id="closeCC" name="closeCC" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="scrollbar pb-3" id="style-2">
                            <table class="table table-bordered table-striped table-sm nowrap" id="dataTableInquiryDetail" style="width: 100%;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Cloth Type</th>
                                        <th>Meterial Type</th>
                                        <th>Qty</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

