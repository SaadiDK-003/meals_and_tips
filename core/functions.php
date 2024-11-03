<?php
require_once 'database.php';

// Check User is Loggedin or not
function isLoggedin()
{
    return isset($_SESSION['user']) ? true : false;
}

// This function will take login credentials and check if user is valid create a session by his " ID "
function login($email, $pwd)
{
    global $db;
    $result = '';
    $pwd = md5($pwd);
    $loginQ = $db->query("SELECT id FROM users WHERE `email`='$email' AND `password`='$pwd'");
    if (mysqli_num_rows($loginQ) > 0) {
        $fetchID = mysqli_fetch_object($loginQ);
        $_SESSION['user'] = $fetchID->id;
        $result = '<h6 class="text-center alert alert-success">Login success, redirecting...</h6>
        <script>
            setTimeout(function(){
                window.location.href = "./";
            },1800);
        </script>
        ';
    } else {
        $result = '<h6 class="text-center alert alert-danger">Incorrect credentials, please check.</h6>';
    }
    return $result;
}

// Registration
function register($POST)
{
    global $db;
    $username = $POST['username'];
    $email = $POST['email'];
    $pwd = $POST['password'];
    $role = $POST['role'];
    // EMPTY VARIABLES
    $response = '';

    $checkEmail = $db->query("SELECT email FROM `users` WHERE `email`='$email'");

    $pwd_length = strlen($pwd);
    if (mysqli_num_rows($checkEmail) > 0) :
        $response = '<h6 class="text-center alert alert-danger">Email Already Exist.</h6>';
    else :
        if ($pwd_length < 6) :
            $response = '<h6 class="text-center alert alert-danger">Password length must be 6 characters long.</h6>';
        else :
            $pwd = md5($pwd);
            $insertQ = $db->query("INSERT INTO `users` (username,email,password,role) VALUES('$username','$email','$pwd','$role')");
            if ($insertQ) {
                $response = '<h6 class="text-center alert alert-success">' . $role . ' registered successfully.</h6>
                <script>
                    setTimeout(function(){
                        window.location.href = "./login.php";
                    },1800);
                </script>
                ';
            }
        endif;
    endif;

    return $response;
}

function edit_user($POST)
{

    global $db;
    $pwd = '';
    $response = '';
    $diseases = null;
    $certificate = null;
    $experience = null;
    $checkin_time = null;
    $checkout_time = null;
    $weekend = 'no';
    $redirect = '';

    $old_owd = $POST['old_pwd'];
    $password =  $POST['password'];

    $user_id =  $POST['user_id'];
    $name =  $POST['name'];
    $email =  $POST['email'];
    $phone =  $POST['phone'];
    $dob =  $POST['dob'];
    $gender =  $POST['gender'];
    $city =  $POST['city'];
    $user_type_ = $POST['user_role'];


    if ($password == '') {
        $pwd = $old_owd;
    } else {
        $pwd = md5($password);
    }


    if ($user_type_ == 'patient') {
        $diseases = $POST['diseases'];
        $upd_Q = $db->query("UPDATE `users` SET `name`='$name', `email`='$email', `password`='$pwd', `phone`='$phone', `diseases`='$diseases', `dob`='$dob', `gender`='$gender', `city`='$city' WHERE `id`='$user_id'");
        $redirect = './dashboard.php';
    } else {
        $certificate = $POST['certificate'];
        $experience = $POST['experience'];
        $upd_Q = $db->query("UPDATE `users` SET `name`='$name', `email`='$email', `password`='$pwd', `phone`='$phone', `dob`='$dob', `gender`='$gender', `city`='$city', `certificate`='$certificate', `experience`='$experience' WHERE `id`='$user_id'");
        $redirect = './doctorDashboard.php';
    }


    if ($upd_Q) {
        echo '<h6 class="text-center alert alert-success">' . $user_type_ . ' has been updated successfully.</h6>
        <script>
        setTimeout(function(){
            window.location.href = "' . $redirect . '";
        }, 1800);
        </script>
        ';
    }
}

function add_user($POST)
{
    global $db;
    $cols = '';
    $values = '';
    $POST['password'] = md5($POST['password']);
    foreach ($POST as $key => $value) {
        if ($key != 'submit') {
            $cols .= $key . ',';
            $values .= "'" . $value . "',";
        }
    }
    $cols = substr($cols, 0, strlen($cols) - 1);
    $values = substr($values, 0, strlen($values) - 1);

    $add_Q = $db->query("INSERT INTO `users` ($cols) VALUES($values)");

    if ($add_Q) {
        echo '<h6 class="text-center alert alert-success">User has been added successfully.</h6>
        <script>
        setTimeout(function(){
            window.location.href = "./adminDashboard.php";
        }, 1800);
        </script>
        ';
    }
}

function forgetPassword($email, $phone)
{
    global $db;
    $msg = '';
    $checkQ = $db->query("SELECT * FROM `users` WHERE `email`='$email' AND `phone`='$phone'");
    if (mysqli_num_rows($checkQ) > 0) {
        $bytes = bin2hex(random_bytes(4));
        $newPwdMD5 = md5($bytes);
        $db->query("UPDATE `users` SET `password`='$newPwdMD5' WHERE `email`='$email' AND `phone`='$phone'");
        $msg = '<h6 class="text-center alert alert-success">Your New Password is: <span class="d-block">' . $bytes . '<span></h6>
        <script>
            setTimeout(function(){
                window.location.href = "./login.php";
            },10000);
        </script>
        ';
    } else {
        $msg = '<h6 class="text-center alert alert-danger">Invalid Credentials.</h6>';
    }
    return $msg;
}

function get_categories($table)
{
    global $db;
    $cat_Q = $db->query("SELECT * FROM `$table`");
    $options = '';
    while ($cat = mysqli_fetch_object($cat_Q)):
        $options .= '<option value="' . $cat->id . '">' . $cat->category_name . '</option>';
    endwhile;
    return $options;
}
