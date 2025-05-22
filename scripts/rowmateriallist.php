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
$table = 'tbl_row_material';

// Table's primary key
$primaryKey = 'idtbl_row_material';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array( 'db' => '`u`.`idtbl_row_material`', 'dt' => 'idtbl_row_material', 'field' => 'idtbl_row_material' ),
	array( 'db' => '`u`.`material_name`', 'dt' => 'material_name', 'field' => 'material_name' ),
	array( 'db' => '`u`.`rol`', 'dt' => 'rol', 'field' => 'rol' ),
	array( 'db' => '`ua`.`suppliername`', 'dt' => 'suppliername', 'field' => 'suppliername' ),
	array( 'db' => '`uc`.`measure_type`', 'dt' => 'measure_type', 'field' => 'measure_type' ),
	array( 'db' => '`ud`.`categoryname`', 'dt' => 'categoryname', 'field' => 'categoryname' ),
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

$joinQuery = "FROM `tbl_row_material` AS `u` LEFT JOIN `tbl_supplier` AS `ua` ON (`u`.`tbl_supplier_idtbl_supplier` = `ua`.`idtbl_supplier`) LEFT JOIN `tbl_measurements` AS `uc` ON (`u`.`tbl_measurements_idtbl_measurements` = `uc`.`idtbl_mesurements`) LEFT JOIN `tbl_material_main_cat` AS `ud` ON (`u`.`tbl_material_main_cat_idtbl_material_main_cat` = `ud`.`idtbl_material_main_cat`)";
$extraWhere = "`u`.`status` IN (1, 2)";

echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns,$joinQuery, $extraWhere)
);
