<?php
use Predis;
header("Access-Control-Allow-Origin: *");
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');

require '../vendor/autoload.php';

require "../vendor/predis/predis/autoload.php";

Predis\Autoloader::register();
if($_SERVER['REQUEST_METHOD']=="POST")
{
    $email=$_POST['email'];
    $password=$_POST['pswd'];
    $dbhost="localhost";
    $dbuser="root";
    $dbpass="";
    $dbname="guvi"; 

    if(!$con=mysqli_connect($dbhost,$dbuser,$dbpass,$dbname))
    {
        die("Connection Failed");
    }
    if(!empty($email)&&!empty($password))
   {
    $sql = "SELECT * FROM users WHERE email=?";
    $stmt = $con->prepare($sql); 
    $stmt->bind_param("s", $email);
    if($stmt->execute())
    {
    $res= $stmt->get_result();
    session_start();
    $count=isset($_SESSION['count'])?$_SESSION['count']:1;
    echo $count;
    $_SESSION['count']=++$count;
    if($res && mysqli_num_rows($res)>0)
        {
            $user_data = $res->fetch_assoc();
            if($user_data['password']==$password)
            {
                echo "Login Successfull";
            }
            else
            {
                echo "Wrong Password";
            }
            die;
        }
   }
    echo"Invalid Username or Password";
}
   else
   {
    echo"Invalid Username or Password";
   }
}