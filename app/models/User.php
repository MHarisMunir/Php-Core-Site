<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class User {
    
    private $db;
    public function __construct() {
        $this->db = new Database;
    }


    public function sendMail($email, $v_code){
        // require("PHPMailer/Exception.php");
        // require("PHPMailer/PHPMailer.php");
        // require("PHPMailer/SMTP.php");

        $mail = new PHPMailer(true);

        try {
            
            $mail->isSMTP();                                          //Send using SMTP
            $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                 //Enable SMTP authentication
            $mail->Username   = 'harismunir010@gmail.com';            //SMTP username
            $mail->Password   = 'Mharism1731998';                     //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;          //Enable implicit TLS encryption
            $mail->Port       = 587;                                  //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
        
            $mail->SMTPOptions = array(
                'ssl' => array(
                    'verify_peer' => false,
                    'verify_peer_name' => false,
                    'allow_self_signed' => true
                )
            );

            //Recipients
            $mail->setFrom('harismunir010@gmail.com', 'Haris');
            $mail->addAddress($email);     //Add a recipient
        
        
            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Verificaiton Mail from Haris';
            $mail->Body    = "Thanks for Registration, Kindly Click the link to verify the account.
            <br>
            <a href='http://localhost/Users/verifyUser?email=$email&v_code=$v_code'>Verify</a>";
        
            $mail->send();
            return true;
        } catch (Exception $e) {
            //echo $e;
            return false;
        }
    }
    // <a href=""></a>


    public function register($data) {
        $v_code = bin2hex(random_bytes(16));
        $this->db->query('INSERT INTO users (username, email, password, `verification_code`, `is_verified`) VALUES(:username, :email, :password, :verification_code, :is_verified)');

        //Bind values
        $this->db->bind(':username', $data['username']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['password']);
        $this->db->bind(':verification_code', $v_code);
        $this->db->bind(':is_verified', 0);

        $username = $data['username'];

        //Execute function
        if ($this->db->execute() && $this->sendMail($data['email'],$v_code)) {    
            return true; 
        } else {
            return $this->sendMail($data['email'],$v_code);
            //return false;
        }
    }

    public function login($username, $password) {
        $this->db->query('SELECT * FROM users WHERE username = :username');

        //Bind value
        $this->db->bind(':username', $username);

        $row = $this->db->single();

        if($row->is_verified == 1){
        $hashedPassword = $row->password;

        if (password_verify($password, $hashedPassword)) {
            
            $headers = array('alg'=>'HS256','typ'=>'JWT');
            $payload = array('username'=>$username, 'exp'=>(time() + 60));


            //creating JWT Token

            $jwt = generate_jwt($headers, $payload);
            // $week = new DateTime('+1 week');
            setcookie('jwt', $jwt, time()+3600, '/' , null, null, true);

            $this->db->query('UPDATE users SET jwt = :jwt WHERE username = :username');

            // //Bind values
            $this->db->bind(':jwt', $jwt);
            $this->db->bind(':username', $username);
            $this->db->execute();

            return $row;
        } else {
            return false;
        }
        }else{
            return false;
        }
    }
    public function exists($username){
        $this->db->query('SELECT * FROM users WHERE username = :username');
        $this->db->bind(':username', $username);
        $row = $this->db->single();
        if($row){
            return true;
        }else{
            return false;
        }
    }

    //Find user by email. Email is passed in by the Controller.
    public function findUserByEmail($email) {
        //Prepared statement
        $this->db->query('SELECT * FROM users WHERE email = :email');

        //Email param will be binded with the email variable
        $this->db->bind(':email', $email);

        //Check if email is already registered
        if($this->db->rowCount() > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function findAllUsers() {
        //Prepared statement
        
        $this->db->query('SELECT * FROM users');
        $users = $this->db->resultSet();

        //Check if email is already registered
        // if($this->db->rowCount() > 0) {
            return $users;
            // echo gettype($users);
        // } else {
        //     return 'No User Found!';
        // }
        
    }
    public function is_jwt_valid(){
        $this->db->query('SELECT * FROM users WHERE username = :username');
        $this->db->bind(':username', $_SESSION['username']);
        $row = $this->db->single();

        $row = (array)$row;
        $jwt = $row['jwt'];
        
        if($_COOKIE['jwt'] == $jwt){
            return TRUE;
        }
        else{
            return FALSE;
        }

    }

    public function verifiedUser(){
        if(isset($_GET['email']) && isset($_GET['v_code'])){

            // $this->db->query("SELECT * FROM users WHERE 'email' = '$_GET[email] AND 'v_code' = '$_GET[v_code]'");
            // $this->db->bind(':email', $_GET['email']);

            $this->db->query('SELECT * FROM users WHERE email = :email AND verification_code = :v_code');
            $this->db->bind(':email', $_GET['email']);
            $this->db->bind(':v_code', $_GET['v_code']);
            
            $row = $this->db->single();
            // $row = (array)$row;
            if($row){
                if($this->db->rowCount() > 0) {
                    if ($row->is_verified == 0){
                        $this->db->query("UPDATE users SET is_verified = '1' WHERE email = :email");
                        $this->db->bind(':email', $row->email);
                        $this->db->execute();
                        return true;
                    }else{
                        echo "User already Registered";
                    }
                }else{
                    echo 'Multiple Users found';
                }
                // print_r($row->verification_code);
                // echo $row;
            }
            else{
                echo "User not found";
            }


        }
    }


    
}
