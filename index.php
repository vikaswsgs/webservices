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
                            // get user details 
                            //$uid = mysql_insert_id(); // last inserted id
                           // $result = mysql_query("SELECT * FROM users WHERE uid = $uid");
                            // return user details
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
    
    function getaddress_data($data){
      $uuid = mysql_real_escape_string($data->unique_id); 
      $data= mysql_query("select * from second_step where unique_id='".$uuid."'");
      if(mysql_num_rows($data)>0)
      {
              $row = mysql_fetch_array($data);
              $address = $row['address'];
              $apt_number = $row['apt_number'];
              $zipcode = $row['zipcode'];
              $location = $row['location'];
              $note = $row['note'];
              $uuid = $row['unique_id'];
              return array("address"=>$address,"apt_number"=>$apt_number,"zipcode"=>$zipcode,"location"=>$location,"note"=>$note,"unique_id"=>$uuid);
      }
      else
      {
              return array("msg"=>"No Record Found");
      }
      
    }
    
    
    function credit_details($data){
        $number = mysql_real_escape_string($data->number); 
        $uuid = mysql_real_escape_string($data->unique_id); 
        $data =mysql_query("select * from creditdetails where unique_id='".$uuid."'");
        $no_of_rows = mysql_num_rows($data);
        if ($no_of_rows > 0) {
        $update =mysql_query("update creditdetails set `number`='".$number."' where unique_id='".$uuid."' ");
          return array("msg"=>"update successfully");
        }
        else{
        $insert = mysql_query("insert into creditdetails (unique_id,number) values ('".$uuid."','".$number."')");
          return array("msg"=>"insert successfully");
        }
    }
    
    
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
                      return array("email"=>$email,"fname"=>$fname,"lname"=>$lname,"cellphone"=>$cellphone," unique_id"=>$uuid);
              }
              else
              {
                      return array("msg"=>"No Record Found");
              }
    
    }
    
    
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
    
    
    function getitems_list()
    {
       $data =mysql_query("SELECT items.name, items.id, items.price,categories.catname
        FROM items
        INNER JOIN categories
        WHERE items.cat_id = categories.id
        LIMIT 0 , 30");
        
        if(mysql_num_rows($data)>0) {
         while($row=mysql_fetch_assoc($data)){
            $rows[] = $row;
           }
             return array("items"=>$rows);  
        }
        else
        {
         return array("msg"=>"No Products found");
        }
    }
    
      
    
    function checkhashSSHA($salt, $password) {
       $hash = base64_encode(sha1($password . $salt, true) . $salt);
       return $hash;
    }

    function hashSSHA($password) {
        $salt = sha1(rand());
        $salt = substr($salt, 0, 10);
        $encrypted = base64_encode(sha1($password . $salt, true) . $salt);
        $hash = array("salt" => $salt, "encrypted" => $encrypted);
        return $hash;
    }
    
   


?>
