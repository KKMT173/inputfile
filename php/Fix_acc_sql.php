<?php
header('Content-Type: text/html; charset=UTF-8');
class accessDB {
	
	/////////////////////////////////////////////////////////////////////////////////
	//                              connect to DB                                  //
	/////////////////////////////////////////////////////////////////////////////////
	function connectDB ($dbName){  
		$dbconn = pg_connect("host='db01.nidec-copal.co.th' dbname='$dbName' user='user_setup' password='user_setup'") or
		exit("Can not connect to Database !");

		
		return $dbconn;
	}
}

class look_up extends accessDB{
	
		
	//////////////////////////////////////////////////////////////////////////////////
	//description : look up location_Index from location_Name                       //
	//input       : location name   											    //
	//output      : locationIndex                  									//
	//////////////////////////////////////////////////////////////////////////////////
	function look_up_LocationIndex($Location_Name){
	
		$dbconn = $this->connectDB('Part_Trace');
	
		$params = array($Location_Name);
		$query = "select location_index from icc_location_list where location_name = $1";
		
	
		$result = pg_query_params($dbconn, $query, $params);
		
		
		$location_Index = array();
		while ($row = pg_fetch_array($result)){
			array_push($location_Index, $row['location_index']);
		}
		
	
		return $location_Index[0];
	
	}	
}

class insert extends accessDB {
	
	//Spare part


	/////////////////////////////////////////////////////////////////////////////////
	//description : insert data into icc_eq_list				                   //
	//input       : eq_index, eq_name, eq_name_thai, eq_type, eq_unit, 			   //
	//				location_name, pic_Name, lower_limit		       			   //
	//output      : boolean			     										   //
	/////////////////////////////////////////////////////////////////////////////////
	function insert_to_slip_index($index, $time, $section_index,$type_index,$user_index) {
		$dbconn 	= $this->connectDB('request_slip_test');
		$params 	= array($index, $time, $section_index,$type_index,$user_index);
		$query 		= "insert into slip_index values ( $1, $2, $3,$4,$5);";
		
		$result_flag = pg_query_params($dbconn, $query, $params);
		
		if ($result_flag){
			return true;
		}else {
			return false;
		}
    }	
    
    function insert_to_slip_detail($index, $type, $temp_no,$sec_req,$requseter,$ext_no,$disposed,$reason) {
		$dbconn 	= $this->connectDB('paperless_system');
		$params 	= array($index, $type, $temp_no,$sec_req,$requseter,$ext_no,$disposed,$reason);
		$query 		= "insert into fixed_assets_deposed_detail values ( $1, $2, $3,$4,$5,$6,$7,$8);";
		
		$result_flag = pg_query_params($dbconn, $query, $params);
		
		if ($result_flag){
			return true;
		}else {
			return false;
		}
    }	
    
    function insert_to_slip_data($slip_index, $type_index, $asset_no,$boi,$remark,$picture,$label,$type,$pic_remark,$Sale_process) {
		$dbconn 	= $this->connectDB('paperless_system');
		$params 	= array($slip_index, $type_index, $asset_no,$boi,$remark,$picture,$label,$type,$pic_remark,$Sale_process);
		$query 		= "insert into fixed_assets_deposed_data values ( $1, $2, $3,$4,$5,$6,$7,$8,$9,$10);";
		
		$result_flag = pg_query_params($dbconn, $query, $params);
		
		if ($result_flag){
			return true;
		}else {
			return false;
		}
	}

	function insert_to_attech_file($slip_index, $type_index, $file_name,$file_path,$file_realname) {
		$dbconn 	= $this->connectDB('paperless_system');
		$params 	= array($slip_index, $type_index, $file_name,$file_path,$file_realname);
		$query 		= "insert into paperless_attach_file values ( $1, $2, $3,$4,$5);";
		
		$result_flag = pg_query_params($dbconn, $query, $params);
		
		if ($result_flag){
			return true;
		}else {
			return false;
		}
	}
	
	function insert_to_approve_flow($slip_index,$user,$num, $type_index) {
		$dbconn 	= $this->connectDB('request_slip_test');
		$params 	= array($slip_index,$user,$num, $type_index);
		$query 		= "insert into approve_flow values ( $1, $2, $3,$4);";
		
		$result_flag = pg_query_params($dbconn, $query, $params);
		
		if ($result_flag){
			return true;
		}else {
			return false;
		}
	}

