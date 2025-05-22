
<main>
    <div class="page-header page-header-light bg-white shadow">
        <div class="container-fluid">
            <div class="page-header-content py-3">
                <h1 class="page-header-title font-weight-light">
                    <div class="page-header-icon"><i class="fas fa-users"></i></div>
                    <span>Cut Type</span>
                </h1>
            </div>
        </div>
    </div>
    <div class="container-fluid mt-2 p-0 p-2">
        <div class="card">
            <div class="card-body p-0 p-2">
                <div class="row">
                    <div class="col-3">
                        <form action="<?php echo base_url() ?>Cuttype/Cuttypeinsertupdate" method="post" autocomplete="off">
                            <div class="form-group mb-1">
                                <label class="small font-weight-bold">Cut Type*</label>
                                <input type="text" class="form-control form-control-sm" name="cuttype" id="cuttype" required>
                            </div>
                            <div class="form-group mt-2 text-right">
                                <?php if (in_array('createCuttype', $user_permission)) : ?>
                                    <button type="submit" id="submitBtn" class="btn btn-primary btn-sm px-4">
                                        <i class="far fa-save"></i>&nbsp;Add 
                                    </button>
                                <?php endif; ?>
                            </div>
                            <input type="hidden" name="recordOption" id="recordOption" value="1">
                            <input type="hidden" name="recordID" id="recordID" value="">
                        </form>
                    </div>
                    <div class="col-9">
                        <div class="scrollbar pb-3" id="style-2">
                            <table class="table table-bordered table-striped table-sm nowrap" id="tblcuttype">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Cut Type</th>
                                        <th class="text-right">Actions</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
