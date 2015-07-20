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
                        return array("unique_id"=>$uuid, "msg"=>"details are correct");
                    }
                    
                    else {
                    // user not found
                       return array("msg"=>"details are not correct");
                        }
                    
                } else {
                    // user not found
                     return array("msg"=>"user not found");
                }
                
           }
                else
                {
                 return array("msg"=>"Fill the Details");
                }

     }
        
    /* ================================================= For Register  =========================================*/
        
        
    function register($data) {
        $email = mysql_real_escape_string($data -> email);
        $password = mysql_real_escape_string($data -> password);
        $fname = mysql_real_escape_string($data -> fname);
        $lname = mysql_real_escape_string($data -> lname);
        $cellphone = mysql_real_escape_string($data -> cellphone);
        if(!empty($email) && !empty($password))
        {
                $result = mysql_query("SELECT email from users WHERE email = '$email'");
                $no_of_rows = mysql_num_rows($result);
                if ($no_of_rows > 0) {
                   return array("msg"=>"User already existed");
                } else {
                    // user not existed
                        $uuid = uniqid('', true);
                        $hash = hashSSHA($password);
                        $encrypted_password = $hash["encrypted"]; // encrypted password
                        $salt = $hash["salt"]; // salt
                        
                        $result = mysql_query("INSERT INTO users(unique_id, email, encrypted_password, salt, created_at , fname, lname, cellphone ) VALUES('$uuid', '$email', '$encrypted_password', '$salt', NOW(), '$fname', '$lname', '$cellphone')");
                        // check for successful stor
                         
                        if ($result) {
                             return array("unique_id"=>$uuid,"msg"=>"create account");
                        } else {
                           return array("msg"=>"Error occured in registration");
                        }
                                                    
                 }
        }
        else
        {
        return array("msg"=>"Email id and password are required fields");
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
          return array("msg"=>"update successfully");
        }
        else{
        $insert = mysql_query("insert into second_step (unique_id,address,apt_number,zipcode,location,note) values ('".$uuid."','".$address."','".$apt_number."','".$zipcode."','".$location."','".$note."')");
               if ($insert) {
                    $addressid = mysql_insert_id(); // last inserted id
                    return array("address_id"=>$addressid,"msg"=>"insert successfully");
                } 
        
        
         
        }
    
    } 
    
   /* ================================================= Get Multiple Records For Address  =========================================*/ 
    
    function getaddress_data($data){
      $uuid = mysql_real_escape_string($data->unique_id); 
      $data= mysql_query("select * from second_step where unique_id='".$uuid."'");
      if(mysql_num_rows($data)>0)
      {
             while($row = mysql_fetch_assoc($data))
             {
                 $rows[] = $row;
             }
             return array("msg"=>"success","address"=>$rows);  
      }
              
      
      else
      {
              return array("msg"=>"No Record Found");
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
             return array("msg"=>"success","address"=>$rows);  
      }
              
      
      else
      {
              return array("msg"=>"No Record Found");
      }
      
    }
   
  /* ================================================= Delete All Records for address  =========================================*/  
      
    function delete_address($data){
      $uuid = mysql_real_escape_string($data->unique_id);
      $rec = mysql_query("select * from second_step where unique_id='".$uuid."'"); 
      if(mysql_num_rows($rec)>0)
      {
       $del = mysql_query("Delete from second_step where unique_id='".$uuid."'");
       return array("msg"=>"Delete successfully");
      }
      else
      {
       return array("msg"=>"No Record Found");
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
       return array("msg"=>"Delete successfully");
      }
      else
      {
       return array("msg"=>"No Record Found");
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
                      return array("msg"=>"success","email"=>$email,"fname"=>$fname,"lname"=>$lname,"cellphone"=>$cellphone," unique_id"=>$uuid);
              }
              else
              {
                      return array("msg"=>"No Record Found");
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
          return array("msg"=>"update successfully");
        }
        else{
             return array("msg"=>"No Record Found");
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
             return array("msg"=>"success","items"=>$rows);  
        }
        else
        {
         return array("msg"=>"No Products found");
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
                                return array("unique_id"=>$uuid,"msg"=>"Update Successfully");                 
                              
                         }
                         else
                         {
                           return array("msg"=>"New password and repeat password must be same");
                         }
                
                }
                else
                {
                  return array("msg"=>"Email id is not exist");
                }
        }
        else
        {
         return array("msg"=>"Enter your email id");
        }
        
     
    }
    
    
     /* ================================================= Get Faq Questions =========================================*/
     
     function faq()
     {
       $data =mysql_query("SELECT * from faq");        
        if(mysql_num_rows($data)>0) {
         while($row=mysql_fetch_assoc($data)){
            $rows[] = $row;
           }
             return array("msg"=>"success","data"=>$rows);  
        }
        else
        {
         return array("msg"=>"No faq questions there");
        }
     }
     
     
     /*======================================================= Generate Share Code  ================================*/
     
     function share_code(){
      $code = uniqid ();
      $uuid = mysql_real_escape_string($data->unique_id);
      $data = mysql_query("select * from share_code where unique_id='".$uuid."'");
      if(mysql_num_rows($data)>0){
      $rec = mysql_fetch_array($data);
      $code = $rec['code'];
      $uuid = $rec['unique_id'];
      $id = $rec['id'];
         return array("share_code_id"=>$id,"unique_id"=>$uuid,"code"=>$code,"msg"=>"Already Added"); 
      }
      else{
      $insert = mysql_query("insert into share_code(unique_id,code) values('".$uuid."','".$code."')");
      if($insert){       
                    $id = mysql_insert_id(); // last inserted id
                    $result = mysql_query("SELECT * FROM share_code WHERE id = '".$id."'");
                    $rec = mysql_fetch_array($result);
                    $code = $rec['code'];
                    $uuid = $rec['unique_id'];
                    $id = $rec['id'];
                    return array("share_code_id"=>$id,"unique_id"=>$uuid,"code"=>$code,"msg"=>"Added Successfully");      
                }
          }    
      }   
     
    
    /*======================================================= Generate Order ================================*/
    
    
    function generate_order($data){
             $payid = mysql_real_escape_string($data->id);
             if(!empty($payid)){
                $unique_id = mysql_real_escape_string($data->unique_id);
                $status = mysql_real_escape_string($data->state);
                $time = mysql_real_escape_string($data->create_time);
                $desc = mysql_real_escape_string($data->short_description);
                $amnt = mysql_real_escape_string($data->amount);
                $currency = mysql_real_escape_string($data->currency_code);               
                $insert = mysql_query("INSERT INTO `order` (`unique_id` ,`status` ,`pay_id` ,`time` ,`desc` ,`amount` ,`currency`) VALUES ('".$unique_id."', '".$status."', '".$payid."', '".$time."', '".$desc."', '".$amnt."', '".$currency."')");
                if($insert)
                {
                      $id = mysql_insert_id();                 
                      $send_referal=mysql_query("select * from referal_table where use_referal ='".$unique_id."'");
                      if(mysql_num_rows($send_referal)>0) {
                      $update = mysql_query("update referal_table set `send_status `='Approved' where use_referal='".$unique_id."'"); 
                      
                       /* ============= send mail to sender  ============= */
                       
                                $rec = mysql_fetch_array($send_referal);
                                $send_referal_id =  $rec['send_referal'];
                                $getemailid  = mysql_query("select * from users where unique_id='".$send_referal_id."'");
                                $get_sender_emailid = mysql_fetch_array($getemailid);
                                
                                $to      = $get_sender_emailid['email'];
                                $subject = '$25 sent';
                                $message = 'you can use $25 in the washio';
                                $header = "From:washio@somedomain.com \r\n";
                                mail($to, $subject, $message, $header);                     
                               } 
                                return array("order_id"=>$id,"msg"=>"Order has been generated");   
                }

              
             }
             else
             {
               return array("msg"=>"There is an error .Order did not generate");  
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
                   return array("msg"=>"You have already use that share code");  
               }
               else{              
               
               $send_referal_emailid = mysql_query("select * from users where unique_id='".$send_referal."'");
               $send=mysql_fetch_array($send_referal_emailid);
             
             
                $to      = $send['email'];
                $subject = '$25 sent';
                $message = 'you can use $25 in the washio';
                $header = "From:washio@somedomain.com \r\n";
                mail($to, $subject, $message, $header);
             
             
             
             
               
               /*====================== use share code ================== */
                    
              
               $use_referal_emailid = mysql_query("select * from users where unique_id='".$use_referal."'");
               $rec=mysql_fetch_array($use_referal_emailid);
               $to1 = $rec['email'];
               $subject1 = '$25 sent';
               $message1= 'you can use $25 in the washio';
               $headers1 = "From:washio@somedomain.com \r\n";
               mail($to1,$subject1,$message1,$headers1); 
               
               /* ======================= insert into referal table  ===================*/
           
               
               $data  = mysql_query("insert into `referal_table` (`use_referal`,`use_status`,`send_referal`,`send_status`) values ('".$use_referal."','Approved','".$send_referal."','Pending')");
               
                return array("msg"=>"Mail sent Successfully");  
               
               }
               
               
              }
              else
              {
                return array("msg"=>"Share Code doesn't Exist");  
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