	function insert_to_status($slip_index,$date,$user,$status,$type_index) {
		$dbconn 	= $this->connectDB('request_slip_test');
		$params 	= array($slip_index,$date,$user,$status,$type_index);
		$query 		= "insert into status_history values ( $1, $2, $3,$4,$5);";
		
		$result_flag = pg_query_params($dbconn, $query, $params);
		
		if ($result_flag){
			return true;
		}else {
			return false;
		}
	}
	
	function insert_to_approve_sec($slip_index,$user,$num, $type_index) {
		$dbconn 	= $this->connectDB('request_slip_test');
		$params 	= array($slip_index,$user,$num, $type_index);
		$query 		= "insert into approve_sec values ( $1, $2, $3,$4);";
		
		$result_flag = pg_query_params($dbconn, $query, $params);
		
		if ($result_flag){
			return true;
		}else {
			return false;
		}
	}
	
	function insert_to_approved_list($slip_index,$user,$date,$sent,$num, $type_index) {
		$dbconn 	= $this->connectDB('request_slip_test');
		$params 	= array($slip_index,$user,$date,$sent,$num, $type_index);
		$query 		= "insert into approve values ( $1, $2, $3,$4,$5,$6);";
		
		$result_flag = pg_query_params($dbconn, $query, $params);
		
		if ($result_flag){
			return true;
		}else {
			return false;
		}
	}
	
	function insert_to_approve_alarm($user_index,$slip_index,$section_name,$date,$text,$read, $type_index) {
		$dbconn 	= $this->connectDB('request_slip_test');
		$params 	= array($user_index,$slip_index,$section_name,$date,$text,$read, $type_index);
		$query 		= "insert into approve_alarm values ( $1, $2, $3,$4,$5,$6,$7);";
		
		$result_flag = pg_query_params($dbconn, $query, $params);
		
		if ($result_flag){
			return true;
		}else {
			return false;
		}
	}
	
	function insert_to_comment($slip_index,$user_index,$comment,$type_index) {
		$dbconn 	= $this->connectDB('request_slip_test');
		$date=date('Y-m-d H:i:s');
		$params 	= array($slip_index,$user_index,$comment,$date,$type_index);
		$query 		= "insert into comment values ( $1, $2, $3,$4,$5);";
		
		$result_flag = pg_query_params($dbconn, $query, $params);
		
		if ($result_flag){
			return true;
		}else {
			return false;
		}
	}	
	
	function insert_to_fixed_save($fixed_assets_no,$des,$acc_code,$location,$vendor,$section,$invoice_no,$boi_section,$boi_project,$start_date,$qty,$acq_cost,$acc_dep,$net_book,$fixed_asset_status,$balance_date,$acq_date,$estlf,$salv_date,$slip_index) {
		$dbconn 	= $this->connectDB('paperless_system');
		$date=date('Y-m-d H:i:s');
		$params 	= array($fixed_assets_no,$des,$acc_code,$location,$vendor,$section,$invoice_no,$boi_section,$boi_project,$start_date,$qty,$acq_cost,$acc_dep,$net_book,$fixed_asset_status,$balance_date,$acq_date,$estlf,$salv_date,$date,$slip_index);
		$query 		= "insert into fixed_assets_deposed_save values ( $1, $2, $3,$4,$5,$6,$7,$8,$9,$10,$11,$12,$13,$14,$15,$16,$17,$18,$19,$20,$21);";
		
		$result_flag = pg_query_params($dbconn, $query, $params);
		
		if ($result_flag){
			return true;
		}else {
			return false;
		}
    }
}

class update extends accessDB {
	
	/////////////////////////////////////////////////////////////////////////////////
	//description : Change from current vendor to unknown              			   //
	//input       : v_code			 											   //
	//output      : boolean						       							   //
	/////////////////////////////////////////////////////////////////////////////////
	function update_register_report($slip_index,$type_index,$regis_report){
		$dbconn = $this->connectDB('paperless_system');
		$params = array($slip_index,$type_index,$regis_report);
		$query	= "update fixed_assets_deposed_detail set register_report = $3 where slip_index = $1 and type_index=$2";
	
		$result = pg_query_params($dbconn, $query, $params);
	
		if ($result){
			return true;
		} else {
			return false;
		}
	}

