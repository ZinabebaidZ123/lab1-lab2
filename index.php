<?php
  require_once("config.php");
  $name = isset($_POST["name"])? $_POST["name"]: " ";
  $email = isset($_POST["email"])? $_POST["email"]: " ";
  $pass = isset($_POST["pass"])? $_POST["pass"]: " ";
  $err = [];
  $mesg = isset($_POST["msg"])? $_POST["msg"]: " ";
//validate form
  if($_SERVER["REQUEST_METHOD"]=="POST"){

    if(count($_POST)>0){
        if(empty($name) || strlen($name)> $max_name_length){
           $err[] = "please be carefull that the length not larger than 10 char and field not empty";
        }
      
        if(empty($email) || !filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)||!isset($email) ){
            $err[] = "email value is empty or has invalid form";
        }
     
        if(empty($mesg) || strlen($mesg)>  $max_msg_length) {
            $err[] = "msg input is empty or greater than 25 char";
        }
      
        elseif(empty($err)){

        
             $usersData = 
            [ $name ,  $email ,
           $_SERVER["SERVER_ADDR"] ,date("F j, Y, g:i a") ];
        //to put the data on a file
        $strUsrData = implode("," , $usersData );
        $file =  fopen("visitor.txt" , "a+");
        fwrite($file , $strUsrData.PHP_EOL);
        //to read from file and write on a browser
        $data_on_file = file("visitor.txt");
        // print_r($data_on_file) ;
        echo "<h1>data on a file</h1>";
        foreach($data_on_file as $value){
            echo "<hr>" ;
            echo "<h2>Visitor info </h2>" ;
          
            // echo "visitor info : " .$value ."<hr>";
            $data = explode("," , $value);
            foreach($data as $val){
            echo $val ."<br>";
               
            }

        }
        fclose($file);
        echo $thanks_msg . "<br>";
        echo "<hr>";
        echo  "name is : " .$_POST["name"]."<br>";
        echo "email is : " .$_POST["email"]."<br>";
        echo "msg is " .$_POST["msg"]."<br>";
        }
    }
  }
?>

<html>
    <body>

    <div class="errs">
        
        <?php

    foreach($err as $error){
        
        echo "<h5 style = 'color:red;' >$error</h5>";
    }
         ?>
    </div>
        <form action="index.php" method= "POST">
            <div>
                username: <input type= "text" name = "name"
                value = " <?php echo $name ;?>" >
            </div>
            <div>
                email: <input type= "email" name = "email" 
                value = "<?php echo $email ;?> ">
            </div>
         
            <div>
                msg: <textarea name="msg" id="" cols="30" rows="10" 
                value = "<?php echo $mesg ;?> "></textarea>
            </div>
            <input type="submit" value = "send">
            <input type="reset" value = "reset">

        </form>
    </body>
</html>