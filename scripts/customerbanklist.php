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
$table = 'tbl_customer_bank_details';

// Table's primary key
$primaryKey = 'idtbl_customer_bank_details';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array( 'db' => '`u`.`idtbl_customer_bank_details`', 'dt' => 'idtbl_customer_bank_details', 'field' => 'idtbl_customer_bank_details' ),
	array( 'db' => '`u`.`bank_name`', 'dt' => 'bank_name', 'field' => 'bank_name' ),
	array( 'db' => '`u`.`branch`', 'dt' => 'branch', 'field' => 'branch' ),
	array( 'db' => '`u`.`account_no`', 'dt' => 'account_no', 'field' => 'account_no' ),
	array( 'db' => '`u`.`account_name`', 'dt' => 'account_name', 'field' => 'account_name' ),
	array( 'db' => '`u`.`tbl_customer_idtbl_customer`', 'dt' => 'tbl_customer_idtbl_customer', 'field' => 'tbl_customer_idtbl_customer' ),
	array( 'db' => '`u`.`status`', 'dt' => 'status', 'field' => 'status' )
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

$customerid = $_POST['customer'];

$joinQuery = "FROM `tbl_customer_bank_details` AS `u`";
$extraWhere = "`u`.`status` IN (1, 2) AND  `u`.tbl_customer_idtbl_customer = '$customerid'";

echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns,$joinQuery, $extraWhere)
);