	function update_ext_reason($slip_index,$type_index,$ext,$reason){
		$dbconn = $this->connectDB('paperless_system');
		$params = array($slip_index,$type_index,$ext,$reason);
		$query	= "update fixed_assets_deposed_detail set ext_no = $3, reason = $4 where slip_index = $1 and type_index=$2";
	
		$result = pg_query_params($dbconn, $query, $params);
	
		if ($result){
			return true;
		} else {
			return false;
		}
	}

	function update_boi($slip_index,$type_index,$asset_no,$boi_regis){
		$dbconn = $this->connectDB('paperless_system');
		$params = array($slip_index,$type_index,$asset_no,$boi_regis);
		$query	= "update fixed_assets_deposed_data set boi = $4 where slip_index = $1 and type_index=$2 and asset_no=$3";
	
		$result = pg_query_params($dbconn, $query, $params);
	
		if ($result){
			return true;
		} else {
			return false;
		}
	}
	function update_read($slip_index,$type_index,$userIndex)
	{
		$dbconn = $this->connectDB('request_slip_test');
		$params = array($slip_index,$type_index,$userIndex);
		$query	= "update approve_alarm set read = 1 where slip_index = $1 and type_index=$2 and user_index=$3";
	
		$result = pg_query_params($dbconn, $query, $params);
	
		if ($result){
			return true;
		} else {
			return false;
		}
	}

	function update_delete_att_file($slip_index,$type_index,$file_name,$text)
	{
		$dbconn = $this->connectDB('paperless_system');
		$text= $text.'['.date("Y/m/d h:i:s").']';
		$params = array($slip_index,$type_index,$file_name,$text);
		$query	= "update paperless_attach_file set file_name = $4,real_name=null where slip_index = $1 and type_index=$2 and real_name=$3";
	
		$result = pg_query_params($dbconn, $query, $params);
	
		if ($result){
			return true;
		} else {
			return false;
		}
	}

}

class delete extends accessDB {
	/////////////////////////////////////////////////////////////////////////////////
	//description : Delete value detail      					                   //
	//input       : eq_index, v_code, unit_price			  					   //
	//output      : boolean		 	    									   	   //
	/////////////////////////////////////////////////////////////////////////////////
	function delete_approved ($slip_index, $type_index,$user_index){
	
		$dbconn = $this->connectDB('request_slip_test');
		$params = array($slip_index, $type_index,$user_index);
		$query = "delete from approve
				  where slip_index = $1
		          and type_index = $2 and user_index=$3;";
	
		$result = pg_query_params($dbconn, $query, $params);
	
		if ($result){
			return true;
		} else {
			return false;
		}
	
	}
	function delete_approved_all($slip_index,$type_index)
    {
        $dbconn = $this->connectDB('request_slip_test');
		$params = array($slip_index, $type_index);
		$query = "delete from approve
				  where slip_index = $1
		          and type_index = $2 ;";
	
		$result = pg_query_params($dbconn, $query, $params);
	
		if ($result){
			return true;
		} else {
			return false;
		}
	}
	
	function delete_approved_to($slip_index,$type_index,$num)
    {
        $dbconn = $this->connectDB('request_slip_test');
		$params = array($slip_index, $type_index,$num);
		$query = "delete from approve
				  where slip_index = $1
		          and type_index = $2 and num>= $3 ;";
	
		$result = pg_query_params($dbconn, $query, $params);
	
		if ($result){
			return true;
		} else {
			return false;
		}
    }
}

class get extends accessDB{
	
	
	/////////////////////////////////////////////////////////////////////////////////
	//description : get equipment list of selected location                        //
	//input       : location Name												   //
	//output      : equipment detail											   //
	/////////////////////////////////////////////////////////////////////////////////
	function get_slip_index($type_index){
		$dbconn = $this->connectDB('request_slip_test');
		$params = array($type_index);
		$query = "Select slip_index from slip_index where type_index=$1 order by slip_index desc limit 1";
		$result = pg_query_params($dbconn, $query, $params);
		$Value_eq_list = pg_fetch_all($result);
		return $Value_eq_list;
	}

