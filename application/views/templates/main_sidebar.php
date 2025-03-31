<div id="layoutSidenav_nav">
    <nav class="sidenav shadow-right sidenav-light">
        <div class="sidenav-menu">
            <div class="nav accordion" id="accordionSidenav">
                <div class="sidenav-menu-heading">Core</div>

                <?php if ($user_permission) : ?>

                    <?php if (
                    in_array('viewMachineDashboard', $user_permission)
                    ) : ?>
                        <a class="nav-link" href="<?php echo base_url('MachineDashboard/'); ?>">
                            <div class="nav-link-icon"><i class="fas fa-tools" ></i></div>
                            Machine Dashboard
                        </a>
                    <?php endif; ?>

                <?php endif; ?>

                <?php if (
                        in_array('createMachineType', $user_permission)
                        || in_array('updateMachineType', $user_permission)
                        || in_array('viewMachineType', $user_permission)
                        || in_array('deleteMachineType', $user_permission)

                        || in_array('createMachineModel', $user_permission)
                        || in_array('updateMachineModel', $user_permission)
                        || in_array('viewMachineModel', $user_permission)
                        || in_array('deleteMachineModel', $user_permission)

                        || in_array('createMachineBrand', $user_permission)
                        || in_array('updateMachineBrand', $user_permission)
                        || in_array('viewMachineBrand', $user_permission)
                        || in_array('deleteMachineBrand', $user_permission)

                        || in_array('createMachineIn', $user_permission)
                        || in_array('updateMachineIn', $user_permission)
                        || in_array('viewMachineIn', $user_permission)
                        || in_array('deleteMachineIn', $user_permission)

                        || in_array('createOperationsForMachine', $user_permission)
                        || in_array('updateOperationsForMachine', $user_permission)
                        || in_array('viewOperationsForMachine', $user_permission)
                        || in_array('deleteOperationsForMachine', $user_permission)

                        || in_array('createMachineOperation', $user_permission)
                        || in_array('updateMachineOperation', $user_permission)
                        || in_array('viewMachineOperation', $user_permission)
                        || in_array('deleteMachineOperation', $user_permission)

                        || in_array('viewMachineScan', $user_permission)

                    ) : ?>

                        <a class="nav-link collapsed" id="machines_main_nav_link" href="javascript:void(0);" data-toggle="collapse" data-target="#collapseLayoutsMachines" aria-expanded="false" aria-controls="collapseLayoutsMachines">
                            <div class="nav-link-icon"><i class="fas fa-tools "></i></div>
                            Machine
                            <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayoutsMachines" data-parent="#accordionSidenav">
                            <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavLayoutMachines">

                                <?php if (
                                    in_array('createMachineType', $user_permission)
                                    || in_array('updateMachineType', $user_permission)
                                    || in_array('viewMachineType', $user_permission)
                                    || in_array('deleteMachineType', $user_permission)
                                ) : ?>
                                    <a class="nav-link p-0 px-3 py-1" href="<?php echo base_url('MachineTypes/'); ?>">Machine Types</a>
                                <?php endif; ?>

                                <?php if (
                                    in_array('createMachineModel', $user_permission)
                                    || in_array('updateMachineModel', $user_permission)
                                    || in_array('viewMachineModel', $user_permission)
                                    || in_array('deleteMachineModel', $user_permission)
                                ) : ?>
                                    <a class="nav-link p-0 px-3 py-1" href="<?php echo base_url('MachineModels/'); ?>">Machine Models</a>
                                <?php endif; ?>

                                <?php if (
                                    in_array('createMachineBrand', $user_permission)
                                    || in_array('updateMachineBrand', $user_permission)
                                    || in_array('viewMachineBrand', $user_permission)
                                    || in_array('deleteMachineBrand', $user_permission)
                                ) : ?>
                                    <a class="nav-link p-0 px-3 py-1" href="<?php echo base_url('MachineBrands/'); ?>">Machine Brands</a>
                                <?php endif; ?>

                                <?php if (
                                    in_array('createMachineIn', $user_permission)
                                    || in_array('updateMachineIn', $user_permission)
                                    || in_array('viewMachineIn', $user_permission)
                                    || in_array('deleteMachineIn', $user_permission)
                                ) : ?>
                                    <a class="nav-link p-0 px-3 py-1" href="<?php echo base_url('MachineIns/'); ?>">Machine In</a>
                                <?php endif; ?>

                            </nav>
                        </div>

                    <?php endif; ?>

                <?php if (
                in_array('viewSparePart', $user_permission)
                ) : ?>
                    <a class="nav-link" href="<?php echo base_url('SpareParts/'); ?>">
                        <div class="nav-link-icon"><i class="fas fa-wrench "></i></div>
                        Spare Parts
                    </a>
                <?php endif; ?>

                <?php if (
                    in_array('createMachineService', $user_permission)
                    || in_array('updateMachineService', $user_permission)
                    || in_array('viewMachineService', $user_permission)
                    || in_array('deleteMachineService', $user_permission)
                ) : ?>

                    <a class="nav-link collapsed" id="machine_services_main_nav_link" href="javascript:void(0);" data-toggle="collapse" data-target="#collapseLayoutsMachineServices" aria-expanded="false" aria-controls="collapseLayoutsMachineServices">
                        <div class="nav-link-icon"><i class="fas fa-tools "></i></div>Machine Services
                        <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseLayoutsMachineServices" data-parent="#accordionSidenav">
                        <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavLayoutMachineServices">

                            <?php if (
                                in_array('createMachineService', $user_permission)
                                || in_array('updateMachineService', $user_permission)
                                || in_array('viewMachineService', $user_permission)
                                || in_array('deleteMachineService', $user_permission)
                            ) : ?>
                                <a class="nav-link p-0 px-3 py-1" href="<?php echo base_url('MachineServices/'); ?>">Machine Service </a>
                            <?php endif; ?>

                            <?php if (
                                in_array('createMachineServiceItemAllocate', $user_permission)
                                || in_array('updateMachineServiceItemAllocate', $user_permission)
                                || in_array('viewMachineServiceItemAllocate', $user_permission)
                                || in_array('deleteMachineServiceItemAllocate', $user_permission)
                            ) : ?>
                                <a class="nav-link p-0 px-3 py-1" href="<?php echo base_url('MachineServices/allocate'); ?>">Service Item Allocate </a>
                            <?php endif; ?>

                            <?php if (
                                in_array('createMachineServiceItemIssue', $user_permission)
                                || in_array('updateMachineServiceItemIssue', $user_permission)
                                || in_array('viewMachineServiceItemIssue', $user_permission)
                                || in_array('deleteMachineServiceItemIssue', $user_permission)
                            ) : ?>
                                <a class="nav-link p-0 px-3 py-1" href="<?php echo base_url('MachineServices/issue'); ?>">Service Item Issue </a>
                            <?php endif; ?>

                            <?php if (
                                in_array('createMachineServiceItemReceive', $user_permission)
                                || in_array('updateMachineServiceItemReceive', $user_permission)
                                || in_array('viewMachineServiceItemReceive', $user_permission)
                                || in_array('deleteMachineServiceItemReceive', $user_permission)
                            ) : ?>
                                <a class="nav-link p-0 px-3 py-1" href="<?php echo base_url('MachineServices/receive'); ?>">Service Item Receive </a>
                            <?php endif; ?>

                            <?php if (
                                in_array('createMachineService', $user_permission)
                                || in_array('updateMachineService', $user_permission)
                                || in_array('viewMachineService', $user_permission)
                                || in_array('deleteMachineService', $user_permission)
                            ) : ?>
                                <a class="nav-link p-0 px-3 py-1" href="<?php echo base_url('MachineServicesCalendar/'); ?>">Service Calendar</a>
                            <?php endif; ?>

                        </nav>
                    </div>

                <?php endif; ?>

                <?php if (
                        in_array('createMachineRepairRequest', $user_permission)
                        || in_array('updateMachineRepairRequest', $user_permission)
                        || in_array('viewMachineRepairRequest', $user_permission)
                        || in_array('deleteMachineRepairRequest', $user_permission)
                    ) : ?>

                        <a class="nav-link collapsed" id="machine_repair_main_nav_link" href="javascript:void(0);" data-toggle="collapse" data-target="#collapseLayoutsMachineRepairs" aria-expanded="false" aria-controls="collapseLayoutsMachineRepairRequests">
                            <div class="nav-link-icon"><i class="fas fa-tools "></i></div>Machine Repairs
                            <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayoutsMachineRepairs" data-parent="#accordionSidenav">
                            <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavLayoutMachineRepairs">

                                <?php if (
                                    in_array('createMachineRepairRequest', $user_permission)
                                    || in_array('updateMachineRepairRequest', $user_permission)
                                    || in_array('viewMachineRepairRequest', $user_permission)
                                    || in_array('deleteMachineRepairRequest', $user_permission)
                                ) : ?>
                                    <a class="nav-link p-0 px-3 py-1" href="<?php echo base_url('MachineRepairRequests/'); ?>">Machine Repair Requests </a>
                                <?php endif; ?>


                            </nav>
                        </div>

                    <?php endif; ?>

                <?php if (
                    in_array('viewPurchaseOrder', $user_permission)
                    || in_array('createPurchaseOrderApprove', $user_permission)
                ) : ?>

                    <a class="nav-link collapsed" id="po_main_nav_link" href="javascript:void(0);" data-toggle="collapse" data-target="#collapseLayoutsPo" aria-expanded="false" aria-controls="collapseLayoutsPo">
                        <div class="nav-link-icon"><i class="fas fa-tools "></i></div>Purchase Order
                        <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseLayoutsPo" data-parent="#accordionSidenav">
                        <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavLayoutPo">

                            <?php if (
                            in_array('viewPurchaseOrder', $user_permission)
                            ) : ?>
                                <a class="nav-link p-0 px-3 py-1" href="<?php echo base_url('Purchaseorder/'); ?>">Purchase Order</a>
                            <?php endif; ?>

                            <?php if (
                            in_array('createPurchaseOrderApprove', $user_permission)
                            ) : ?>
                                <a class="nav-link p-0 px-3 py-1" href="<?php echo base_url('Purchaseorder/approve_front'); ?>">Purchase Order Approve</a>
                            <?php endif; ?>

                        </nav>
                    </div>

                <?php endif; ?>

                <?php if (
                    in_array('viewGRN', $user_permission)
                    || in_array('createGRNApprove', $user_permission)
                ) : ?>

                    <a class="nav-link collapsed" id="grn_main_nav_link" href="javascript:void(0);" data-toggle="collapse" data-target="#collapseLayoutsGRN" aria-expanded="false" aria-controls="collapseLayoutsGRN">
                        <div class="nav-link-icon"><i class="fas fa-tools "></i></div>Good Receive Note
                        <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseLayoutsGRN" data-parent="#accordionSidenav">
                        <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavLayoutGRN">

                            <?php if (
                            in_array('viewGRN', $user_permission)
                            ) : ?>
                                <a class="nav-link p-0 px-3 py-1" href="<?php echo base_url('Goodreceive/'); ?>">Good Receive Note</a>
                            <?php endif; ?>

                            <?php if (
                            in_array('createGRNApprove', $user_permission)
                            ) : ?>
                                <a class="nav-link p-0 px-3 py-1" href="<?php echo base_url('Goodreceive/approve_front'); ?>">GRN Approve</a>
                            <?php endif; ?>

                        </nav>
                    </div>

                <?php endif; ?>

                <?php if (
                    in_array('viewCRMInquiry', $user_permission) ||
                    in_array('createCRMInquiry', $user_permission) ||
                    in_array('updateCRMInquiry', $user_permission) ||
                    in_array('deleteCRMInquiry', $user_permission) ||

                    in_array('viewCRMQuotation', $user_permission) ||
                    in_array('createCRMQuotation', $user_permission) ||
                    in_array('updateCRMQuotation', $user_permission) ||
                    in_array('deleteCRMQuotation', $user_permission) ||

                    in_array('viewCRMQuotationform', $user_permission) ||
                    in_array('createCRMQuotationform', $user_permission) ||
                    in_array('updateCRMQuotationform', $user_permission) ||
                    in_array('deleteCRMQuotationform', $user_permission) ||

                    in_array('viewCRMQuotationStatus', $user_permission) ||
                    in_array('createCRMQuotationStatus', $user_permission) ||
                    in_array('updateCRMQuotationStatus', $user_permission) ||
                    in_array('deleteCRMQuotationStatus', $user_permission) ||

                    in_array('viewCRMReason', $user_permission) ||
                    in_array('createCRMReason', $user_permission) ||
                    in_array('updateCRMReason', $user_permission) ||
                    in_array('deleteCRMReason', $user_permission)
                ) : ?>

                    <a class="nav-link collapsed" id="crm_main_nav_link" href="javascript:void(0);" data-toggle="collapse" data-target="#collapseCRM" aria-expanded="false" aria-controls="collapseCRM">
                        <div class="nav-link-icon"><i class="fas fa-user-tie"></i></div>CRM
                        <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseCRM" data-parent="#accordionSidenav">
                        <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavCRM">

                            <?php if (
                                in_array('viewCRMInquiry', $user_permission) ||
                                in_array('createCRMInquiry', $user_permission) ||
                                in_array('updateCRMInquiry', $user_permission) ||
                                in_array('deleteCRMInquiry', $user_permission)
                            ) : ?>
                                <a class="nav-link p-0 px-3 py-1" href="<?php echo base_url('CRMInquiry/'); ?>">CRM Inquiry</a>
                            <?php endif; ?>

                            <?php if (
                                in_array('viewCRMQuotationform', $user_permission) ||
                                in_array('createCRMQuotationform', $user_permission) ||
                                in_array('updateCRMQuotationform', $user_permission) ||
                                in_array('deleteCRMQuotationform', $user_permission) ||
                                
                                in_array('viewCRMQuotation', $user_permission) ||
                                in_array('createCRMQuotation', $user_permission) ||
                                in_array('updateCRMQuotation', $user_permission) ||
                                in_array('deleteCRMQuotation', $user_permission)
                            ) : ?>
                                <a class="nav-link p-0 px-3 py-1" href="<?php echo base_url('CRMQuotation/'); ?>">CRM Quotation</a>
                            <?php endif; ?>

                            <?php if (
                                in_array('viewCRMQuotationStatus', $user_permission) ||
                                in_array('createCRMQuotationStatus', $user_permission) ||
                                in_array('updateCRMQuotationStatus', $user_permission) ||
                                in_array('deleteCRMQuotationStatus', $user_permission)
                            ) : ?>
                                <a class="nav-link p-0 px-3 py-1" href="<?php echo base_url('CRMQuotationStatus/'); ?>">CRM QuotationStatus</a>
                            <?php endif; ?>

                            <?php if (
                                in_array('viewCRMReason', $user_permission) ||
                                in_array('createCRMReason', $user_permission) ||
                                in_array('updateCRMReason', $user_permission) ||
                                in_array('deleteCRMReason', $user_permission)
                            ) : ?>
                                <a class="nav-link p-0 px-3 py-1" href="<?php echo base_url('CRMReason/'); ?>">CRM Reason</a>
                            <?php endif; ?>

                        </nav>
                    </div>

                <?php endif; ?>

                <?php if (
                    in_array('viewCRMOrderdetail', $user_permission)   ||
                    in_array('createCRMOrderdetail', $user_permission) ||
                    in_array('updateCRMOrderdetail', $user_permission) ||
                    in_array('deleteCRMOrderdetail', $user_permission) ||

                    // in_array('viewCRMMaterialdetail', $user_permission)   ||
                    // in_array('createCRMMaterialdetail', $user_permission) ||
                    // in_array('updateCRMMaterialdetail', $user_permission) ||
                    // in_array('deleteCRMMaterialdetail', $user_permission) ||

                    in_array('viewCRMPrintingdetail', $user_permission)   ||
                    in_array('createCRMPrintingdetail', $user_permission) ||
                    in_array('updateCRMPrintingdetail', $user_permission) ||
                    in_array('deleteCRMPrintingdetail', $user_permission) ||

                    in_array('viewCRMDeliverydetail', $user_permission)   ||
                    in_array('createCRMDeliverydetail', $user_permission) ||
                    in_array('updateCRMDeliverydetail', $user_permission) ||
                    in_array('deleteCRMDeliverydetail', $user_permission) ||

                    in_array('viewCRMCompletedorder', $user_permission)   ||
                    in_array('createCRMCompletedorder', $user_permission) ||
                    in_array('updateCRMCompletedorder', $user_permission) ||
                    in_array('deleteCRMCompletedorder', $user_permission) ||

                    in_array('viewMachineallocation', $user_permission)   ||
                    in_array('createMachineallocation', $user_permission) ||
                    in_array('updateMachineallocation', $user_permission) ||
                    in_array('deleteMachineallocation', $user_permission)
                ) : ?>

                    <a class="nav-link collapsed" id="crmorder_main_nav_link" href="javascript:void(0);" data-toggle="collapse" data-target="#collapseCRMOrder" aria-expanded="false" aria-controls="collapseCRMOrder">
                        <div class="nav-link-icon"><i class="fas fa-user-tie"></i></div>CRM Order
                        <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseCRMOrder" data-parent="#accordionSidenav">
                        <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavCRMOrder">

                            <?php if (
                                in_array('viewCRMOrderdetail', $user_permission) ||
                                in_array('createCRMOrderdetail', $user_permission) ||
                                in_array('updateCRMOrderdetail', $user_permission) ||
                                in_array('deleteCRMOrderdetail', $user_permission)
                            ) : ?>
                                <a class="nav-link p-0 px-3 py-1" href="<?php echo base_url('CRMOrderdetail/'); ?>">Order detail</a>
                            <?php endif; ?>

                            <!-- <//?php // if (
                                // in_array('viewCRMMaterialdetail', $user_permission) ||
                                // in_array('createCRMMaterialdetail', $user_permission) ||
                                // in_array('updateCRMMaterialdetail', $user_permission) ||
                                // in_array('deleteCRMMaterialdetail', $user_permission)
                            ) //: ?>
                                <a class="nav-link p-0 px-3 py-1" href="<//?php //echo base_url('CRMMaterialdetail/'); ?>">Material detail</a>
                            <//?php //endif; ?> -->

                            <!-- < //?php if (
                                in_array('viewCRMPrintingdetail', $user_permission) ||
                                in_array('createCRMPrintingdetail', $user_permission) ||
                                in_array('updateCRMPrintingdetail', $user_permission) ||
                                in_array('deleteCRMPrintingdetail', $user_permission)
                            ) : ?>
                                <a class="nav-link p-0 px-3 py-1" href="<//?php echo base_url('CRMPrintingdetail/'); ?>">Printing detail</a>
                            <//?php endif; ?> -->

                            <?php if (
                                in_array('viewCRMDeliverydetail', $user_permission) ||
                                in_array('createCRMDeliverydetail', $user_permission) ||
                                in_array('updateCRMDeliverydetail', $user_permission) ||
                                in_array('deleteCRMDeliverydetail', $user_permission)
                            ) : ?>
                                <a class="nav-link p-0 px-3 py-1" href="<?php echo base_url('CRMDeliverydetail/'); ?>">Delivery detail</a>
                            <?php endif; ?>

                            <?php if (
                                in_array('viewCRMCompletedorder', $user_permission) ||
                                in_array('createCRMCompletedorder', $user_permission) ||
                                in_array('updateCRMCompletedorder', $user_permission) ||
                                in_array('deleteCRMCompletedorder', $user_permission)
                            ) : ?>
                                <a class="nav-link p-0 px-3 py-1" href="<?php echo base_url('CRMCompletedorder/'); ?>">Completed order</a>
                            <?php endif; ?>

                            <?php if (
                                in_array('viewMachineallocation', $user_permission) ||
                                in_array('createMachineallocation', $user_permission) ||
                                in_array('updateMachineallocation', $user_permission) ||
                                in_array('deleteMachineallocation', $user_permission)
                            ) : ?>
                                <a class="nav-link p-0 px-3 py-1" href="<?php echo base_url('Machinealloction/'); ?>">Machine Allocation</a>
                            <?php endif; ?>

                        </nav>
                    </div>

                <?php endif; ?>


                <?php if (
                    in_array('viewStock', $user_permission)
                    || in_array('viewGRN', $user_permission)
                    || in_array('viewEmployeeRepairs', $user_permission)
                    || in_array('viewRepairCostAnalysis', $user_permission)
                    || in_array('viewUsedRepairItems', $user_permission)

                    || in_array('createMachineRepairCreated', $user_permission)
                    || in_array('updateMachineRepairCreated', $user_permission)
                    || in_array('viewMachineRepairCreated', $user_permission)
                    || in_array('deleteMachineRepairCreated', $user_permission)

                    ||in_array('viewEmployeeRepairs', $user_permission)
                    ||in_array('viewRepairCostAnalysis', $user_permission)
                    ||in_array('viewUsedRepairItems', $user_permission)

                    || in_array('createMachineServiceCreated', $user_permission)
                    || in_array('updateMachineServiceCreated', $user_permission)
                    || in_array('viewMachineServiceCreated', $user_permission)
                    || in_array('deleteMachineServiceCreated', $user_permission)

                    ||in_array('viewEmployeeServices', $user_permission)
                    ||in_array('viewServiceCostAnalysis', $user_permission)
                    ||in_array('viewUsedServiceItems', $user_permission)

                ) : ?>

                    <a class="nav-link collapsed" id="rpt_main_nav_link" href="javascript:void(0);" data-toggle="collapse" data-target="#collapseLayoutsRPT" aria-expanded="false" aria-controls="collapseLayoutsRPT">
                        <div class="nav-link-icon"><i class="fas fa-tools "></i></div>Reports
                        <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseLayoutsRPT" data-parent="#accordionSidenav">
                        <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavLayoutRPT">

                            <?php if (
                            in_array('viewStock', $user_permission)
                            ) : ?>
                                <a class="nav-link p-0 px-3 py-1" href="<?php echo base_url('Goodreceive/stock_report'); ?>">Stock</a>
                            <?php endif; ?>

                            <?php if (
                            in_array('viewGRN', $user_permission)
                            ) : ?>
                                <a class="nav-link p-0 px-3 py-1" href="<?php echo base_url('Goodreceive/grn_report'); ?>">GRN</a>
                            <?php endif; ?>

                            <?php if (
                            in_array('viewBinCart', $user_permission)
                            ) : ?>
                                <a class="nav-link p-0 px-3 py-1" href="<?php echo base_url('BinCart'); ?>">Bin Cart</a>
                            <?php endif; ?>


                            <?php if (
                                in_array('createMachineServiceCreated', $user_permission)
                                || in_array('updateMachineServiceCreated', $user_permission)
                                || in_array('viewMachineServiceCreated', $user_permission)
                                || in_array('deleteMachineServiceCreated', $user_permission)
                            ) : ?>
                                <a class="nav-link p-0 px-3 py-1" href="<?php echo base_url('MachineServicesCreated/'); ?>">Service Created List</a>
                            <?php endif; ?>

                            <?php if (
                            in_array('viewEmployeeServices', $user_permission)
                            ) : ?>
                                <a class="nav-link p-0 px-3 py-1" href="<?php echo base_url('MachineServicesEmployee/'); ?>">Employee Services</a>
                            <?php endif; ?>

                            <?php if (
                            in_array('viewServiceCostAnalysis', $user_permission)
                            ) : ?>
                                <a class="nav-link p-0 px-3 py-1" href="<?php echo base_url('MachineServicesCostAnalysis/'); ?>">Service Cost Analysis</a>
                            <?php endif; ?>

                            <?php if (
                            in_array('viewUsedServiceItems', $user_permission)
                            ) : ?>
                                <a class="nav-link p-0 px-3 py-1" href="<?php echo base_url('UsedServiceItems/'); ?>">Used Service Items</a>
                            <?php endif; ?>
                            
                            <?php if (
                                    in_array('createMachineRepairCreated', $user_permission)
                                    || in_array('updateMachineRepairCreated', $user_permission)
                                    || in_array('viewMachineRepairCreated', $user_permission)
                                    || in_array('deleteMachineRepairCreated', $user_permission)
                                ) : ?>
                                    <a class="nav-link p-0 px-3 py-1" href="<?php echo base_url('MachineRepairsCreated/'); ?>">Repair Created List</a>
                                <?php endif; ?>

                                <?php if (
                                in_array('viewEmployeeRepairs', $user_permission)
                                ) : ?>
                                    <a class="nav-link p-0 px-3 py-1" href="<?php echo base_url('MachineRepairsEmployee/'); ?>">Employee Repairs</a>
                                <?php endif; ?>

                                <?php if (
                                in_array('viewRepairCostAnalysis', $user_permission)
                                ) : ?>
                                    <a class="nav-link p-0 px-3 py-1" href="<?php echo base_url('MachineRepairsCostAnalysis/'); ?>">Repair Cost Analysis</a>
                                <?php endif; ?>

                                <?php if (
                                in_array('viewUsedRepairItems', $user_permission)
                                ) : ?>
                                    <a class="nav-link p-0 px-3 py-1" href="<?php echo base_url('UsedRepairItems/'); ?>">Used Repair Items</a>
                                <?php endif; ?>
                            

                        </nav>
                    </div>

                <?php endif; ?>

                <?php if (
                    in_array('viewMachineServiceItemReturn', $user_permission)
                    || in_array('viewSparePartReturnToSupplier', $user_permission)
                ) : ?>

                    <a class="nav-link collapsed" id="return_main_nav_link" href="javascript:void(0);" data-toggle="collapse" data-target="#collapseLayoutsReturn" aria-expanded="false" aria-controls="collapseLayoutsReturn">
                        <div class="nav-link-icon"><i class="fas fa-tools "></i></div>Return
                        <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                    </a>
                    <div class="collapse" id="collapseLayoutsReturn" data-parent="#accordionSidenav">
                        <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavLayoutReturn">

                            <?php if (
                                in_array('createMachineServiceItemReturn', $user_permission)
                                || in_array('updateMachineServiceItemReturn', $user_permission)
                                || in_array('viewMachineServiceItemReturn', $user_permission)
                                || in_array('deleteMMachineServiceItemReturn', $user_permission)
                            ) : ?>
                                <a class="nav-link p-0 px-3 py-1" href="<?php echo base_url('MachineServices/return_to_stock'); ?>">Return to Stock </a>
                            <?php endif; ?>

                            <?php if (
                                in_array('createMachineServiceItemReturnAccept', $user_permission)
                                || in_array('updateMachineServiceItemReturnAccept', $user_permission)
                                || in_array('viewMachineServiceItemReturnAccept', $user_permission)
                                || in_array('deleteMachineServiceItemReturnAccept', $user_permission)
                            ) : ?>
                                <a class="nav-link p-0 px-3 py-1" href="<?php echo base_url('MachineServices/return_accept'); ?>">Accepted Return Items </a>
                            <?php endif; ?>

                            <?php if (
                                in_array('createSparePartReturnToSupplier', $user_permission)
                                || in_array('updateSparePartReturnToSupplier', $user_permission)
                                || in_array('viewSparePartReturnToSupplier', $user_permission)
                                || in_array('deleteSparePartReturnToSupplier', $user_permission)
                            ) : ?>
                                <a class="nav-link p-0 px-3 py-1" href="<?php echo base_url('MachineServices/return_to_supplier'); ?>">Return to Supplier </a>
                            <?php endif; ?>

                            <?php if (
                            in_array('createSparePartReturnToSupplierApprove', $user_permission)
                            ) : ?>
                                <a class="nav-link p-0 px-3 py-1" href="<?php echo base_url('MachineServices/return_to_supplier_approve_front'); ?>">Return to Supplier Approve</a>
                            <?php endif; ?>

                        </nav>
                    </div>

                <?php endif; ?>


                <?php if ($user_permission) : ?>

                    <?php if (
                        in_array('createCustomerInfo', $user_permission) ||
                        in_array('updateCustomerInfo', $user_permission) ||
                        in_array('viewCustomerInfo', $user_permission) ||
                        in_array('deleteCustomerInfo', $user_permission)
                    ) : ?>
                        <a class="nav-link collapsed" id="customers_main_nav_link" href="javascript:void(0);" data-toggle="collapse" data-target="#collapseLayoutsCustomers" aria-expanded="false" aria-controls="collapseLayoutsCustomers">
                            <div class="nav-link-icon"><i class="fas fa-users"></i></div>Customers
                            <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayoutsCustomers" data-parent="#accordionSidenav">
                            <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavLayoutCustomers">

                                <?php if (
                                    in_array('createCustomerInfo', $user_permission) ||
                                    in_array('updateCustomerInfo', $user_permission) ||
                                    in_array('viewCustomerInfo', $user_permission) ||
                                    in_array('deleteCustomerInfo', $user_permission)
                                ) : ?>
                                    <a class="nav-link p-0 px-3 py-1" href="<?php echo base_url('Customer/'); ?>">Customer Info</a>
                                <?php endif; ?>

                                <!-- <a class="nav-link p-0 px-3 py-1" href="<?php echo base_url('Customerbank/'); ?>">Customer Bank</a> -->
                                <!-- <a class="nav-link p-0 px-3 py-1" href="<?php echo base_url('Customercontact'); ?>">Customer Contact</a> -->

                            </nav>
                        </div>
                    <?php endif; ?>


                    <?php if (
                        in_array('createSupplierInfo', $user_permission) ||
                        in_array('updateSupplierInfo', $user_permission) ||
                        in_array('viewSupplierInfo', $user_permission) ||
                        in_array('deleteSupplierInfo', $user_permission)
                    ) : ?>
                        <a class="nav-link collapsed" id="suppliers_main_nav_link" href="javascript:void(0);" data-toggle="collapse" data-target="#collapseLayoutsSuppliers" aria-expanded="false" aria-controls="collapseLayoutsSuppliers">
                            <div class="nav-link-icon"><i class="fas fa-truck"></i></div>Suppliers
                            <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayoutsSuppliers" data-parent="#accordionSidenav">
                            <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavLayoutSuppliers">

                                <?php if (
                                    in_array('createSupplierInfo', $user_permission) ||
                                    in_array('updateSupplierInfo', $user_permission) ||
                                    in_array('viewSupplierInfo', $user_permission) ||
                                    in_array('deleteSupplierInfo', $user_permission)
                                ) : ?>
                                    <a class="nav-link p-0 px-3 py-1" href="<?php echo base_url('Supplier'); ?>">Supplier Info</a>
                                <?php endif; ?>

                                <!-- <a class="nav-link p-0 px-3 py-1" href="<?php echo base_url('Supplierbank'); ?>">Supplier Bank</a> -->
                                <!-- <a class="nav-link p-0 px-3 py-1" href="<?php echo base_url('Suppliercontact'); ?>">Supplier Contact</a> -->

                            </nav>
                        </div>
                    <?php endif; ?>


                    <?php if (in_array('createUser', $user_permission) || in_array('updateUser', $user_permission) || in_array('viewUser', $user_permission) || in_array('deleteUser', $user_permission) || in_array('createGroup', $user_permission) || in_array('updateGroup', $user_permission) || in_array('viewGroup', $user_permission) || in_array('deleteGroup', $user_permission)) : ?>
                        <div class="sidenav-menu-heading">User Management</div>
                    <?php endif; ?>

                    <?php if (in_array('createUser', $user_permission) || in_array('updateUser', $user_permission) || in_array('viewUser', $user_permission) || in_array('deleteUser', $user_permission)) : ?>

                        <a class="nav-link collapsed" id="users_main_nav_link" href="javascript:void(0);" data-toggle="collapse" data-target="#collapseLayoutsUsers" aria-expanded="false" aria-controls="collapseLayoutsUsers">
                            <div class="nav-link-icon"><i data-feather="user"></i></div>
                            Users
                            <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayoutsUsers" data-parent="#accordionSidenav">
                            <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavLayoutUsers">

                                <?php if (in_array('createUser', $user_permission)) : ?>
                                    <a class="nav-link" href="<?php echo base_url('users/create'); ?>">Add User</a>
                                <?php endif; ?>

                                <?php if (in_array('updateUser', $user_permission) || in_array('viewUser', $user_permission) || in_array('deleteUser', $user_permission)) : ?>
                                    <a class="nav-link" id="manage_users_nav_link" href="<?php echo base_url('users/manage'); ?>">Manage Users</a>
                                <?php endif; ?>

                            </nav>
                        </div>

                    <?php endif; ?>

                    <?php if (in_array('createGroup', $user_permission) || in_array('updateGroup', $user_permission) || in_array('viewGroup', $user_permission) || in_array('deleteGroup', $user_permission)) : ?>

                        <a class="nav-link collapsed" id="groups_main_nav_link" href="javascript:void(0);" data-toggle="collapse" data-target="#collapseLayoutsGroups" aria-expanded="false" aria-controls="collapseLayoutsGroups">
                            <div class="nav-link-icon"><i data-feather="user"></i></div>
                            Groups
                            <div class="sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
                        </a>
                        <div class="collapse" id="collapseLayoutsGroups" data-parent="#accordionSidenav">
                            <nav class="sidenav-menu-nested nav accordion" id="accordionSidenavLayoutGroups">

                                <?php if (in_array('createGroup', $user_permission)) : ?>
                                    <a class="nav-link" href="<?php echo base_url('groups/create'); ?>">Add Group</a>
                                <?php endif; ?>

                                <?php if (in_array('updateGroup', $user_permission) || in_array('viewGroup', $user_permission) || in_array('deleteGroup', $user_permission)) : ?>
                                    <a class="nav-link" id="manage_groups_nav_link" href="<?php echo base_url('groups/'); ?>">Manage Group</a>
                                <?php endif; ?>

                            </nav>
                        </div>

                    <?php endif; ?>

                    <?php if (in_array('updateCompany', $user_permission)) : ?>
                        <a class="nav-link" href="<?php echo base_url('company/'); ?>">
                            <div class="nav-link-icon"> <i class="fas fa-info"></i> </div>
                            Company Info
                        </a>
                    <?php endif; ?>


                <?php endif; ?>


            </div>
        </div>
        <div class="sidenav-footer">
            <div class="sidenav-footer-content">
                <div class="sidenav-footer-subtitle">Logged in as:</div>
                <div class="sidenav-footer-title"> <?= $_SESSION['username'] ?> </div>
            </div>
        </div>
    </nav>
</div>

<div id="layoutSidenav_content">
    <main>