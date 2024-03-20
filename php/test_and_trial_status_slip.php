<?php 
	include '../Paperless_controller/test_and_trial_request_sql.php';
	include '../Paperless_control.php';
	date_default_timezone_set("Asia/Bangkok");
	session_start();

	$type_index=54;
	$paperless_control=new paperless_control();
	$get=new get();
	$update=new update();
	$insert=new insert();

	$request_detail=$get->get_all_request_list();
	$alarm_list = $paperless_control->get_unapprove_alarm(54);
	$list_user = '(';
	for ($i=0; $i < count($alarm_list) ; $i++) { 
		if($i)
		{
			$list_user = $list_user.',';
		}
		$list_user = $list_user.$alarm_list[$i]['user_index'];
	}
	$_SESSION['list_user'] = $list_user.')';
	$user_in_list = $paperless_control->get_user_in_list();

	if((isset($_POST['user_list'])) and ($_POST['user_list'] != ''))
	{
		$user_index = $paperless_control->get_user_index($_POST['user_list']);
		$alarm = $paperless_control->get_alarm($user_index[0]['user_index'],$type_index);
		$slip_index_list = '';
		for ($i=0; $i < count($alarm) ; $i++) { 
			if($i)
			{
				$slip_index_list = $slip_index_list.',';
			}
			$slip_index_list = $slip_index_list.$alarm[$i]['slip_index'];
		}
		$request_detail = $get->get_slip_head_by_in($slip_index_list);
	}
	else
	{
		if((isset($_POST['model'])) and ($_POST['model']!=''))
		{
			$_SESSION['model']=$_POST['model'];
		}
		if((isset($_POST['atr'])) and ($_POST['atr']!=''))
		{
			$_SESSION['atr']=$_POST['atr'];
		}
		if((isset($_POST['drawing'])) and ($_POST['drawing']!=''))
		{
			$_SESSION['drawing']=$_POST['drawing'];
	
		}
	
		if((isset($_POST['start_date'])) and (($_POST['start_date']!='') or ($_POST['drawing']!='') or ($_POST['model']!='') or ($_POST['atr']!='')))
		{
			$_SESSION['end']=$_POST['end_date'];
			$_SESSION['start']=$_POST['start_date'];
			$request_detail=$get->get_slip_by_request_date($_POST['start_date'],$_POST['end_date']);
			unset($_SESSION['model'],$_SESSION['drawing'],$_SESSION['atr']);
		}
	}


	
	

	?>
