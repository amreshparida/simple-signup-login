<?php
include("conn.php");
if (isset($_SESSION["user-data"])) {
    header("Location: profile.php");  // if available , redirect to profile page
}

$err_message = $succsess_message = array();


if (isset($_POST['email']) && isset($_POST['password'])) {

    //escaping special chars and extra white space with real_escape_string() and trim()
    $email = $conn->real_escape_string(trim($_POST['email']));
    $password = $conn->real_escape_string(trim($_POST['password']));
    $password = md5($password); //md5 password encryption
    $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) { //checking whether user with provided email and password exist or not
        $row = $result->fetch_assoc();
        $_SESSION["user-data"] = $row; //We will set the session for our logged in user
        header("Location: profile.php"); // now we will redirect our user to his/her profile page
    } else {
        array_push($err_message, "Wrong login credentials!");
    }
}



?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>
    <div class="login-page">
        <div class="form">
        <h2>Login</h2>
            <form class="login-form" name="loginForm" action="" method="POST">
                <input type="email" placeholder="Enter your email" name="email" id="email" required />
                <input type="password" placeholder="Enter your password" name="password" id="password" required />
                <button type="submit" name="login">Login</button>
                <p class="message">Not registered? <a href="signup.php">Create an account</a></p>
                <p class="err-message">
                    <?php
                    if (sizeof($err_message) > 0) {
                        foreach ($err_message as $key => $value) {
                            echo $value . "<br/>";
                        }
                    }
                    ?>
                </p>
            </form>
        </div>
    </div>
</body>

</html>