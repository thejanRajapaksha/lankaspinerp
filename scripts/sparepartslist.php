<?php

// DB table to use
$table = 'spare_parts';

// Table's primary key
$primaryKey = 'id';

// Array of database columns which should be read and sent back to DataTables.
$columns = array(
    array('db' => 'spare_parts.id', 'dt' => 'id', 'field' => 'id'),
    array('db' => 'spare_parts.name', 'dt' => 'name', 'field' => 'name'),
    array('db' => 'ub.machine_models', 'dt' => 'machine_models', 'field' => 'machine_models'),
    array('db' => 'ua.machine_types', 'dt' => 'machine_types', 'field' => 'machine_types'),
    array('db' => 'ts.suppliername', 'dt' => 'suppliername', 'field' => 'suppliername'),
    array('db' => 'spare_parts.part_no', 'dt' => 'part_no', 'field' => 'part_no'),
    array('db' => 'spare_parts.rack_no', 'dt' => 'rack_no', 'field' => 'rack_no'),
    array('db' => 'spare_parts.unit_price', 'dt' => 'unit_price', 'field' => 'unit_price'),
    array('db' => 'spare_parts.active', 'dt' => 'active', 'field' => 'active')
);

// SQL server connection information
require('config.php');
$sql_details = array(
    'user' => $db_username,
    'pass' => $db_password,
    'db'   => $db_name,
    'host' => $db_host
);

// Correct SQL Query without ORDER BY
$joinQuery = "FROM `spare_parts`
              LEFT JOIN (SELECT id, name AS machine_types FROM `machine_types`) AS `ua` ON `ua`.`id` = `spare_parts`.`type`
              LEFT JOIN (SELECT id, name AS machine_models FROM `machine_models`) AS `ub` ON `ub`.`id` = `spare_parts`.`model`
              LEFT JOIN `spare_part_suppliers` AS `sps` ON `sps`.`sp_id` = `spare_parts`.`id`
              LEFT JOIN (SELECT idtbl_supplier, suppliername FROM `tbl_supplier`) AS `ts` ON `ts`.`idtbl_supplier` = `sps`.`supplier_id`";

// Extra WHERE condition to exclude deleted records
$extraWhere = "spare_parts.is_deleted = 0";

// Include customized SSP class
require('ssp.customized.class.php');

// Output JSON response for DataTables
echo json_encode(
    SSP::simple($_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);

?>