	function get_user_index($userid){
		$dbconn = $this->connectDB('user_list');
		$params = array($userid);
		$query = "Select user_index from user_list where id=$1";
		$result = pg_query_params($dbconn, $query, $params);
		$Value_eq_list = pg_fetch_all($result);
		return $Value_eq_list;
	}

	function get_slip_data_by_index($slip_index){
		$dbconn = $this->connectDB('paperless_system');
		$params = array($slip_index);
		$query = "Select * from fixed_assets_deposed_data where slip_index=$1";
		$result = pg_query_params($dbconn, $query, $params);
		$Value_eq_list = pg_fetch_all($result);
		return $Value_eq_list;
	}

	function get_attech_file($slip_index,$type_index){
		$dbconn = $this->connectDB('paperless_system');
		$params = array($slip_index,$type_index);
		$query = "Select * from paperless_attach_file where slip_index=$1 and type_index=$2";
		$result = pg_query_params($dbconn, $query, $params);
		$Value_eq_list = pg_fetch_all($result);
		return $Value_eq_list;
	}

	function get_slip_head_by_index($slip_index){
		$dbconn = $this->connectDB('paperless_system');
		$params = array($slip_index);
		$query = "Select * from fixed_assets_deposed_detail where slip_index=$1";
		$result = pg_query_params($dbconn, $query, $params);
		$Value_eq_list = pg_fetch_all($result);
		return $Value_eq_list;
	}

	function get_request_user($slip_index,$type_index){
		$dbconn = $this->connectDB('request_slip_test');
		$params = array($slip_index,$type_index);
		$query = 'select * from approve_flow where slip_index=$1 and type_index=$2 order by num';
		$result = pg_query_params($dbconn, $query, $params);
		$Value_eq_list = pg_fetch_all($result);
		return $Value_eq_list;
	}

	function get_receive_user($slip_index,$type_index){
		$dbconn = $this->connectDB('request_slip_test');
		$params = array($slip_index,$type_index);
		$query = 'select * from approve_sec where slip_index=$1 and type_index=$2 order by num';
		$result = pg_query_params($dbconn, $query, $params);
		$Value_eq_list = pg_fetch_all($result);
		return $Value_eq_list;
	}
	
	function get_user_name($user_index){
		$dbconn = $this->connectDB('user_list');
		$params = array($user_index);
		$query = 'select * from user_list where user_index=$1';
		$result = pg_query_params($dbconn, $query, $params);
		$Value_eq_list = pg_fetch_all($result);
		return $Value_eq_list;
	}

	function get_save_fixed_assets_no($fixed_assets_no){
		$dbconn = $this->connectDB('paperless_system');
		$params = array($fixed_assets_no);
        $query = 'select fixed_assets_no,des,invoice_no,start_date,acq_cost,acc_dep,net_book from fixed_assets_deposed_save where fixed_assets_no=$1';
		$result = pg_query_params($dbconn, $query, $params);
		$Value_eq_list = pg_fetch_all($result);
		return $Value_eq_list;
	}

	function get_fixed_assets_no($fixed_assets_no){
		$dbconn = $this->connectDB('paperless_system');
		$params = array($fixed_assets_no);
        $query = 'select fixed_assets_no,des,invoice_no,start_date,acq_cost,acc_dep,net_book from fix_assets_list where fixed_assets_no=$1';
		$result = pg_query_params($dbconn, $query, $params);
		$Value_eq_list = pg_fetch_all($result);
		return $Value_eq_list;
	}
	
	function get_fixed_assets_all_no($fixed_assets_no){
		$dbconn = $this->connectDB('paperless_system');
		$params = array($fixed_assets_no);
        $query = 'select * from fix_assets_list where fixed_assets_no=$1';
		$result = pg_query_params($dbconn, $query, $params);
		$Value_eq_list = pg_fetch_all($result);
		return $Value_eq_list;
    }

	function get_approve_status($slip_index,$type_index,$num){
		$dbconn = $this->connectDB('request_slip_test');
		$params = array($slip_index,$type_index,$num);
        $query = 'select * from approve where slip_index=$1 and num=$3 and type_index=$2';
		$result = pg_query_params($dbconn, $query, $params);
		$Value_eq_list = pg_fetch_all($result);
		return $Value_eq_list;
	}

