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
$table = 'tbl_customerinquiry';

// Table's primary key
$primaryKey = 'idtbl_customerinquiry';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array( 'db' => '`u`.`idtbl_customerinquiry`', 'dt' => 'idtbl_customerinquiry', 'field' => 'idtbl_customerinquiry' ),
	array( 'db' => '`ud`.`name`', 'dt' => 'name', 'field' => 'name' ),
    array( 'db' => '`u`.`po_number`', 'dt' => 'po_number', 'field' => 'po_number' ),
	array( 'db' => '`ub`.`qty`', 'dt' => 'qty', 'field' => 'qty' ),
    array( 'db' => '`ub`.`job`', 'dt' => 'job', 'field' => 'job' ),
    array( 'db' => '`uc`.`idtbl_cost_items`', 'dt' => 'idtbl_cost_items', 'field' => 'idtbl_cost_items' ),
    array( 'db' => '`uc`.`costitemname`', 'dt' => 'costitemname', 'field' => 'costitemname' ),
	array( 'db' => '`ub`.`status`', 'dt' => 'status', 'field' => 'status' ),
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
require('ssp.customized.class.php' );

$joinQuery = "FROM `tbl_customerinquiry` AS `u`
LEFT JOIN `tbl_customerinquiry_detail` AS `ub` ON `u`.`idtbl_customerinquiry` = `ub`.`tbl_customerinquiry_idtbl_customerinquiry`
LEFT JOIN `tbl_cost_items` AS `uc` ON `ub`.`idtbl_customerinquiry_detail` = `uc`.`tbl_customerinquiry_detail_idtbl_customerinquiry_detail` LEFT JOIN `tbl_customer` AS `ud` ON (`ud`.`idtbl_customer` = `u`.`tbl_customer_idtbl_customer`)";

$extraWhere = "`u`.`status` IN (1) AND `ub`.`status` IN (1) AND `uc`.`status` IN (1)";

echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);
