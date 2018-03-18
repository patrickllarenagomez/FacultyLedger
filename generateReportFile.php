<html>
	<head>
<!-- 		<link rel="shortcut icon" type="image/x-icon" href="<?php echo base_url();?>media/images/favicon.ico">
		<link rel="stylesheet" type="text/css" href="<?= base_url() ?>media/css/bootstrap.min.css">
		<link rel="stylesheet" type="text/css" href="<?= base_url() ?>media/css/styles.css"> -->
	</head>
	<body>
		<div id="main">
			<div id="">
				<div id="">
					<div id="">
						<div class="" style="width:900px; margin:0 auto;">
						<!-- 	<span style="text-align:center;"><img src="<?php echo base_url('media/images/logo_oneliner.png'); ?>"></a></span>
						 --></div>
					</div>
				</div>
			</div>
			<div id="main_info">
				<div id="main_body" class="align_left" style="width:1024px;">
					<div class="body_title">
						<span class="red_text">COMMISSION CLAIM LIST</span>
						<hr>
					</div>
				<?php
					$monthStart = new DateTime("first day of last month");
					$monthEnd = new DateTime("last day of last month");
					$MS = $monthStart->format('M d, Y');
					$ME = $monthEnd->format('M d, Y');
				?>

						<?php 
					// 	$rows ="";
					// 	$userArr = array();

					// 	$this->output->enable_profiler(false);
					// 	if(isset($getSalesSummary)){
					// 		foreach($getSalesSummary as $gsUser){
					// 			$userArr[$gsUser[USERID]]['totalcollectedamount'] = 0;
					// 			$userArr[$gsUser[USERID]]['tcnas'] = 0;
					// 			$userArr[$gsUser[USERID]]['tcoas'] = 0;
					// 			$userArr[$gsUser[USERID]]['tcorg'] = 0;
					// 			$userArr[$gsUser[USERID]]['totalamountorg'] = 0;
					// 			$userArr[$gsUser[USERID]]['totalamountnas'] = 0;
					// 			$userArr[$gsUser[USERID]]['totalamountoas'] = 0;
					// 			$userArr[$gsUser[USERID]]['totalcommission'] = 0;
					// 			$totalamountpaid = 0;
					// 			$totalamountorg = 0;
					// 			$totalamountnas = 0;
					// 			$totalamountoas = 0;
					// 			$totalcommission = 0;
					// 			$totalcountorg = 0;
					// 			$totalcountnas = 0;
					// 			$totalcountoas = 0;	
					// 		}
							
					// 	foreach($getSalesSummary as $gss){
					// 		$userArr[$gss[USERID]]['userID'] = $gss[USERID];
					// 		$userArr[$gss[USERID]]['totalcollectedamount'] += ($gss[AMOUNTPAID] + $gss[TAX]);
					// 		$userArr[$gss[USERID]]['tcnas'] += (isset($gss[CATEGORYID]) && $gss[CATEGORYID] == 1) ? 1 : 0;
					// 		$userArr[$gss[USERID]]['tcoas'] += (isset($gss[CATEGORYID]) && $gss[CATEGORYID] == 2) ? 1 : 0;
					// 		$userArr[$gss[USERID]]['totalamountnas'] += (isset($gss[CATEGORYID]) && $gss[CATEGORYID] == 1) ? ($gss[AMOUNTPAID] + $gss[TAX]) : 0;
					// 		$userArr[$gss[USERID]]['totalamountoas'] +=  (isset($gss[CATEGORYID]) && $gss[CATEGORYID] == 2) ? ($gss[AMOUNTPAID] + $gss[TAX]) : 0;
					// 		//for unique values using clientname
					// 		//==========================================================================
					// 		//$userArr[$gss[USERID]]['clients'][str_replace(" ", "", $gss[CLIENTNAME])] = str_replace(" ", "", $gss[CLIENTNAME]);
					// 		//$userArr[$gss[USERID]]['tcorg'] = count($userArr[$gss[USERID]]['clients']);
					// 		//==========================================================================

					// 		$userArr[$gss[USERID]]['totalcommission'] +=  (isset($gss[USERCOMMISSION]) ? $gss[USERCOMMISSION] : 0);
					// 		$userArr[$gss[USERID]]['tcorg'] = $userArr[$gss[USERID]]['tcnas'] + $userArr[$gss[USERID]]['tcoas'];
					// 		$userArr[$gss[USERID]]['totalamountorg'] = $userArr[$gss[USERID]]['totalamountnas'] + $userArr[$gss[USERID]]['totalamountoas'];
					// 		$userArr[$gss[USERID]]['percentcountorg'] = ((($userArr[$gss[USERID]]['tcoas'] + $userArr[$gss[USERID]]['tcnas'])/($userArr[$gss[USERID]]['tcoas'] + $userArr[$gss[USERID]]['tcnas']) * 100)."%");
					// 		$userArr[$gss[USERID]]['percentcountnas'] = round(($userArr[$gss[USERID]]['tcnas']/$userArr[$gss[USERID]]['tcorg']) * 100, 2)."%";
					// 		$userArr[$gss[USERID]]['percentcountoas'] = round(($userArr[$gss[USERID]]['tcoas']/$userArr[$gss[USERID]]['tcorg']) * 100, 2)."%";
					// 		$userArr[$gss[USERID]]['percentamountorg'] = ((($userArr[$gss[USERID]]['totalamountnas'] + $userArr[$gss[USERID]]['totalamountoas'])/($userArr[$gss[USERID]]['totalamountnas'] + $userArr[$gss[USERID]]['totalamountoas']) * 100)."%");
					// 		$userArr[$gss[USERID]]['percentamountnas'] = round(($userArr[$gss[USERID]]['totalamountnas']/$userArr[$gss[USERID]]['totalamountorg']) * 100, 2)."%";
					// 		$userArr[$gss[USERID]]['percentamountoas'] = round(($userArr[$gss[USERID]]['totalamountoas']/$userArr[$gss[USERID]]['totalamountorg']) * 100, 2)."%";
							
					// 	}
					// }
					// 		$salesreport = "";
					// 		$no = 1;
					// 		foreach($userArr as $user){
					// 			$class = ($no % 2 == 1) ? 'class="oddRow"' : '';
								
					// 			$salesreport .= '<tr '.$class.'>
					// 					<td>'.$no.'</td>
					// 					<td style="text-align:center">'.$name[$user[USERID]].'</td>
					// 					<td style="text-align:center">'.formatNumber($quota[$user[USERID]]).'</td>
					// 					<td style="text-align:right">'.formatNumber($user['totalcollectedamount']).'</td>
					// 					<td style="text-align:center">'.($quota[$user[USERID]] <= $user['totalcollectedamount'] ? formatNumber($user['totalcommission']) : "0.00").'</td>
					// 					<td style="text-align:right">'.formatNumber($user['totalamountorg']).'</td>
					// 					<td style="text-align:center">'.$user['tcorg'].'</td>
					// 					<td style="text-align:right">'.formatNumber($user['totalamountnas']).'</td>
					// 					<td style="text-align:right">'.$user['percentamountnas'].'</td>
					// 					<td style="text-align:center">'.$user['tcnas'].'</td>
					// 					<td style="text-align:right">'.$user['percentcountnas'].'</td>
					// 					<td style="text-align:right">'.formatNumber($user['totalamountoas']).'</td>
					// 					<td style="text-align:right">'.$user['percentamountoas'].'</td>
					// 					<td style="text-align:center">'.$user['tcoas'].'</td>
					// 					<td style="text-align:right">'.$user['percentcountoas'].'</td>
					// 					<td style="text-align:center">'.($quota[$user[USERID]] <= $user['totalcollectedamount'] ? "Ready for claiming": DEFAULTDD).'</td>
					// 			</tr>';
					// 			$totalamountpaid += $user['totalcollectedamount'];
					// 			$totalamountorg += $user['totalamountorg'];
					// 			$totalamountnas += $user['totalamountnas'];
					// 			$totalamountoas += $user['totalamountoas'];
					// 			$totalcountorg += $user['tcorg'];
					// 			$totalcountnas += $user['tcnas'];
					// 			$totalcountoas += $user['tcoas'];
					// 			if($quota[$user[USERID]] <= $user['totalcollectedamount']){
					// 			$totalcommission += $user['totalcommission'];
					// 			}
					// 			$no++;
							// }
				?> 

