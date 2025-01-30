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

$exc_style = '';//isset($_POST['set_code'])?$_POST['set_code']:'0';

// DB table to use
$table = 'mmachine_instinfo';

// Table's primary key
$primaryKey = 'id';

// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
	array( 'db' => '`u`.`reg_num`', 'dt' => 'reg_num', 'field' => 'reg_num' ),
	array( 'db' => '`u`.`mach_instid`', 'dt' => 'mach_instid', 'field' => 'mach_instid' ),
	array( 'db' => '`u`.`track_addr`', 'dt' => 'track_addr', 'field' => 'track_addr' ),
	array( 'db' => '`u`.`line_code`', 'dt' => 'line_code', 'field' => 'line_code' ),
	array( 'db' => '`u`.`line_name`', 'dt' => 'line_name', 'field' => 'line_name' ),
	array( 'db' => '`u`.`reg_cancel`', 'dt' => 'reg_cancel', 'field' => 'reg_cancel' )
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
/*
$joinQuery = "FROM (select (@row_number:=@row_number + 1) AS num, idtbl_carton_dimension, prodstyle_list_id, tbl_style_size_desc, pcs_per_carton, carton_length, carton_width, carton_height, item_weight, carton_weight, cbm_per_carton, carton_volume, status FROM tbl_carton_dimension,(SELECT @row_number:=0) AS t) AS u";
*/
$joinQuery = "FROM (select mmachine_instinfo.id as reg_num, mmachine_instinfo.mach_instid, mmachine_instinfo.track_addr, ifnull(mlinelist.line_code, '') as line_code, ifnull(mlinelist.line_name, '') as line_name, mmachine_instinfo.isoffline as reg_cancel from mmachine_instinfo left outer join mlinelist on mmachine_instinfo.mlinelist_id=mlinelist.id) AS u";

$extraWhere = '';//"`u`.`styleid`='".$exc_style."' AND `u`.`status`=1";//

echo json_encode(
	SSP::simple( $_POST, $sql_details, $table, $primaryKey, $columns, $joinQuery, $extraWhere)
);
