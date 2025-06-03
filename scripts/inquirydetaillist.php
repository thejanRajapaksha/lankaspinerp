<?php

/*
 * DataTables example server-side processing script.
 *
 * Please note that this script is intentionally extremely simple to show how
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
$table = 'tbl_inquiry_detail';

// Table's primary key
$primaryKey = 'idtbl_inquiry_detail';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
    array( 'db' => '`u`.`idtbl_inquiry_detail`', 'dt' => 'idtbl_inquiry_detail', 'field' => 'idtbl_inquiry_detail' ),
    array( 'db' => '`u`.`status`', 'dt' => 'status', 'field' => 'status' ),
    array( 'db' => '`u`.`quantity`', 'dt' => 'quantity', 'field' => 'quantity' ),
    array( 'db' => '`u`.`delivarydate`', 'dt' => 'd_date', 'field' => 'delivarydate' ),
    array( 'db' => '`u`.`inner_bag`', 'dt' => 'inner_bag', 'field' => 'inner_bag' ),
    array( 'db' => '`u`.`date`', 'dt' => 'date', 'field' => 'date' ),
    array( 'db' => '`u`.`bag_length`', 'dt' => 'bag_length', 'field' => 'bag_length' ),
    array( 'db' => '`u`.`bag_width`', 'dt' => 'bag_width', 'field' => 'bag_width' ),
    // array( 'db' => '`u`.`bag_type`', 'dt' => 'bag_type', 'field' => 'bag_type' ),
    array( 'db' => '`u`.`colour_no`', 'dt' => 'colour_no', 'field' => 'colour_no' ),
    array( 'db' => '`u`.`off_print`', 'dt' => 'off_print', 'field' => 'off_print' ),
    array( 'db' => '`u`.`printing_type`', 'dt' => 'printing_type', 'field' => 'printing_type' ),
    array( 'db' => '`p`.`product`', 'dt' => 'item', 'field' => 'product' ),
    array( 'db' => '`u`.`liner_size`', 'dt' => 'liner_size', 'field' => 'liner_size' ),
    array( 'db' => '`u`.`liner_color`', 'dt' => 'liner_color', 'field' => 'liner_color' ),
    array( 'db' => '`u`.`bg_weight`', 'dt' => 'bg_weight', 'field' => 'bg_weight' ),
    array( 'db' => '`u`.`ln_weight`', 'dt' => 'ln_weight', 'field' => 'ln_weight' ),

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

$joinQuery = "FROM `tbl_inquiry_detail` AS `u`
LEFT JOIN `tbl_products` AS `p` 
ON u.tbl_products_idtbl_product = p.idtbl_product
LEFT JOIN `tbl_inquiry` AS `i` ON u.tbl_inquiry_idtbl_inquiry = i.idtbl_inquiry
";

$ID = $_POST['id'];

$extraWhere = "`u`.`status` IN (1, 2) AND `u`.`tbl_inquiry_idtbl_inquiry` IN ('$ID')";

echo json_encode(
    SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);
?>
