<?php
include("conn.php");
if (!isset($_SESSION["user-data"])) {
    header("Location: login.php");  // if not available , redirect to login page
}

$err_message = $succsess_message = array();

if (isset($_POST['update_profile'])  ) {


    //escaping special chars and extra white space with real_escape_string() and trim()
    $fullname = $conn->real_escape_string(trim($_POST['fullname']));
   
    

    //Fullname validation
    if ($fullname == "") {
        array_push($err_message, "Please provide your name!");
    }


    if (isset($_POST['password']) && $_POST['password'] != ""  ) {

        $password = $conn->real_escape_string(trim($_POST['password']));
        $password_again = $conn->real_escape_string(trim($_POST['password_again']));

        //Password validation
        if ($password == "" || strlen($password) < 8 || !preg_match("/^(?=.*\d)(?=.*[!@#$%^&*])(?=.*[a-z])(?=.*[A-Z]).{8,}$/", $password)) {
            array_push($err_message, "Please provide a strong password - min 8 letter, with at least a symbol, upper and lower case letters and a number!");
        }

        //password must be same
        if ($password != $password_again) {
            array_push($err_message, "Please does not matched!");
        }

    }

    if (sizeof($err_message) == 0) {
       
            $email = $_SESSION['user-data']['email'];
            
            $sql = "UPDATE users SET fullname = '$fullname' "; 


            if (isset($_POST['password'])  ) {
                $password = md5($password); //md5 password encryption
                $sql .= " , password='$password' ";
            }

            $sql .= " WHERE email = '$email' ";

            if ($conn->query($sql) === TRUE) { //upadte the record
                array_push($succsess_message, "Profile updated successfully!");

                //Upadte session with updated profile data
                $sql = "SELECT * FROM users WHERE email = '$email' ";
                $result = $conn->query($sql);
                $row = $result->fetch_assoc();
                $_SESSION["user-data"] = $row;

            } else {
                array_push($err_message, "Something went wrong!");
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
    <title>My Profile</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="assets/js/script.js"></script>
</head>

<body>
    <div class="login-page">
        <div class="form">
        <h1>Welcome, <?php echo  $_SESSION["user-data"]['fullname'];?></h1>
            <form class="register-form"  action="" method="POST">
                <input type="text" placeholder="Enter your fullname" name="fullname" value="<?php echo $_SESSION["user-data"]['fullname']; ?>" required />
                <input type="email" placeholder="Enter your email address" name="email" id="email" value="<?php echo $_SESSION["user-data"]['email']; ?>" readonly />
                <input type="password" placeholder="Enter your password" name="password" id="password"  />
                <input type="password" placeholder="Enter your password again" name="password_again" id="password_again"  />
                <button type="submit" name="update_profile">Update Profile</button>
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
            <form method="POST" action="logout.php">
                <button type="submit" name="logout" class="logout-btn">Logout</button>
            </form>
        </div>
    </div>
</body>

</html>