	function get_second_approve_status($slip_index,$type_index,$num){
		$dbconn = $this->connectDB('request_slip_test');
		$params = array($slip_index,$type_index,$num);
        $query = 'select * from approve where slip_index=$1 and type_index=$2 and num=$3';
		$result = pg_query_params($dbconn, $query, $params);
		$Value_eq_list = pg_fetch_all($result);
		return $Value_eq_list;
	}

	function get_max_approve_at($slip_index,$type_index){
		$dbconn = $this->connectDB('request_slip_test');
		$params = array($slip_index,$type_index);
        $query = 'select num from approve where slip_index=$1 and type_index=$2 order by num desc limit 1';
		$result = pg_query_params($dbconn, $query, $params);
		$Value_eq_list = pg_fetch_all($result);
		return $Value_eq_list;
	}

	function get_president_approve_status($slip_index,$type_index){
		$dbconn = $this->connectDB('request_slip_test');
		$num=7;
		$params = array($slip_index,$type_index,$num);
        $query = 'select * from approve where slip_index=$1 and type_index=$2 and num=$3';
		$result = pg_query_params($dbconn, $query, $params);
		$Value_eq_list = pg_fetch_all($result);
		return $Value_eq_list;
	}

	function get_sequence_approve_req($slip_index,$type_index,$user_index){
		$dbconn = $this->connectDB('request_slip_test');
		$params = array($slip_index,$type_index,$user_index);
        $query = 'select * from approve_flow where slip_index=$1 and approve=$3 and type_index=$2';
		$result = pg_query_params($dbconn, $query, $params);
		$Value_eq_list = pg_fetch_all($result);
		return $Value_eq_list;
	}

	function get_sequence_approve_rec($slip_index,$type_index,$user_index){
		$dbconn = $this->connectDB('request_slip_test');
		$params = array($slip_index,$type_index,$user_index);
        $query = 'select * from approve_sec where slip_index=$1 and approve=$3 and type_index=$2';
		$result = pg_query_params($dbconn, $query, $params);
		$Value_eq_list = pg_fetch_all($result);
		return $Value_eq_list;
	}

	function get_status_approve($slip_index,$type_index,$user_index){
		$dbconn = $this->connectDB('request_slip_test');
		$params = array($slip_index,$type_index,$user_index);
        $query = 'select * from approve_sec where slip_index=$1 and approve=$3 and type_index=$2';
		$result = pg_query_params($dbconn, $query, $params);
		$Value_eq_list = pg_fetch_all($result);
		return $Value_eq_list;
	}

	function get_count_approve_req($slip_index,$type_index){
		$dbconn = $this->connectDB('request_slip_test');
		$params = array($slip_index,$type_index);
        $query = 'select * from approve_flow where slip_index=$1 and type_index=$2 order by num';
		$result = pg_query_params($dbconn, $query, $params);
		$Value_eq_list = pg_fetch_all($result);
		return $Value_eq_list;
	}

	function get_count_approve_sec($slip_index,$type_index){
		$dbconn = $this->connectDB('request_slip_test');
		$params = array($slip_index,$type_index);
        $query = 'select * from approve_sec where slip_index=$1 and type_index=$2 order by num';
		$result = pg_query_params($dbconn, $query, $params);
		$Value_eq_list = pg_fetch_all($result);
		return $Value_eq_list;
	}

	function get_president_check($slip_index,$type_index,$num){
		$dbconn = $this->connectDB('request_slip_test');
		$params = array($slip_index,$type_index,$num);
        $query = 'select * from approve where slip_index=$1 and type_index=$2 and num=$3';
		$result = pg_query_params($dbconn, $query, $params);
		$Value_eq_list = pg_fetch_all($result);
		return $Value_eq_list;
	}

	function get_section_name($user_index){
		$dbconn = $this->connectDB('user_list');
		$params = array($user_index);
        $query = 'select * from user_list inner join section_control on section_control.section_index=user_list.section_index where user_index=$1';
		$result = pg_query_params($dbconn, $query, $params);
		$Value_eq_list = pg_fetch_all($result);
		return $Value_eq_list;
	}

