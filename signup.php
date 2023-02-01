<?php
include("conn.php");
if (isset($_SESSION["user-data"])) {
    header("Location: profile.php");  // if available , redirect to profile page
}

$err_message = $succsess_message = array();

if (isset($_POST['fullname']) && isset($_POST['email']) && isset($_POST['password'])) {


    //escaping special chars and extra white space with real_escape_string() and trim()
    $fullname = $conn->real_escape_string(trim($_POST['fullname']));
    $email = $conn->real_escape_string(trim($_POST['email']));
    $password = $conn->real_escape_string(trim($_POST['password']));
    $password_again = $conn->real_escape_string(trim($_POST['password_again']));

    //Fullname validation
    if ($fullname == "") {
        array_push($err_message, "Please provide your name!");
    }

    //Email validation
    if ($email == "" || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($err_message, "Please provide valid email!");
    }

    //Password validation
    if ($password == "" || strlen($password) < 8 || !preg_match("/^(?=.*\d)(?=.*[!@#$%^&*])(?=.*[a-z])(?=.*[A-Z]).{8,}$/", $password)) {
        array_push($err_message, "Please provide a strong password - min 8 letter, with at least a symbol, upper and lower case letters and a number!");
    }

    //password must be same
    if ($password != $password_again) {
        array_push($err_message, "Please does not matched!");
    }

    if (sizeof($err_message) == 0) {
        $sql = "SELECT * FROM users WHERE email = '$email'";
        $result = $conn->query($sql);

        if ($result->num_rows == 0) {  //checking whether email is already exists in DB
            $password = md5($password); //md5 password encryption
            $sql = "INSERT INTO users SET fullname = '$fullname', email = '$email', password = '$password' ";
            if ($conn->query($sql) === TRUE) { //email not exist , we will insert our record
                array_push($succsess_message, "Signed Up successfully!");
            } else {
                array_push($err_message, "Something went wrong!");
            }
        } else {
            array_push($err_message, "Account already exist!");
        }
    }
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="assets/js/script.js"></script>
</head>

<body>
    <div class="login-page">
        <div class="form">
        <h2>Signup</h2>
            <form class="register-form" name="registerForm" id="registerForm" action="" method="POST">
                <input type="text" placeholder="Enter your fullname" name="fullname" required />
                <input type="email" placeholder="Enter your email address" name="email" id="email" required />
                <input type="password" placeholder="Enter your password" name="password" id="password" required />
                <input type="password" placeholder="Enter your password again" name="password_again" id="password_again" required />
                <button type="submit">Create Account</button>
                <p class="message">Already registered? <a href="login.php">Sign In</a></p>
                <p class="err-message">
                    <?php
                    if (sizeof($err_message) > 0) {
                        foreach ($err_message as $key => $value) {
                            echo $value . "<br/>";
                        }
                    }
                    ?>
                </p>
                <p class="success-message">
                    <?php
                    if (sizeof($succsess_message) > 0) {
                        foreach ($succsess_message as $key => $value) {
                            echo $value;
                        }
                    }
                    ?>
                </p>
            </form>
        </div>
    </div>
</body>

</html>