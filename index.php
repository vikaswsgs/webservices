<?php
include 'connect.php';

/**
 * File to handle all API requests
 * Accepts GET and POST
 * 
 * Each request will be identified by TAG
 * Response will be JSON data

  /**
 * check for POST request 
 */
  


function do_post_request($url, $data, $optional_headers = null) {
	$params = array('http' => array('method' => 'POST', 'content' => $data));
	if ($optional_headers !== null) {
		$params['http']['header'] = $optional_headers;
	}
	$ctx = stream_context_create($params);
	$fp = @fopen($url, 'rb', false, $ctx);
	if (!$fp) {
		throw new Exception("Problem with $url, $php_errormsg");
	}
	$response = @stream_get_contents($fp);
	if ($response === false) {
		throw new Exception("Problem reading data from $url, $php_errormsg");
	}
	return $response;
}

$input = @file_get_contents('php://input');



$dataset = explode("|", $input);
//print_r($dataset);
$printed=0;
for ($i = 0; $i < count($dataset); $i++) {
	$data = json_decode($dataset[$i]);
	
	if (!empty($data -> method)) {
		 $method = $data -> method;

		if (function_exists($method)) {
			$result = $method($data);
                         
			if ($printed==0)
				{
				if(isset($result))
				{
				$printed=1;
				echo json_encode($result);
				
				}
				}
		} else {
			if ($i == 0)
				echo "Method not Exist";
		}
	} else {
		if ($i == 0)
			echo "method not specified";
	}
}


  /* ================================================= For Login  =========================================*/

     function login($data) {
        $email = mysql_real_escape_string($data -> email);
        $password = mysql_real_escape_string($data -> password);
        if(!empty($email) && !empty($password))
        {
        $result = mysql_query("SELECT * FROM users WHERE email = '$email'") or die(mysql_error());
        // check for result 
         $no_of_rows = mysql_num_rows($result);
                 if ($no_of_rows > 0) {
                    $result = mysql_fetch_array($result);
                    $salt = $result['salt'];
                    $uuid = $result['unique_id'];
                    $encrypted_password = $result['encrypted_password'];
                    $hash = checkhashSSHA($salt, $password);
                    // check for password equality
                    if ($encrypted_password == $hash) {
                        // user authentication details are correct
                        return array("unique_id"=>$uuid, "msg"=>"details are correct","status"=>"success");
                    }
                    
                    else {
                    // user not found
                       return array("msg"=>"details are not correct","status"=>"failure");
                        }
                    
                } else {
                    // user not found
                     return array("msg"=>"user not found","status"=>"failure");
                }
                
           }
                else
                {
                 return array("msg"=>"Fill the Details","status"=>"failure");
                }

     }
        
    /* ================================================= For Register  =========================================*/
        
        
    function register($data) {
        $email = mysql_real_escape_string($data->email);
        $password = mysql_real_escape_string($data->password);
        $fname = mysql_real_escape_string($data->fname);
        $lname = mysql_real_escape_string($data->lname);
        $cellphone = mysql_real_escape_string($data->cellphone);
        if(!empty($email) && !empty($password))
        {
                $result = mysql_query("SELECT email from users WHERE email = '$email'");
                $no_of_rows = mysql_num_rows($result);
                if ($no_of_rows > 0) {
                   return array("msg"=>"User already existed","status"=>"failure");
                } else {
                    // user not existed
                        $uuid = uniqid('', true);
                        $hash = hashSSHA($password);
                        $encrypted_password = $hash["encrypted"]; // encrypted password
                        $salt = $hash["salt"]; // salt
                        
                        $result = mysql_query("INSERT INTO `users`(`unique_id`, `email`, `encrypted_password`, `salt`, `created_at` , `fname`, `lname`, `cellphone` ) VALUES('".$uuid."', '".$email."', '".$encrypted_password."', '".$salt."', NOW(), '".$fname."', '".$lname."', '".$cellphone."')");
                        // check for successful store
                         
                        if ($result) {
                            
                                $to      = $email;
                                $subject = 'New Account has been Created';
                                $message = 'Welcome in the Mucky Laundry :-)';
                                $header = "From:info@hooduku.com \r\n";
                                mail($to, $subject, $message, $header); 
                             return array("unique_id"=>$uuid,"msg"=>"create account","status"=>"success");
                        } else {
                           return array("msg"=>"Error occured in registration","status"=>"failure");
                        }
                                                    
                 }
        }
        else
        {
        return array("msg"=>"Email id and password are required fields" , "status"=>"failure");
        }
    
    } 
    
    
  /* ================================================= For Update Address  =========================================*/
    
    function update_address($data) {
        $address = mysql_real_escape_string($data->address);
        $apt_number = mysql_real_escape_string($data->apt_number);
        $zipcode = mysql_real_escape_string($data->zipcode);
        $location = mysql_real_escape_string($data->location);
        $note = mysql_real_escape_string($data->note); 
        $uuid = mysql_real_escape_string($data->unique_id); 
        $address_id = mysql_real_escape_string($data->address_id);
        $data =mysql_query("select * from second_step where unique_id='".$uuid."' && id='".$address_id."'");
        $no_of_rows = mysql_num_rows($data);
        if ($no_of_rows > 0) {
        $update =mysql_query("update second_step set `address`='".$address."' ,`apt_number`='".$apt_number."',`zipcode`='".$zipcode."',`location`='".$location."',`note`='".$note."' where unique_id='".$uuid."' && id='".$address_id."' ");
          return array("msg"=>"update successfully","status"=>"success");
        }
        else{
        $insert = mysql_query("insert into second_step (unique_id,address,apt_number,zipcode,location,note) values ('".$uuid."','".$address."','".$apt_number."','".$zipcode."','".$location."','".$note."')");
               if ($insert) {
                    $addressid = mysql_insert_id(); // last inserted id
                    return array("address_id"=>$addressid,"msg"=>"insert successfully", "status"=>"success");
                } 
        }
    
    } 
    
 
    
    
    
     /* ================================================= Get Unique Address  =========================================*/ 
    
    function get_unique_address_data($data){
      $uuid = mysql_real_escape_string($data->unique_id);
      $address_id = mysql_real_escape_string($data->id); 
      $data= mysql_query("select * from second_step where unique_id='".$uuid."' && id='".$address_id."'");
      if(mysql_num_rows($data)>0)
      {
             while($row = mysql_fetch_assoc($data))
             {
                 $rows[] = $row;
             }
             return array("msg"=>"success","address"=>$rows,"status"=>"success");  
      }
        
      else
      {
              return array("msg"=>"No Record Found","status"=>"failure");
      }
      
    }
   
  /* ================================================= Delete All Records for address  =========================================*/  
      
    function delete_address($data){
      $uuid = mysql_real_escape_string($data->unique_id);
      $rec = mysql_query("select * from second_step where unique_id='".$uuid."'"); 
      if(mysql_num_rows($rec)>0)
      {
       $del = mysql_query("Delete from second_step where unique_id='".$uuid."'");
       return array("msg"=>"Delete successfully","status"=>"success");
      }
      else
      {
       return array("msg"=>"No Record Found","status"=>"failure");
      }
    }
    
    
 /* ================================================= Delete Particular Records for address  =========================================*/  
      
    function delete_unique_address($data){
      $uuid = mysql_real_escape_string($data->unique_id);
      $address_id = mysql_real_escape_string($data->id);
      $rec = mysql_query("select * from second_step where unique_id='".$uuid."' && id ='".$address_id."'"); 
      if(mysql_num_rows($rec)>0)
      {
       $del = mysql_query("Delete from second_step where unique_id='".$uuid."' && id ='".$address_id."'");
       return array("msg"=>"Delete successfully","status"=>"success");
      }
      else
      {
       return array("msg"=>"No Record Found","status"=>"failure");
      }
    }
    
   
   /* ================================================= Get User Account Details  =========================================*/    
    
    function getuseraccount_details($data){
              $uuid = mysql_real_escape_string($data->unique_id); 
              $data= mysql_query("select * from users where unique_id='".$uuid."'");
              if(mysql_num_rows($data)>0)
              {
                      $row = mysql_fetch_array($data);
                      $email = $row['email'];
                      $fname = $row['fname'];
                      $lname = $row['lname'];
                      $cellphone = $row['cellphone'];
                      $uuid = $row['unique_id'];
                      return array("status"=>"success","msg"=>"success","email"=>$email,"fname"=>$fname,"lname"=>$lname,"cellphone"=>$cellphone," unique_id"=>$uuid);
              }
              else
              {
                      return array("msg"=>"No Record Found","status"=>"failure");
              }
    
    }
    
 /* ================================================= Update User Account Details =========================================*/   
    
    function updateuseraccount_details($data){    
        $email = mysql_real_escape_string($data->email);
        $fname = mysql_real_escape_string($data->fname);
        $lname = mysql_real_escape_string($data->lname);
        $cellphone = mysql_real_escape_string($data->cellphone);
        $uuid = mysql_real_escape_string($data->unique_id); 
        $data =mysql_query("select * from users where unique_id='".$uuid."'");
        $no_of_rows = mysql_num_rows($data);
        if ($no_of_rows > 0) {
        $update =mysql_query("update users set `email`='".$email."' ,`fname`='".$fname."',`lname`='".$lname."',`cellphone`='".$cellphone."' where unique_id='".$uuid."' ");
          return array("msg"=>"update successfully","status"=>"success");
        }
        else{
             return array("msg"=>"No Record Found","status"=>"failure");
        }
    
    }

  /* ================================================= Get Items List =========================================*/    
    
    function getitems_list(){
       $data =mysql_query("SELECT items.name, items.id, items.price,categories.catname
        FROM items
        INNER JOIN categories
        WHERE items.cat_id = categories.id");
        
        if(mysql_num_rows($data)>0) {
         while($row=mysql_fetch_assoc($data)){
            $rows[] = $row;
           }
             return array("msg"=>"success","items"=>$rows,"status"=>"success");  
        }
        else
        {
         return array("msg"=>"No Products found","status"=>"failure");
        }
    }
    
   /* ================================================= Forget Password =========================================*/   
    
    function forget_password($data){
        $emailid = mysql_real_escape_string($data->email);
        if(!empty($emailid)){
                 $data = mysql_query("select * from users where email='".$emailid."'"); 
                if(mysql_num_rows($data)>0){
                $uuid = mysql_real_escape_string($data->unique_id);
                $newpassword = mysql_real_escape_string($data->newpassword);
                $repeatpassword = mysql_real_escape_string($data->repeatpassword);
                        if($newpassword ==  $repeatpassword)
                        {
                                $hash = hashSSHA($newpassword);
                                $encrypted_password = $hash["encrypted"]; // encrypted password
                                $salt = $hash["salt"]; // salt
                                $update = mysql_query("update users set `encrypted_password`='".$encrypted_password."', `salt`='".$salt."' where unique_id='".$uuid."'");  
                                return array("unique_id"=>$uuid,"msg"=>"Update Successfully","status"=>"success");                 
                              
                         }
                         else
                         {
                           return array("msg"=>"New password and repeat password must be same","status"=>"failure");
                         }
                
                }
                else
                {
                  return array("msg"=>"Email id is not exist","status"=>"failure");
                }
        }
        else
        {
         return array("msg"=>"Enter your email id","status"=>"failure");
        }        
     
    }
    
    
 /* ================================================= Add/update/ Preferences =========================================*/
    
    
    function preferences($data){
              $uuid = mysql_real_escape_string($data->unique_id); 
              $choice = mysql_real_escape_string($data->choice); //'unscented'
              $treat = mysql_real_escape_string($data->treat);  //'We decide'
              $delivery = mysql_real_escape_string($data->delivery); //'Only to me later'
              $data = mysql_query("select * from preferences where unique_id='".$uuid."'");
              if(mysql_num_rows($data)>0)
              {
               $row = mysql_fetch_array($data);
               $data = mysql_query("update preferences  set `choice`='".$choice."',`treat`='".$treat."',`delivery`='".$delivery."' where unique_id='".$uuid."'");
               return array("id"=>$row['id'],"msg"=>"Update Successfully","status"=>"success");
              }
              else
              {
                $data = mysql_query("insert into preferences(unique_id,choice,treat,delivery) values('".$uuid."','".$choice."','".$treat."','".$delivery."')");
                 if($data){       
                    $id = mysql_insert_id(); // last inserted id
                    return array("id"=>$id,"msg"=>"Insert Successfully","status"=>"success");
                    }                
              }         
    }
    
    
    /* ================================================= Get Preferences =========================================*/
   
    
         function get_preferences($data) {
               $uuid = mysql_real_escape_string($data->unique_id); 
               $data =mysql_query("select * from preferences where unique_id='".$uuid."'");
               if(mysql_num_rows($data)>0){
                $row = mysql_fetch_array($data);
                return array("msg"=>"success","choice"=>$row['choice'],"treat"=>$row['treat'],"delivery"=>$row['delivery']); 
                      }
               else{     
               $choice = mysql_real_escape_string('unscented'); //'unscented'
               $treat = mysql_real_escape_string('We decide');  //'We decide'
               $delivery = mysql_real_escape_string('Only to me later'); //'Only to me later'
              return array("status"=>"success","msg"=>"success","choice"=>$choice,"treat"=>$treat,"delivery"=>$delivery); 
              }
           }
    
    
    
    
     /* ================================================= Get Faq Questions =========================================*/
     
     function faq(){
       $data =mysql_query("SELECT * from faq");        
        if(mysql_num_rows($data)>0) {
         while($row=mysql_fetch_assoc($data)){
            $rows[] = $row;
           }
             return array("status"=>"success","msg"=>"success","data"=>$rows);  
        }
        else
        {
         return array("status"=>"failure","msg"=>"No faq questions there");
        }
     }
     
     
     /*======================================================= Generate Share Code  ================================*/
     
     function share_code($data){
      $code = uniqid ();
      $uuid = mysql_real_escape_string($data->unique_id);
      $data = mysql_query("select * from share_code where unique_id='".$uuid."'");
      if(mysql_num_rows($data)>0){
      $rec = mysql_fetch_array($data);
      $fetchcode = $rec['code'];
      $uuid = $rec['unique_id'];
      $id = $rec['id'];
         return array("share_code_id"=>$id,"unique_id"=>$uuid,"code"=>$fetchcode,"msg"=>"success","status"=>"success"); 
      }
      else{
      $insert = mysql_query("insert into share_code(unique_id,code) values('".$uuid."','".$code."')");
      if($insert){       
                    $id = mysql_insert_id(); // last inserted id
                    $result = mysql_query("SELECT * FROM share_code WHERE id = '".$id."'");
                    $rec = mysql_fetch_array($result);
                    $codeshare = $rec['code'];
                    $uuid = $rec['unique_id'];
                    $id = $rec['id'];
                    return array("share_code_id"=>$id,"unique_id"=>$uuid,"code"=>$codeshare,"msg"=>"Added Successfully", "status"=>"success");      
                }
          }    
      }   
     
    
    /*======================================================= Generate Order ================================*/
    
    
    function generate_order($data){
             $payid = mysql_real_escape_string($data->pay_id);
             if(!empty($payid)){
                $unique_id = mysql_real_escape_string($data->unique_id);
                $status = mysql_real_escape_string($data->state);
                $time = mysql_real_escape_string($data->create_time);
                $desc = mysql_real_escape_string($data->short_description);
                $amnt = mysql_real_escape_string($data->amount);
                $currency = mysql_real_escape_string($data->currency_code);
                
                $drop_off_date = mysql_real_escape_string($data->drop_off_date);
                $drop_off_time = mysql_real_escape_string($data->drop_off_time);
                $pick_up_date = mysql_real_escape_string($data->pick_up_date);
                $pick_up_time = mysql_real_escape_string($data->pick_up_time);
                $repeat = mysql_real_escape_string($data->repeat);
                $address_id = mysql_real_escape_string($data->address_id);
                $cleaning_notes = mysql_real_escape_string($data->cleaning_notes);
                $credit = mysql_real_escape_string($data->credit_before_order);
                $amnt_payable = mysql_real_escape_string($data->amount_payable);
                               
               $insert =  mysql_query("INSERT INTO `order` (`unique_id` ,`status` ,`pay_id` ,`time` ,`desc` ,`amount` ,`currency`,`drop_off_date`,`drop_off_time`,`pick_up_date`,`pick_up_time`,`repeat`,`address_id`,`cleaning_notes`,`credit`,`amnt_payable`) VALUES ('".$unique_id."', '".$status."', '".$payid."', '".$time."', '".$desc."', '".$amnt."', '".$currency."','".$drop_off_date."','".$drop_off_time."','".$pick_up_date."','".$pick_up_time."','".$repeat."','".$address_id."','".$cleaning_notes."','".$credit."','".$amnt_payable."')");
                if($insert)
                {
                             $send_referal=mysql_query("select * from referal_table where use_referal ='".$unique_id."'");
                     
                              if(mysql_num_rows($send_referal)>0) {
                              $update = mysql_query("update `referal_table` set `send_status`='Approved' where use_referal='".$unique_id."'");  
                      
                       /* ============= send mail to sender  ============= */
                       
                                $rec = mysql_fetch_array($send_referal);
                                $send_referal_id =  $rec['send_referal'];
                                $getemailid  = mysql_query("select * from users where unique_id='".$send_referal_id."'");
                                $get_sender_emailid = mysql_fetch_array($getemailid);
                                
                                $to      = $get_sender_emailid['email'];
                                $subject = '$25 credit to your account';
                                $message = 'Hi.. Now $25 is credit to your account.';
                                $header = "From:info@hooduku.com \r\n";
                                mail($to, $subject, $message, $header);                     
                               } 
                                                     
                                   $oid = mysql_insert_id(); 
                                   $items =$data->item_desc;
                                
                                   for($i=0;$i<count($items);$i++){
                                    $query = mysql_query("INSERT INTO `ordered_items` (`order_id`, `product_id`, `product_name`,`product_category`,`product_price`) VALUES('".$oid."','".$items[$i]->product_id."','".$items[$i]->product_name."','".$items[$i]->product_category."','".$items[$i]->product_price."')");
                                                                }
                                return array("order_id"=>$oid,"msg"=>'success',"items" =>$items,"status"=>"success");   
                }

              
             }
             else
             {
               return array("msg"=>"There is an error .Order did not generate","status"=>"failure");  
             }
    }
    
 
   
   /*============================================= Referal Code  ==================================================*/
   
      
      function referal_code($data){ 
      $referal_code = mysql_real_escape_string($data->code); //share_code
      $use_referal = mysql_real_escape_string($data->unique_id); //loggedinuser
    
      $data = mysql_query("select * from share_code where code='".$referal_code."'");
      $getdata=mysql_fetch_array($data);
      $send_referal = $getdata['unique_id'];
      
     
              if(mysql_num_rows($data)>0){
              
               /* =========== check share code use or not ==========*/
      
                         
               $check = mysql_query("select * from referal_table where use_referal='".$use_referal."' && send_referal='".$send_referal."' ");
               if(mysql_num_rows($check)>0){
                   return array("msg"=>"You have already use that share code","status"=>"failure");  
               }
               else{              
               
              /* $send_referal_emailid = mysql_query("select * from users where unique_id='".$send_referal."'");
               $send=mysql_fetch_array($send_referal_emailid);
             
             
                $to      = $send['email'];
                $subject = '$25 sent';
                $message = 'you can use $25 in the washio';
                $header = "From:washio@somedomain.com \r\n";
                mail($to, $subject, $message, $header); */
             
             
             
             
               
               /*====================== use share code ================== */
                    
              
               $use_referal_emailid = mysql_query("select * from users where unique_id='".$use_referal."'");
               $rec=mysql_fetch_array($use_referal_emailid);
               $to1 = $rec['email'];
               $subject1 = '$25 sent before order ';
               $message1= 'I have referral you and you can use $25 in the washio';
               $headers1 = "From:info@hooduku.com \r\n";
               mail($to1,$subject1,$message1,$headers1); 
               
               /* ======================= insert into referal table  ===================*/
           
               
               $data  = mysql_query("insert into `referal_table` (`use_referal`,`use_status`,`send_referal`,`send_status`) values ('".$use_referal."','Approved','".$send_referal."','Pending')");
               
                return array("msg"=>"Mail sent Successfully","status"=>"success");  
               
               }
               
               
              }
              else
              {
                return array("msg"=>"Share Code doesn't Exist","status"=>"failure");  
              }
   
     }
    
    
    
      /* ================================================= Get Multiple Records For Address  =========================================*/ 
    
    function getaddress_data($data){
      $uuid = mysql_real_escape_string($data->unique_id); 
      $data= mysql_query("select * from second_step where unique_id='".$uuid."'");
      if(mysql_num_rows($data)>0)
      {
             while($row = mysql_fetch_array($data))
             {
                 $rows[] = $row;
             }
             return array("msg"=>"success","address"=>$rows,"status"=>"success");  
      }
              
      
      else
      {
              return array("msg"=>"No Record Found","status"=>"failure");
      }
      
    }
    
     /* ================================================= Get Credit  =========================================*/  
   
          /* function get_credit($data){           
           $uuid = mysql_real_escape_string($data->unique_id); 
           $data  = mysql_query("select * from referal_table where use_referal='".$uuid."'");
           if(mysql_num_rows($data)>0){
               $num =  mysql_num_rows($data);
               $credit = $num*25;
               return array("credit"=>$credit,"msg"=>"success","status"=>"success");
            }
            else{
              return array("credit"=>'0',"msg"=>"success","status"=>"success");
            }
           
           } */
           
           
           function get_credit($data){
                   $uuid = mysql_real_escape_string($data->unique_id); 
                   $data =mysql_query("select * from share_code where unique_id='".$uuid."'");
                   $rec = mysql_fetch_array($data);
           
                   $data1  = mysql_query("select * from referal_table where use_referal='".$uuid."' && send_status='Pending'");
                   if(mysql_num_rows($data1)>0)
                   {
                    $num1 =  mysql_num_rows($data1);
                    $credit = $num1*25; 
                    return array("credit"=>$credit,"msg"=>"success","status"=>"success");
                   }
                   
                  else if($data1  = mysql_query("select * from referal_table where send_referal='".$uuid."' && send_status='Approved'"))
                  {
                    $num1 =  mysql_num_rows($data1);
                    $credit= $num1*25;
                    return array("credit"=>$credit,"msg"=>"success","status"=>"success"); 
                    
                  }
                  else
                  {
                     return array("credit"=>'0',"msg"=>"success","status"=>"success");
                  }
           
           } 
  
    /* ================================================= Check password =========================================*/   
   
    
    function checkhashSSHA($salt, $password) {
       $hash = base64_encode(sha1($password . $salt, true) . $salt);
       return $hash;
    }
    
    /* ================================================= Generate password =========================================*/     

    function hashSSHA($password) {
        $salt = sha1(rand());
        $salt = substr($salt, 0, 10);
        $encrypted = base64_encode(sha1($password . $salt, true) . $salt);
        $hash = array("salt" => $salt, "encrypted" => $encrypted);
        return $hash;
    }
    
   


?>
