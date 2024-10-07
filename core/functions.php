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
        $result = '<h6 class="text-center alert alert-success">Login Success, Redirecting...</h6>
        <script>
            setTimeout(function(){
                window.location.href = "./";
            },1800);
        </script>
        ';
    } else {
        $result = '<h6 class="text-center alert alert-danger">Incorrect Credentials, please check them.</h6>';
    }
    return $result;
}

// Registration for ( VISITOR AND CAFE_OWNER )
function register($POST)
{
    global $db;
    $name = $POST['name'];
    $username = $POST['username'];
    $email = $POST['email'];
    $phone = $POST['phone'];
    $pwd = $POST['password'];
    $r_pwd = $POST['re_password'];
    $user_type = $POST['user_type'];
    $dob = $POST['dob'];
    $gender = $POST['gender'];
    $city = $POST['city'];
    // EMPTY VARIABLES
    $response = '';
    $user_type_ = '';
    $diseases = null;
    $certificate = null;
    $experience = null;
    $checkin_time = null;
    $checkout_time = null;
    $weekend = 'no';

    if ($user_type == 'patient') {
        $user_type_ = 'Patient';
        $diseases = $POST['diseases'];
    }
    if ($user_type == 'doctor') {
        $user_type_ = 'Doctor';
        $certificate = $POST['certificate'];
        $experience = $POST['experience'];
        $checkin_time = $POST['checkin_time'];
        $checkout_time = $POST['checkout_time'];
        $weekend = $_POST['weekend_available'];
    }

    $checkEmail = $db->query("SELECT email FROM `users` WHERE `email`='$email'");
    $phone_length = strlen($phone);
    $pwd_length = strlen($pwd);
    if (mysqli_num_rows($checkEmail) > 0) :
        $response = '<h6 class="text-center alert alert-danger">Email Already Exist.</h6>';
    else :
        if ($phone_length < 10) :
            $response = '<h6 class="text-center alert alert-danger">Phone length must be 10.</h6>';
        else :
            if ($pwd_length < 6) :
                $response = '<h6 class="text-center alert alert-danger">Password length must be 6 characters long.</h6>';
            else :
                if ($pwd != $r_pwd) :
                    $response = '<h6 class="text-center alert alert-danger">Password & Confirm Password do not match.</h6>';
                else :
                    $pwd = md5($pwd);
                    $insertQ = $db->query("INSERT INTO `users` (name,username,email,password,phone,diseases,certificate,experience,role,clinic_id,checkin_time,checkout_time,weekend_available,dob,gender,city) VALUES('$name','$username','$email','$pwd','$phone','$diseases','$certificate','$experience','$user_type','1','$checkin_time','$checkout_time','$weekend','$dob','$gender','$city')");
                    if ($insertQ) {
                        $response = '<h6 class="text-center alert alert-success">' . $user_type_ . ' registered successfully.</h6>
                <script>
                    setTimeout(function(){
                        window.location.href = "./login.php";
                    },1800);
                </script>
                ';
                    }
                endif;
            endif;
        endif;
    endif;

    return $response;
}


function Add_Product($POST, $FILE, $cafe_owner_id, $CafeID)
{
    global $db;
    $targetDir = './img/prod/';
    $statusMsg = '';

    $prod_name = $POST['prod_name'];
    $reg_price = $POST['prod_reg_price'];
    $disc_price =  $POST['prod_disc_price'];
    $prod_desc = $POST['prod_desc'];
    $cat_id = $POST['category_id'];

    if (!empty($prod_name) && !empty($reg_price)) {
        if (!empty($FILE["prod_img"]["name"])) {

            $fileName = basename($FILE["prod_img"]["name"]);
            $targetFilePath = $targetDir . $fileName;
            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

            //allow certain file formats
            $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'webp');
            if (in_array($fileType, $allowTypes)) {
                //upload file to server
                if (move_uploaded_file($FILE["prod_img"]["tmp_name"], $targetFilePath)) {

                    $prod_Q = $db->query("INSERT INTO `products` (prod_name,prod_reg_price,prod_disc_price,prod_desc,prod_img,prod_category_id,cafe_owner_id,cafe_id) VALUES('$prod_name','$reg_price','$disc_price','$prod_desc','$targetFilePath','$cat_id','$cafe_owner_id','$CafeID')");

                    if ($prod_Q) {

                        $statusMsg = '<h6 class="alert alert-success w-75 text-center mx-auto">Product has been Added Successfully.</h6>
                        <script>
                            setTimeout(function(){
                                window.location.href = "./doctorDashboard.php";
                            },1800);
                        </script>
                        ';
                    } else {
                        $statusMsg = "Something went wrong!";
                    }
                } else {
                    $statusMsg = "Sorry, there was an error uploading your file.";
                }
            } else {
                $statusMsg = '<h6 class="alert alert-danger w-75 text-center mx-auto">Sorry, only JPG, JPEG, PNG & GIF files are allowed to upload.</h6>';
            }
        } else {

            $statusMsg = '<h6 class="alert alert-success w-50 text-center mx-auto">Please select a file to upload.</h6>';
        }
    } else {
        echo $statusMsg = '<h6 class="alert alert-danger w-50 text-center mx-auto">Please fill out all fields.</h6>';
    }
    echo $statusMsg;
}


