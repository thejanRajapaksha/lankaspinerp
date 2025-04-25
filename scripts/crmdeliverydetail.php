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
$table = 'tbl_order_detail';

// Table's primary key
$primaryKey = 'idtbl_order_detail';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array( 'db' => '`ua`.`idtbl_order`', 'dt' => 'idtbl_order', 'field' => 'idtbl_order' ),
    array( 'db' => '`uc`.`name`', 'dt' => 'name', 'field' => 'name' ),
    array( 'db' => '`u`.`order_date`', 'dt' => 'order_date', 'field' => 'order_date' ),
    array( 'db' => '`uc`.`idtbl_customer`', 'dt' => 'idtbl_customer', 'field' => 'idtbl_customer' ),
    array( 'db' => '`ub`.`idtbl_inquiry`', 'dt' => 'idtbl_inquiry', 'field' => 'idtbl_inquiry' ),
    array( 'db' => '`u`.`quantity`', 'dt' => 'quantity', 'field' => 'quantity' )

    
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

$joinQuery = "FROM `tbl_order_detail` AS `u` 
              LEFT JOIN `tbl_order` AS `ua` ON (`ua`.`idtbl_order` = `u`.`tbl_order_idtbl_order`) 
              LEFT JOIN `tbl_inquiry` AS `ub` ON (`ub`.`idtbl_inquiry` = `ua`.`tbl_inquiry_idtbl_inquiry`)
              LEFT JOIN `tbl_customer` AS `uc` ON (`uc`.`idtbl_customer` = `ub`.`tbl_customer_idtbl_customer`)
             ";

// $extraWhere = "`u`.`approvestatus` IN (1) AND `u`.`status` IN (1, 4)";
// AND `u`.`tbl_inquiry_idtbl_inquiry` = '$getid'

echo json_encode(
    SSP::simple($_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery)
);
