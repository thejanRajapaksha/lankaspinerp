<?php
/*
 * DataTables example server-side processing script.
 *
 * Please note that this script is intentionally extremely simply to show how
 * server-side processing can be implemented, and probably shouldn't be used as
 * the basis for a large complex system. It is suitable for simple use cases as
 * for learning.
 *
 * See http://datatables.net/usage/server-side for full details on the server-
 * side processing requirements of DataTables.
 *
 * @license MIT - http://datatables.net/license_mit
 */

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */

// DB table to use
$table = 'tbl_machine_allocation';

// Table's primary key
$primaryKey = 'idtbl_machine_allocation';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
    array('db' => 'c.name',               'dt' => 'name',              'field' => 'name'),
    array('db' => 'CONCAT(o.idtbl_order," / ",de.deliveryId)','dt' => 'order_delivery','field' => 'order_delivery','as' => 'order_delivery'),
    array('db' => 'q.duedate',            'dt' => 'duedate',           'field' => 'duedate'),
    array('db' => 'od.quantity',          'dt' => 'quantity',          'field' => 'quantity'),
    array('db' => 'de.deliver_quantity',  'dt' => 'deliver_quantity',  'field' => 'deliver_quantity'),
    array('db' => 'mad.completedqty',      'dt' => 'completedqty',     'field' => 'completedqty')
);

// SQL server connection information
require('config.php');
$sql_details = array(
    'user' => $db_username,
    'pass' => $db_password,
    'db'   => $db_name,
    'host' => $db_host
);

/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */

// require( 'ssp.class.php' );
require('ssp.customized.class.php');

$machineId = $_POST['machineId'] ?? null;
$date = $_POST['date'] ?? null;

$joinQuery = "FROM tbl_machine_allocation AS ma
    LEFT JOIN machine_ins AS m ON m.id = ma.tbl_machine_idtbl_machine
    LEFT JOIN tbl_machine_allocation_details AS mad ON mad.tbl_machine_allocation_idtbl_machine_allocation = ma.idtbl_machine_allocation
    LEFT JOIN machine_types AS mt ON mt.id = m.machine_type_id
    LEFT JOIN tbl_order AS o ON o.idtbl_order = ma.tbl_order_idtbl_order
    LEFT JOIN tbl_order_detail AS od ON od.tbl_order_idtbl_order = o.idtbl_order
    LEFT JOIN tbl_products AS p ON p.idtbl_product = od.tbl_products_idtbl_products
    LEFT JOIN tbl_delivery_detail AS de ON de.idtbl_delivery_detail = ma.tbl_delivery_plan_details_idtbl_delivery_plan_details
    LEFT JOIN tbl_quotation AS q ON q.tbl_inquiry_idtbl_inquiry = o.tbl_inquiry_idtbl_inquiry
    LEFT JOIN tbl_customer AS c ON c.idtbl_customer = q.tbl_customer_idtbl_customer";

$conditions = [];

if (!empty($machineId)) {
    $conditions[] = "m.id = " . intval($machineId);
}

if (!empty($date)) {
    $conditions[] = "DATE(ma.allocatedate) = '" . date('Y-m-d', strtotime($date)) . "'";
}

$extraWhere = implode(" AND ", $conditions);

echo json_encode(
    SSP::simple($_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);