function Edit_Product($POST, $FILE)
{
    global $db;
    $targetDir = './img/prod/';
    $statusMsg = '';
    $upd_p_Q = '';

    $c_id = $POST['c_id'];
    $prod_name = $POST['prod_name'];
    $reg_price = $POST['prod_reg_price'];
    $disc_price =  $POST['prod_disc_price'];
    $prod_desc = $POST['prod_desc'];
    $cat_id = $POST['category_id'];

    if (!empty($FILE['prod_img']['name'])) :

        $fileName = basename($FILE["prod_img"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        //allow certain file formats
        $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'webp');
        if (in_array($fileType, $allowTypes)) :

            if (move_uploaded_file($FILE["prod_img"]["tmp_name"], $targetFilePath)) :
                $upd_p_Q = $db->query("UPDATE `products` SET `prod_name`='$prod_name', `prod_reg_price`='$reg_price', `prod_disc_price`='$disc_price', `prod_desc`='$prod_desc', `prod_img`='$targetFilePath', `prod_category_id`='$cat_id' WHERE `id`='$c_id'");
                if ($upd_p_Q) :
                    $statusMsg = '<h6 class="alert alert-success text-center">' . $prod_name . ' has been updated.</h6>';
                endif;
            endif;

        else :
            $statusMsg = '<h6 class="alert alert-danger w-75 text-center mx-auto">Sorry, only JPG, JPEG, PNG & GIF files are allowed to upload.</h6>';
        endif;

    else :
        $upd_p_Q = $db->query("UPDATE `products` SET `prod_name`='$prod_name', `prod_reg_price`='$reg_price', `prod_disc_price`='$disc_price', `prod_desc`='$prod_desc', `prod_category_id`='$cat_id' WHERE `id`='$c_id'");
        if ($upd_p_Q) :
            $statusMsg = '<h6 class="alert alert-success text-center">' . $prod_name . ' has been updated.</h6>';
        endif;
    endif;
    echo $statusMsg;
}


function Add_Cafe($POST, $userID)
{
    global $db;
    $store_name = $POST['store_name'];
    $store_open = $POST['store_open'];
    $store_close = $POST['store_close'];
    $store_location  = $POST['store_location'];
    $msg = '';
    $add_cafe_Q = $db->query("INSERT INTO `cafe` (store_name,store_location,store_open,store_close,users_id) VALUES('$store_name','$store_location','$store_open','$store_close','$userID')");
    if ($add_cafe_Q) {
        $msg = '<h6 class="alert alert-success w-50 text-center mx-auto">Cafe Added Successfully.</h6>
        <script>
            setTimeout(function(){
                window.location.href = "./doctorDashboard.php";
            },1800);
        </script>
        ';
    } else {
        $msg = '<h6 class="alert alert-danger w-50 text-center mx-auto">Something went wrong!</h6>';
    }
    return $msg;
}

function profile_pic($POST, $FILE)
{
    $targetDir = './img/prod/';
    global $db;
    $statusMsg = '';
    $profile_id = $POST['profile_id'];
    if (!empty($FILE["profile_pic"]["name"])) {

        $fileName = basename($FILE["profile_pic"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        //allow certain file formats
        $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'webp');
        if (in_array($fileType, $allowTypes)) {
            //upload file to server
            if (move_uploaded_file($FILE["profile_pic"]["tmp_name"], $targetFilePath)) {

                $prod_Q = $db->query("UPDATE `users` SET `profile_pic`='$targetFilePath' WHERE `id`='$profile_id'");

                if ($prod_Q) {

                    $statusMsg = '<h6 class="alert alert-success w-75 text-center mx-auto">Profile Picture Updated.</h6>
                    <script>
                        setTimeout(function(){
                            window.location.href = "./doctorDashboard.php";
                        },1800);
                    </script>
                    ';
                } else {
                    $statusMsg = "Something went wrong!";
                }
            } else {
                $statusMsg = "Sorry, there was an error uploading your file.";
            }
        } else {
            $statusMsg = '<h6 class="alert alert-danger w-75 text-center mx-auto">Sorry, only JPG, JPEG, PNG & GIF files are allowed to upload.</h6>';
        }
    } else {

        $statusMsg = '<h6 class="alert alert-success w-50 text-center mx-auto">Please select a file to upload.</h6>';
    }

    return $statusMsg;
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


function add_category($POST, $FILE)
{
    global $db;
    $targetDir = './img/prod/';
    $statusMsg = '';
    $cat_name = $POST['category_name'];
    if (!empty($FILE["service_image"]["name"])) {

        $fileName = basename($FILE["service_image"]["name"]);
        $targetFilePath = $targetDir . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

        //allow certain file formats
        $allowTypes = array('jpg', 'png', 'jpeg', 'gif', 'webp');
        if (in_array($fileType, $allowTypes)) {
            //upload file to server
            if (move_uploaded_file($FILE["service_image"]["tmp_name"], $targetFilePath)) {

                $add_cat_Q = $db->query("INSERT INTO `services` (service_name,status,img) VALUES('$cat_name','1','$targetFilePath')");

                if ($add_cat_Q) {

                    $statusMsg = '<h6 class="alert alert-success w-75 text-center mx-auto">Service has been Added Successfully.</h6>
                    <script>
                        setTimeout(function(){
                            window.location.href = "./doctorDashboard.php";
                        },1800);
                    </script>
                    ';
                } else {
                    $statusMsg = "Something went wrong!";
                }
            } else {
                $statusMsg = "Sorry, there was an error uploading your file.";
            }
        } else {
            $statusMsg = '<h6 class="alert alert-danger w-75 text-center mx-auto">Sorry, only JPG, JPEG, PNG & GIF files are allowed to upload.</h6>';
        }
    } else {

        $statusMsg = '<h6 class="alert alert-success w-50 text-center mx-auto">Please select a file to upload.</h6>';
    }


    return $statusMsg;
    // if ($add_cat_Q) {
    //     return '<h6 class="text-center alert alert-success">' . $cat_name . ' has been added.</h6>
    //     <script>
    //     setTimeout(function(){
    //         window.location.href = "./add_services.php";
    //     },1800);
    //     </script>
    //     ';
    // }
}
function edit_service($POST)
{
    global $db;
    $cat_name = $POST['service_name'];
    $editCat_ID = $POST['editCat_ID'];
    $add_cat_Q = $db->query("UPDATE `services` SET `service_name`='$cat_name' WHERE `id`='$editCat_ID'");
    if ($add_cat_Q) {
        return '<h6 class="text-center alert alert-success">' . $cat_name . ' has been updated.</h6>
        <script>
        setTimeout(function(){
            window.location.href = "./add_services.php";
        },1800);
        </script>
        ';
    }
}


function add_reviews($POST, $userID)
{
    global $db;
    $msg = '';
    $stars = $POST['checked_count'];
    $comments = $POST['comments'];
    $doc_id = $POST['doc_id'];
    $res_id = $POST['res_id'];
    $reviewQ = $db->query("INSERT INTO `reviews` (rating,comments,doc_id,user_id) VALUES('$stars','$comments','$doc_id','$userID')");
    if ($reviewQ) :
        $db->query("UPDATE `reservation` SET `reviewed`='1' WHERE `id`='$res_id'");
        $msg = '<h6 class="text-center alert alert-success">Review has been added.</h6>
        <script>
        setTimeout(function(){
            window.location.href = "./dashboard.php";
        }, 1800);
        </script>
        ';
    else :
        $msg = '<h6 class="text-center alert alert-danger">Something went wrong.</h6>';
    endif;
    return $msg;
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