<!DOCTYPE html> 
<html>

	<head>
	    <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<style type="text/css">
			body{
				font-family 		: sans-serif;
				background-color	: #CBFFD3;
			}

			.div1 {
                width 		: 100%;
                
                min-width 		: 300px;
                text-align 	: center;
                margin 		: 0px auto;
			}

            #login_form {
            font-family: Arial, Helvetica, sans-serif;
            border-collapse: collapse;
            width: 100%;
			}

            #login_form td, #login_form th {
            border: 1px solid #ddd;
            padding: 8px;
            }

            #login_form tr:nth-child(even){background-color: #f2f2f2;}

            #login_form tr:hover {background-color: #ddd;}

            #login_form th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #04AA6D;
            color: white;
            }
			<?php
			if(isset($_GET['stock']))
			{
				echo'
				#login_form {
					border-collapse: collapse;
				  }	
				#login_form th{
				border-style:solid;
				}
				';
				  
			}
			?>
		</style>
		<link rel="stylesheet" href="./css/jquery-ui1.css">
		<script src="../../js/jquery-1.9.1.js"></script>
		<script src="../../js/jquery-ui.js"></script>
		<script src="../../js/jquery-latest.min.js"></script>
		<link rel="stylesheet" href="./css/style.css">

		
		<link rel="stylesheet" type="text/css" href="../../autocomplete/jquery.autocomplete.css" />
		<script type="text/javascript" src="../../autocomplete/jquery.js"></script>
		<script type="text/javascript" src="../../autocomplete/jquery.autocomplete.js"></script>
		
		<script type="text/javascript">
		function open_slip(no)
		{
			window.open('../format/test_and_trial_request_form.php?inboxslip='+no,'MyWindow','width=1000,height=700');
		}
		function home_page()
		{
			window.location.href="../../header.php";
		}
		function whatnew()
		{
			window.open('../Image/WhatNew1.png','blank','width=800,height=800');
		}
		var newVersion = jQuery.noConflict();
		newVersion(document).ready(function(){
		newVersion("#supplier").autocomplete("../auto_complete/po_supplier_list.php", {
				selectFirst: true
			});
		});
		</script>

	</head>
	 <body>
		<div  class = 'div1'>
            <form action = "./test_and_trial_status_slip.php" method = "post" name = "login_form">

				<table align="center" class = 'filter'>
					<tr>
						<td>
							<img src="../../icons/png/24x24/back-gf66daa028_640.png" width=50 height=50 onclick="home_page()">
						</td>
						<td align = 'center' valign = 'middle' >
							<font style = "font-size : 22px">
                            
							<label><font style = "font-size : 18px">Start Date : </font></label><input type='date' name='start_date' value="<?php echo $_SESSION['start'];?>">
							<label><font style = "font-size : 18px">End Date : </font></label><input type='date' name='end_date' value="<?php echo $_SESSION['end'];?>">
							<label><font style = "font-size : 18px">Drawing : </font></label><input type='text' id='drawing' name='drawing'>
							<label><font style = "font-size : 18px">Model : </font></label><input type='text' id='model' name='model'>
							<label><font style = "font-size : 18px">ATR No. : </font></label><input type='text' name='atr'>
							<b> OR </b>
							<label><font style = "font-size : 18px">Process : </font></label><input list="user_lists" name="user_list" id="user_list">
							<datalist id="user_lists">
								<?php
								for ($i=0; $i < count($user_in_list); $i++) { 
									echo '<option value="'.$user_in_list[$i]['id'].'" label="'.$user_in_list[$i]['name'].' '.$user_in_list[$i]['surname'].'">';
								}
								?>
								
							</datalist>
							<input type="submit" value="Search">
							<img src="../../icons/png/pngtree-new-labels-vector-simple-icon-png-image_9133939.png" onclick="whatnew()" width="50" height="50">
							</font>
						</td>
					</tr>
				</table>
			<?php
				if(isset($_REQUEST['load']))
				{
					echo '<div id="hidepage2" style="display:block;padding-top:0%" align="center" width="100%" height="100%">
					<IMG SRC="../../loading/Spin-1s-200px.gif" width="25%" height="50%" BORDER="0" ALT=""><br>
				</div>
				<script>window.location.href="./test_and_trial_status_slip.php";</script>
				';
				}
				else
				{
?>
						<table align='center' class = 'login_form' >
							
							<tr height = '40px' bgcolor = '#A4C6FF'>
								
								<td align = 'center' style=''>
									<font style = "font-size : 25px">
									Test & Trial Status slip
									</font>
								</td>
							
							</tr>
							

							
							<tr>
								
								<td align = 'center' valign = 'middle' >
									
									<font style = "font-size : 22px;">
										<?php
										$requestor_name=array();
										$requestor_index=array();
											echo '<table id="login_form">
											<tr >
												<th><font style = "font-size : 15px">No.</font></th>
												<th style="text-align:center"><font style = "font-size : 15px">Drawing</font></th>
												<th style="text-align:center"><font style = "font-size : 15px">Model</font></th>
												<th style="text-align:center"><font style = "font-size : 15px">ATR No.</font></th>
												<th style="text-align:center"><font style = "font-size : 15px">Requestor</font></th>
												<th style="text-align:center"><font style = "font-size : 15px">Request date</font></th>
												<th style="text-align:center"><font style = "font-size : 15px">Pending</font></th>
												<th style="text-align:center"><font style = "font-size : 15px">Status</font></th>
												<th><font style = "font-size : 15px">Document No</font></th>
											</tr>';
											for ($i=0; $i <count($request_detail) ; $i++) { 
												if($i>0)
												{
													for ($j=0; $j <count($requestor_index) ; $j++) { 
														if($request_detail[$i]['user_index']==$requestor_index[$j])
														{
															$name=$requestor_name[$j];
															break;
														}
														elseif($j==(count($requestor_index)-1))
														{
															$user_data=$paperless_control->get_section_name($request_detail[$i]['user_index']);
															$requestor_index[count($requestor_index)]=$request_detail[$i]['user_index'];
															$requestor_name[count($requestor_name)]=$user_data[0]['name'];
															$name=$user_data[0]['name'];
															break;
														}
													}
												}
												else
												{
													$user_data=$paperless_control->get_section_name($request_detail[$i]['user_index']);
													$requestor_index[0]=$request_detail[$i]['user_index'];
													$requestor_name[0]=$user_data[0]['name'];
													$name=$user_data[0]['name'];
												}

												
												$approve_list=$paperless_control->get_approved_list($request_detail[$i]['slip_index'],$type_index);
												$approve_flow=$paperless_control->get_count_approve_req($request_detail[$i]['slip_index'],$type_index);
												$approve_sec=$paperless_control->get_count_approve_sec($request_detail[$i]['slip_index'],$type_index);
												$status=$paperless_control->get_status($request_detail[$i]['slip_index'],$type_index);
												// $status = explode(' by ',$status[0]['status']);
												$approve=count($approve_flow)+count($approve_sec);
												$style= 'border-style:groove;color:green';
												
												echo'									
												<tr align="center" class="status_list">
													<td style="border-style:groove;font-size:large"><font style = "font-size : 15px"><a href="javascript:open_slip('.$request_detail[$i]['slip_index'].')">'.$request_detail[$i]['slip_index'].'</a></font></td>
													<td style="border-style:groove;font-size:large"><font style = "font-size : 15px">'.$request_detail[$i]['drawing'].'</font></td>
													<td style="border-style:groove;font-size:large"><font style = "font-size : 15px">'.$request_detail[$i]['model'].'</font></td>
													<td style="border-style:groove;font-size:large"><font style = "font-size : 15px">'.$request_detail[$i]['pc'].'</font></td>
													<td style="border-style:groove;font-size:large"><font style = "font-size : 15px">'.$name.'</font></td>
													<td style="border-style:groove;font-size:large"><font style = "font-size : 15px">'.$request_detail[$i]['request_date'].'</font>
													<td style="border-style:groove;font-size:large"><font style = "font-size : 15px">'.$status[0]['status'].'</font></td>
													<td style="border-style:groove;font-size:large">
													';
													$process = $get->get_process($request_detail[$i]['slip_index']);
													$process_count = explode('/Row/',$process[0]['process']);
													$max_approve=2;
													$num_start = 4;
													$end_approve = 0;
													if(count($process_count)>1)
													{
														$max_approve=$max_approve + count($process_count);
													}
													$approve_count = 0;
													if((isset($approve_list[0])) and (end($approve_list)['num'] >= 10))
													{
														$approve_count = end($approve_list)['num'] / 3.9;
														$end_approve = 1;
													}
													elseif((isset($approve_list[0])) and (end($approve_list)['num'] >= 5))
													{
														$approve_count = 1;
														$end_approve = 1;
													}
													elseif((isset($approve_list[0])) and (end($approve_list)['num'] >= 3))
													{
														$end_approve = 1;
													}
													$approve_count = floor($approve_count);
													
													for ($j=$approve_count; $j <$max_approve ; $j++) { 
														if($j)
														{
															$num_start = $num_start + 3;
														}
														if($end_approve)
														{
															if($approve_count)
															{
																if($approve_count > 2)
																{
																	$approve_mod = ($approve_count + 1) % 2;
																	$approve_round = $approve_count / 3;
																	for ($k=0; $k <$approve_round ; $k++) { 
																		$approve_count = 2;
																		echo '<img src="../../icons/png/'.($approve_count + 1).'.png" width="'.((20 * ($approve_count + 1) + (15 * $approve_count) + 10)).'" height="20">';
																		echo '<img style="margin:2px;" src="../../icons/ico/forward.ico" width="15" height="15">';
																	}

																	if($approve_mod>1)
																	{
																		echo '<img src="../../icons/png/'.($approve_count + 1).'.png" width="'.((20 * ($approve_count + 1) + (15 * $approve_count) + 10)).'" height="20">';
																	}
																	else
																	{
																		echo '<img src="../../icons/png/1.png" width="20" height="20">';
																	}
																}
																else
																{
																	echo '<img src="../../icons/png/'.($approve_count + 1).'.png" width="'.((20 * ($approve_count + 1) + (15 * $approve_count) + 10)).'" height="20">';
																}
															}
															else
															{
																echo '<img src="../../icons/png/'.($approve_count + 1).'.png" width="20" height="20">';
															}
														
															$end_approve = 0;
															$approve_count = 0;
														}
														else
														{
															echo '<img src="../../icons/png/lightgrey.png" width="20" height="20">';
														}
														if($j!=($max_approve-1))
														{
															echo '<img style="margin:2px;" src="../../icons/ico/forward.ico" width="15" height="15">';
														}
													}
													echo '
													</td>
													<td style="border-style:groove;font-size:large"><font style = "font-size : 15px">'.$request_detail[$i]['doc_no'].'</font></td>
												</tr>';
											}
											echo'</table>';
										
										?>
										
									</font>	
								
								</td>
								
							</tr>
								
								<td align = 'center' >
								
									
										<?php
										if((isset($_POST['qr_code'])) and (isset($_POST['date'])) and ($_POST['date']==''))
										{
											echo'<font style="color: red;">Please select date.</font>';
										}
										elseif(isset($_SESSION['login_result']))
										{
											echo'<font style="color:red">Wrong Id or Id not in system.</font>';
											unset($_SESSION['login_result']);
										}
										?>

								
								</td>
								

							</tr>
							
							<tr height = '20px'><td></td></tr>
						</table>
<?php
				}
			?>




		  	</form>
		  
			<br>
			<br>
			<br>
			<a>
			</a>
		</div>
	</body>

</html>
