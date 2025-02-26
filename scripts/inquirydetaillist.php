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
    array( 'db' => '`d`.`idtbl_inquiry_detail`', 'dt' => 'idtbl_inquiry_detail', 'field' => 'idtbl_inquiry_detail' ),
    array( 'db' => '`d`.`tbl_inquiry_idtbl_inquiry`', 'dt' => 'tbl_inquiry_idtbl_inquiry', 'field' => 'tbl_inquiry_idtbl_inquiry' ),
    // array( 'db' => '`u`.`tbl_cloth_idtbl_cloth`', 'dt' => 'tbl_cloth_idtbl_cloth', 'field' => 'tbl_cloth_idtbl_cloth' ),
    array( 'db' => '`d`.`type`', 'dt' => 'type', 'field' => 'type' ),
    // array( 'db' => '`u`.`tbl_material_idtbl_material`', 'dt' => 'tbl_material_idtbl_material', 'field' => 'tbl_material_idtbl_material' ),
    array( 'db' => '`d`.`mattype`', 'dt' => 'mattype', 'field' => 'mattype' ),
    array( 'db' => '`d`.`sname`', 'dt' => 'sname', 'field' => 'sname' ),
    array( 'db' => '`d`.`quantity`', 'dt' => 'quantity', 'field' => 'quantity' ),
    array( 'db' => '`d`.`status`', 'dt' => 'status', 'field' => 'status' )
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

$joinQuery = "from (select u.*, c.type, m.type as mattype , s.name as sname 
    FROM `tbl_inquiry_detail` AS `u`
    LEFT JOIN `tbl_cloth` AS `c` ON `u`.`tbl_cloth_idtbl_cloth` = `c`.`idtbl_cloth`
    LEFT JOIN `tbl_material` AS `m` ON `u`.`tbl_material_idtbl_material` = `m`.`idtbl_material`
    LEFT JOIN `tbl_salesrep` AS `s` ON `u`.`tbl_salesrep_idtbl_salesrep` = `s`.`idtbl_salesrep`
) as d";

$ID = $_POST['id'];

$extraWhere = "`d`.`status` IN (1, 2) AND `d`.`tbl_inquiry_idtbl_inquiry` IN ('$ID')";

echo json_encode(
    SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);
?>
