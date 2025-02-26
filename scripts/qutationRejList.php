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
$table = 'tbl_quotation';

// Table's primary key
$primaryKey = 'idtbl_quotation';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array( 'db' => '`u`.`idtbl_quotation`', 'dt' => 'idtbl_quotation', 'field' => 'idtbl_quotation' ),
	array( 'db' => '`u`.`tbl_inquiry_idtbl_inquiry`', 'dt' => 'tbl_inquiry_idtbl_inquiry', 'field' => 'tbl_inquiry_idtbl_inquiry' ),
	array( 'db' => '`u`.`quot_date`', 'dt' => 'quot_date', 'field' => 'quot_date' ),
	array( 'db' => '`u`.`duedate`', 'dt' => 'duedate', 'field' => 'duedate' ),
	array( 'db' => '`u`.`total`', 'dt' => 'total', 'field' => 'total' ),
	array( 'db' => '`u`.`discount`', 'dt' => 'discount', 'field' => 'discount' ),
	array( 'db' => '`u`.`nettotal`', 'dt' => 'nettotal', 'field' => 'nettotal' ),
	array( 'db' => '`u`.`delivery_charge`', 'dt' => 'delivery_charge', 'field' => 'delivery_charge' ),
	array( 'db' => '`u`.`remarks`', 'dt' => 'remarks', 'field' => 'remarks' ),
	array( 'db' => '`u`.`reject_resone`', 'dt' => 'reject_resone', 'field' => 'reject_resone' ),
	array( 'db' => '`ua`.`idtbl_inquiry`', 'dt' => 'idtbl_inquiry', 'field' => 'idtbl_inquiry' ),
	array( 'db' => '`ub`.`idtbl_customer`', 'dt' => 'idtbl_customer', 'field' => 'idtbl_customer' ),
	array( 'db' => '`ub`.`name`', 'dt' => 'name', 'field' => 'name' ),
	array( 'db' => '`uc`.`idtbl_reason`', 'dt' => 'idtbl_reason', 'field' => 'idtbl_reason' ),
	array( 'db' => '`uc`.`type`', 'dt' => 'type', 'field' => 'type' ),
	array( 'db' => '`u`.`approvestatus`', 'dt' => 'approvestatus', 'field' => 'approvestatus' ),
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

// $getid = $_POST['getid'];

$joinQuery = "FROM `tbl_quotation` AS `u` 
              LEFT JOIN `tbl_inquiry` AS `ua` ON (`ua`.`idtbl_inquiry` = `u`.`tbl_inquiry_idtbl_inquiry`)
              LEFT JOIN `tbl_reason` AS `uc` ON (`uc`.`idtbl_reason` = `u`.`tbl_reason_idtbl_reason`) 
              LEFT JOIN `tbl_customer` AS `ub` ON (`ub`.`idtbl_customer` = `u`.`tbl_customer_idtbl_customer`)";

$extraWhere = "`u`.`approvestatus` IN (2) ";
// AND `u`.`tbl_inquiry_idtbl_inquiry` = '$getid'

echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);