	function get_section_sec_id($sec_id){
		$dbconn = $this->connectDB('user_list');
		$params = array($sec_id);
        $query = 'select * from section_control where section_index=$1';
		$result = pg_query_params($dbconn, $query, $params);
		$Value_eq_list = pg_fetch_all($result);
		return $Value_eq_list;
	}

	function get_approved_list($slip_index,$type_index)
	{
		$dbconn = $this->connectDB('request_slip_test');
		$params = array($slip_index,$type_index);
        $query = 'select * from approve where slip_index=$1 and type_index=$2 order by num';
		$result = pg_query_params($dbconn, $query, $params);
		$Value_eq_list = pg_fetch_all($result);
		return $Value_eq_list;
	}
	function get_reject_status($index_slip,$type_index,$userIndex)
	{
		$dbconn = $this->connectDB('request_slip_test');
		$params = array($index_slip,$type_index,$userIndex);
        $query = "select * from status_history where slip_index=$1 and type_index=$2 and user_index=$3 and status like 'reject%'";
		$result = pg_query_params($dbconn, $query, $params);
		$Value_eq_list = pg_fetch_all($result);
		return $Value_eq_list;
	}

	function get_approved_status($index_slip,$type_index,$userIndex)
	{
		$dbconn = $this->connectDB('request_slip_test');
		$params = array($index_slip,$type_index,$userIndex);
        $query = "select * from status_history where slip_index=$1 and type_index=$2 and user_index=$3 and status like 'Approved by%'";
		$result = pg_query_params($dbconn, $query, $params);
		$Value_eq_list = pg_fetch_all($result);
		return $Value_eq_list;
	}

	function get_skip_status($index_slip,$type_index,$user_index)
	{
		$dbconn = $this->connectDB('request_slip_test');
		$params = array($index_slip,$type_index,$user_index);
        $query = "select * from status_history where slip_index=$1 and type_index=$2 and user_index=$3 and status like 'skip%'";
		$result = pg_query_params($dbconn, $query, $params);
		$Value_eq_list = pg_fetch_all($result);
		return $Value_eq_list;
	}
	
	/////////////////////////////////////////////////////////////////////////////////
	//description : get equipment name and index list	                           //
	//input       : void														   //
	//output      : equipment name and index									   //
	/////////////////////////////////////////////////////////////////////////////////
	function get_requesst_user(){
		$dbconn = $this->connectDB('Partrequest_slip_test_Trace');
		$query = 'select * from approve_flow where slip_index=$1 and type_index=$2';
		$result = pg_query($dbconn, $query);
	
		$eq_list = pg_fetch_all($result);
	
		return $eq_list;
	}
	
	function get_slip_creater($slip_index,$type_index){
		$dbconn = $this->connectDB('request_slip_test');
		$params = array($slip_index,$type_index);
		$query = "Select * from approve_flow where slip_index=$1 and type_index=$2 and num=1";
		$result = pg_query_params($dbconn, $query, $params);
		$Value_eq_list = pg_fetch_all($result);
		return $Value_eq_list;
	}

	function get_comment($slip_index,$type_index){
		$dbconn = $this->connectDB('request_slip_test');
		$params = array($slip_index,$type_index);
		$query = "Select * from comment where slip_index=$1 and type_index=$2 ";
		$result = pg_query_params($dbconn, $query, $params);
		$Value_eq_list = pg_fetch_all($result);
		return $Value_eq_list;
	}
    
}

class check extends accessDB {
	/////////////////////////////////////////////////////////////////////////////////
	//description : check exsitence of eq at selected location                     //
	//input	      : location name                                                  //
	//output      : boolean                          							   //
	/////////////////////////////////////////////////////////////////////////////////
	function checkvendor ($vendor){
		$dbconn = $this->connectDB('Part_Trace');	
		$params = array($vendor);
	
		$query = "select icc_eq_list.eq_index from icc_eq_list, icc_value_detail
				  where icc_eq_list.eq_index = icc_value_detail.eq_index
				  and icc_eq_list.location_index = $1 limit 1";
	
		$result = pg_query_params($dbconn, $query, $params);
	
		$eq_index = array();
		while ($row = pg_fetch_array($result)){
			array_push($eq_index, $row['eq_index']);
		}
	
		if (isset($eq_index[0])){
			return true;
		} else {
			return false;
		}
	
	}
}






?>

