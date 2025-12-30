<?php

if ($push->ppc_parentid != "") {
                                                    $playerparentdetails = $this->usersigin->getuserdetails(array('authenticationid' => $push->ppc_parentid, 'au_status' => '0'));
                                                    $parentid = $push->ppc_parentid;
                                                    $playerdatanotification = playerprofiledetailsfetch($push->authenticationid);
                                                   
                                                    $devicetokendata = @unserialize($playerparentdetails->au_devicetoken);
                                                    if ($devicetokendata !== false) {                                                  
                                                    $devicetypedata = @unserialize($playerparentdetails->au_devicetoken);
                                                    $deviceTypedataList=array_values($devicetypedata);
                                                    $devicetoken[]=array_values($devicetokendata);

                                                    if (in_array("android",$deviceTypedataList)) {
                                                        $bodytype = "message";
                                                        $notification['android'] = array('title' => 'Match covid-19 form', $bodytype => "Hi,  " . $push->au_crickf . " " . $push->au_cricks . "  Please submit the covid-19 verification form before your training ", 'formid' => $clubleaguedetails->im_covidformid, 'playerid' => $playerdatanotification['playerid'], 'playerauth' => $playerdatanotification['authenticationid'], 'firstname' => $playerdatanotification['firstname'], 'surname' => $playerdatanotification['surname'], 'au_profile' => $playerdatanotification['au_profile'], 'paymentstatus' => $playerdatanotification['paymentstatus'], 'payamount' => $playerdatanotification['payamount'], 'leagueid' => $playerdatanotification['leagueid'], 'playerdetails' => $playerdatanotification, 'notifytype' => '012', 'badge' => 1, 'sound' => 'default', 'vibrate' => 1);
                                                    } else if (in_array("ios",$deviceTypedataList)) {
                                                        $bodytype = "body";
                                                        $notification['ios'] = array('title' => 'Match covid-19 form', $bodytype => "Hi,  " . $push->au_crickf . " " . $push->au_cricks . "  Please submit the covid-19 verification form before your training ", 'formid' => $clubleaguedetails->im_covidformid, 'playerid' => $playerdatanotification['playerid'], 'playerauth' => $playerdatanotification['authenticationid'], 'firstname' => $playerdatanotification['firstname'], 'surname' => $playerdatanotification['surname'], 'au_profile' => $playerdatanotification['au_profile'], 'paymentstatus' => $playerdatanotification['paymentstatus'], 'payamount' => $playerdatanotification['payamount'], 'leagueid' => $playerdatanotification['leagueid'], 'playerdetails' => $playerdatanotification, 'notifytype' => '012', 'badge' => 1, 'sound' => 'default', 'vibrate' => 1);
                                                    } else {
                                                        $bodytype = "message";
                                                        $notification['android'] = array('title' => 'Match covid-19 form', $bodytype => "Hi,  " . $push->au_crickf . " " . $push->au_cricks . "  Please submit the covid-19 verification form before your training ", 'formid' => $clubleaguedetails->im_covidformid, 'playerid' => $playerdatanotification['playerid'], 'playerauth' => $playerdatanotification['authenticationid'], 'firstname' => $playerdatanotification['firstname'], 'surname' => $playerdatanotification['surname'], 'au_profile' => $playerdatanotification['au_profile'], 'paymentstatus' => $playerdatanotification['paymentstatus'], 'payamount' => $playerdatanotification['payamount'], 'leagueid' => $playerdatanotification['leagueid'], 'playerdetails' => $playerdatanotification, 'notifytype' => '012', 'badge' => 1, 'sound' => 'default', 'vibrate' => 1);
                                                    }
                                                    
                                                   
                                                
                                                }else{

                                                    $devicetoken[] = $playerparentdetails->au_devicetoken;
                                                    $devicetype = $playerparentdetails->au_devicetype;
                                                    $deviceTypedataList[]=$devicetype;

                                                   
                                                    if ($devicetype == "android") {
                                                        $bodytype = "message";
                                                        $notification['android'] = array('title' => 'Match covid-19 form', $bodytype => "Hi,  " . $push->au_crickf . " " . $push->au_cricks . "  Please submit the covid-19 verification form before your training ", 'formid' => $clubleaguedetails->im_covidformid, 'playerid' => $playerdatanotification['playerid'], 'playerauth' => $playerdatanotification['authenticationid'], 'firstname' => $playerdatanotification['firstname'], 'surname' => $playerdatanotification['surname'], 'au_profile' => $playerdatanotification['au_profile'], 'paymentstatus' => $playerdatanotification['paymentstatus'], 'payamount' => $playerdatanotification['payamount'], 'leagueid' => $playerdatanotification['leagueid'], 'playerdetails' => $playerdatanotification, 'notifytype' => '012', 'badge' => 1, 'sound' => 'default', 'vibrate' => 1);
                                                    } else if ($devicetype == "ios") {
                                                        $bodytype = "body";
                                                        $notification['ios'] = array('title' => 'Match covid-19 form', $bodytype => "Hi,  " . $push->au_crickf . " " . $push->au_cricks . "  Please submit the covid-19 verification form before your training ", 'formid' => $clubleaguedetails->im_covidformid, 'playerid' => $playerdatanotification['playerid'], 'playerauth' => $playerdatanotification['authenticationid'], 'firstname' => $playerdatanotification['firstname'], 'surname' => $playerdatanotification['surname'], 'au_profile' => $playerdatanotification['au_profile'], 'paymentstatus' => $playerdatanotification['paymentstatus'], 'payamount' => $playerdatanotification['payamount'], 'leagueid' => $playerdatanotification['leagueid'], 'playerdetails' => $playerdatanotification, 'notifytype' => '012', 'badge' => 1, 'sound' => 'default', 'vibrate' => 1);
                                                    } else {
                                                        $bodytype = "message";
                                                        $notification['android'] = array('title' => 'Match covid-19 form', $bodytype => "Hi,  " . $push->au_crickf . " " . $push->au_cricks . "  Please submit the covid-19 verification form before your training ", 'formid' => $clubleaguedetails->im_covidformid, 'playerid' => $playerdatanotification['playerid'], 'playerauth' => $playerdatanotification['authenticationid'], 'firstname' => $playerdatanotification['firstname'], 'surname' => $playerdatanotification['surname'], 'au_profile' => $playerdatanotification['au_profile'], 'paymentstatus' => $playerdatanotification['paymentstatus'], 'payamount' => $playerdatanotification['payamount'], 'leagueid' => $playerdatanotification['leagueid'], 'playerdetails' => $playerdatanotification, 'notifytype' => '012', 'badge' => 1, 'sound' => 'default', 'vibrate' => 1);
                                                    }                                                    
                                                   
                                                
                                                }
                                               
                                               
                                                } else {

                                                    $parentid = $push->authenticationid;
                                                    $playerdatanotification = playerprofiledetailsfetch($push->authenticationid);

                                                    $devicetoken = $push->au_devicetoken;
                                                    $devicetype = $push->au_devicetype;
                                                    $devicetokendata = @unserialize($push->au_devicetoken);
                                                    if ($devicetokendata !== false) {
                                                        $devicetypedata = @unserialize($push->au_devicetoken);
                                                        $deviceTypedataList=array_values($devicetypedata);
                                                        $devicetoken[]=array_values($devicetokendata);

                                                        if (in_array("android",$deviceTypedataList)) {
                                                            $bodytype = "message";
                                                            $notification['android'] = array('title' => 'Match covid-19 form', $bodytype => "Hi,  " . $push->au_crickf . " " . $push->au_cricks . " Please submit the covid-19 verification form before your training ", 'formid' => $clubleaguedetails->im_covidformid, 'leagueid' => $playingleague, 'playerid' => $playerdatanotification['playerid'], 'playerauth' => $playerdatanotification['authenticationid'], 'firstname' => $playerdatanotification['firstname'], 'surname' => $playerdatanotification['surname'], 'au_profile' => $playerdatanotification['au_profile'], 'paymentstatus' => $playerdatanotification['paymentstatus'], 'payamount' => $playerdatanotification['payamount'], 'leagueid' => $playerdatanotification['leagueid'], 'playerdetails' => $playerdatanotification, 'notifytype' => '012', 'badge' => 1, 'sound' => 'default', 'vibrate' => 1);
                                                        } else if (in_array("ios",$deviceTypedataList)) {
                                                            $bodytype = "body";
                                                            $notification['ios'] = array('title' => 'Match covid-19 form', $bodytype => "Hi,  " . $push->au_crickf . " " . $push->au_cricks . " Please submit the covid-19 verification form before your training ", 'formid' => $clubleaguedetails->im_covidformid, 'leagueid' => $playingleague, 'playerid' => $playerdatanotification['playerid'], 'playerauth' => $playerdatanotification['authenticationid'], 'firstname' => $playerdatanotification['firstname'], 'surname' => $playerdatanotification['surname'], 'au_profile' => $playerdatanotification['au_profile'], 'paymentstatus' => $playerdatanotification['paymentstatus'], 'payamount' => $playerdatanotification['payamount'], 'leagueid' => $playerdatanotification['leagueid'], 'playerdetails' => $playerdatanotification, 'notifytype' => '012', 'badge' => 1, 'sound' => 'default', 'vibrate' => 1);
                                                        } else {
                                                            $bodytype = "message";
                                                            $notification['android'] = array('title' => 'Match covid-19 form', $bodytype => "Hi,  " . $push->au_crickf . " " . $push->au_cricks . " Please submit the covid-19 verification form before your training ", 'formid' => $clubleaguedetails->im_covidformid, 'leagueid' => $playingleague, 'playerid' => $playerdatanotification['playerid'], 'playerauth' => $playerdatanotification['authenticationid'], 'firstname' => $playerdatanotification['firstname'], 'surname' => $playerdatanotification['surname'], 'au_profile' => $playerdatanotification['au_profile'], 'paymentstatus' => $playerdatanotification['paymentstatus'], 'payamount' => $playerdatanotification['payamount'], 'leagueid' => $playerdatanotification['leagueid'], 'playerdetails' => $playerdatanotification, 'notifytype' => '012', 'badge' => 1, 'sound' => 'default', 'vibrate' => 1);
                                                        }
                                                      
                                                       
                                                  

                                                    }else{
                                                        $devicetoken[] = $push->au_devicetoken;
                                                       $devicetype = $push->au_devicetype;
                                                       $deviceTypedataList[]=$devicetype;
                                                        if ($devicetype == "android") {
                                                            $bodytype = "message";
                                                            $notification['android'] = array('title' => 'Match covid-19 form', $bodytype => "Hi,  " . $push->au_crickf . " " . $push->au_cricks . " Please submit the covid-19 verification form before your training ", 'formid' => $clubleaguedetails->im_covidformid, 'leagueid' => $playingleague, 'playerid' => $playerdatanotification['playerid'], 'playerauth' => $playerdatanotification['authenticationid'], 'firstname' => $playerdatanotification['firstname'], 'surname' => $playerdatanotification['surname'], 'au_profile' => $playerdatanotification['au_profile'], 'paymentstatus' => $playerdatanotification['paymentstatus'], 'payamount' => $playerdatanotification['payamount'], 'leagueid' => $playerdatanotification['leagueid'], 'playerdetails' => $playerdatanotification, 'notifytype' => '012', 'badge' => 1, 'sound' => 'default', 'vibrate' => 1);
                                                        } else if ($devicetype == "ios") {
                                                            $bodytype = "body";
                                                            $notification['ios'] = array('title' => 'Match covid-19 form', $bodytype => "Hi,  " . $push->au_crickf . " " . $push->au_cricks . " Please submit the covid-19 verification form before your training ", 'formid' => $clubleaguedetails->im_covidformid, 'leagueid' => $playingleague, 'playerid' => $playerdatanotification['playerid'], 'playerauth' => $playerdatanotification['authenticationid'], 'firstname' => $playerdatanotification['firstname'], 'surname' => $playerdatanotification['surname'], 'au_profile' => $playerdatanotification['au_profile'], 'paymentstatus' => $playerdatanotification['paymentstatus'], 'payamount' => $playerdatanotification['payamount'], 'leagueid' => $playerdatanotification['leagueid'], 'playerdetails' => $playerdatanotification, 'notifytype' => '012', 'badge' => 1, 'sound' => 'default', 'vibrate' => 1);
                                                        } else {
                                                            $bodytype = "message";
                                                            $notification['android'] = array('title' => 'Match covid-19 form', $bodytype => "Hi,  " . $push->au_crickf . " " . $push->au_cricks . " Please submit the covid-19 verification form before your training ", 'formid' => $clubleaguedetails->im_covidformid, 'leagueid' => $playingleague, 'playerid' => $playerdatanotification['playerid'], 'playerauth' => $playerdatanotification['authenticationid'], 'firstname' => $playerdatanotification['firstname'], 'surname' => $playerdatanotification['surname'], 'au_profile' => $playerdatanotification['au_profile'], 'paymentstatus' => $playerdatanotification['paymentstatus'], 'payamount' => $playerdatanotification['payamount'], 'leagueid' => $playerdatanotification['leagueid'], 'playerdetails' => $playerdatanotification, 'notifytype' => '012', 'badge' => 1, 'sound' => 'default', 'vibrate' => 1);
                                                        }
                                                      
                                                       
                                                  

                                                    }


                                                 
                                              
                                                }




                                                if (in_array("android",$deviceTypedataList)) {
                                                        $arrayToSend = array('registration_ids' => $devicetoken, 'data' => $notification, 'priority' => 'high');
                                                    } else if (in_array("ios",$deviceTypedataList)) {
                                                        $arrayToSend = array('registration_ids' => $devicetoken, 'notification' => $notification, 'priority' => 'high');
                                                    } else {
                                                        $arrayToSend = array('registration_ids' => $devicetoken, 'data' => $notification, 'priority' => 'high');
                                                    }