<!-- 					<div id="">
						<table style="width:100%;">
							<tr>
								<td style="width:50%;">
									<span>Date:</span><br>
									<span class="strongText"><?php echo $MS ." - ".$ME; ?></span>
								</td>
								<td style="width:50%;" class="text_right">&nbsp;</td>
							</tr>
							<tr>
								<td style="width:50%;">
									<span>Total Amount Paid:</span><br>
									<span class="strongTextCommission"><?php echo formatNumber($totalamountpaid); ?></span>
								</td>
								<td style="width:50%;">
									<span>Total Commission:</span><br>
									<span class="strongTextCommission"><?php echo formatNumber($totalcommission); ?></span>
								</td>
							</tr>
							<tr>
								<td style="width:50%;">
									<span>Total Amount Paid (ORG):</span><br>
									<span class="strongText"><?php echo formatNumber($totalamountorg); ?></span>
								</td>
								<td style="width:50%;">
									<span>Total Count (ORG):</span><br>
									<span class="strongText"><?php echo $totalcountorg; ?></span>
								</td>
							</tr>

							<tr>
								<td style="width:50%;">
									<span>Total Amount Paid (NAS):</span><br>
									<span class="strongText"><?php echo formatNumber($totalamountnas).' ('.formatNumber(($totalamountnas/$totalamountpaid)*100).' %)'; ?></span>
								</td>
								<td style="width:50%;">
									<span>Total Count (NAS):</span><br>
									<span class="strongText"><?php echo $totalcountnas; ?></span>
								</td>
							</tr>

							<tr>
								<td style="width:50%;">
									<span>Total Amount Paid (OAS):</span><br>
									<span class="strongText"><?php echo formatNumber($totalamountoas).' ('.formatNumber(($totalamountoas/$totalamountpaid)*100).' %)'; ?></span>
								</td>
								<td style="width:50%;">
									<span>Total Count (OAS):</span><br>
									<span class="strongText"><?php echo $totalcountoas; ?></span>
								</td>
							</tr>

							<tr>
								<td style="width:50%;">
									<span>Total No:</span><br>
									<span class="strongText"><?php echo count($userArr); ?></span>
								</td>
							</tr>
						</table>
					</div> -->

					<!-- <table id="main_table" border=1>
						<tr>
							<th rowspan="2" style="text-align: center">No</th>
							<th rowspan="2" style="text-align: center">Name</th>
							<th rowspan="2" style="text-align: center">Quota</th>
							<th rowspan="2" style="text-align: center">TCA</th>
							<th rowspan="2" style="text-align: right">Commission</th>
							<th colspan="2" style="text-align: center">ORG</th>
							<th colspan="4" style="text-align: center">NAS</th>
							<th colspan="4" style="text-align: center">OAS</th>
							<th rowspan="2" style="text-align: center">Status</th>
						</tr>
						<tr>
							<td style="text-align:right">Amount</td>
							<td style="text-align:center">Count</td>
							<td style="text-align:right">Amount</td>
							<td style="text-align:center">Percentage</td>
							<td style="text-align:center">Count</td>
							<td style="text-align:center">Percentage</td>
							<td style="text-align:right">Amount</td>
							<td style="text-align:center">Percentage</td>
							<td style="text-align:center">Count</td>
							<td style="text-align:center">Percentage</td>
							
						</tr>

						<?php echo $salesreport;?> -->

							
							
						</table>
					</div>
				</div>
			</div>
		</div>
	</body>
	<!-- END -->
</html>