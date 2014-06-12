<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Retainedearning extends CI_Model{
	public function CurrentYear($accountGroup, $groupdetails, $accountdetails ){
		$datatbl_total = 0;
		foreach($accountGroup as $datatbl):
      		foreach($accountdetails as $row):
				if($row->currentyeardebit != '' && $row->currentyearcredit !=''){ 
                 	$totalamount = $row->currentyearcredit - $row->currentyeardebit; 
						$datatbl_total = $datatbl_total + $totalamount;
				} 
			endforeach;
      		if($groupdetails){ 
				foreach($groupdetails as $rowdet):
					$rowdet_credit = 0;
					if($rowdet->parentID == $datatbl->ID){
      					foreach($accountdetails as $row):
							if($row->acctGroupID == $rowdet->ID){
								if($row->currentyeardebit != '' && $row->currentyearcredit !=''){ 
                 					$totalamount = $row->currentyearcredit - $row->currentyeardebit;
									$rowdet_credit = $rowdet_credit + $totalamount;
									$datatbl_total = $datatbl_total + $totalamount;
								}
							}
						endforeach;
						foreach($groupdetails as $rowdet1): 
							$rowdet1_credit = 0;
							if($rowdet1->parentID == $rowdet->ID){
								foreach($groupdetails as $rowdet2): 
									$rowdet2_credit = 0; 
									if($rowdet2->parentID == $rowdet1->ID){
 										foreach($groupdetails as $rowdet3): 
											$rowdet3_credit = 0; 
											if($rowdet3->parentID == $rowdet2->ID){
     											foreach($accountdetails as $row2):
													if($row2->acctGroupID == $rowdet3->ID){
														if($row2->currentyeardebit != '' && $row2->currentyearcredit !=''){ 
                 											$totalamount = $row2->currentyearcredit - $row2->currentyeardebit;
															$datatbl_total = $datatbl_total + $totalamount;
														}
													}
												endforeach;
											}
										endforeach;
     									foreach($accountdetails as $row2):
											if($row2->acctGroupID == $rowdet2->ID){
												if($row2->currentyeardebit != '' && $row2->currentyearcredit !=''){ 
                 									$totalamount = $row2->currentyearcredit - $row2->currentyeardebit; 
													$datatbl_total = $datatbl_total + $totalamount;
												}
											}
										endforeach;
									}
								endforeach;
      							foreach($accountdetails as $row2):
									if($row2->acctGroupID == $rowdet1->ID){
										if($row2->currentyeardebit != '' && $row2->currentyearcredit !=''){ 
                 							$totalamount = $row2->currentyearcredit - $row2->currentyeardebit;
											$datatbl_total = $datatbl_total + $totalamount;
										}
									}
								endforeach;
							}
						endforeach;
					}
				endforeach;
			}
		endforeach; 
		return $datatbl_total;
	}
	
}

// Created By Yahaya Abdollah
// Dated : 30th May 2014