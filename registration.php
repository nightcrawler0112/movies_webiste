<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="stylelogin.css">
</head>
<body>
    <div class="container">
        <p><strong>Registration page</strong></p>
        <?php
        if(isset($_POST["submit"])){
            $fullname = $_POST["fullname"];
            $email = $_POST["email"];
            $password = $_POST["password"];
            $passwordRepeat = $_POST["repeat_password"];

            $password_hash = password_hash($password,PASSWORD_DEFAULT);


            $errors=array();

            if(empty($fullname) OR empty($email) OR empty($password) OR empty($passwordRepeat)){
                array_push($errors,"All fields are required");
            }
            if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
                array_push($errors,"Invalid Email");
            }
            if(strlen($password) < 6){
                array_push($errors,"Password must be at least 6 characters");
            }
            if($password != $passwordRepeat){
                array_push($errors,"Password did not match");
            }
            require_once "database.php";
            $sql="SELECT * FROM users2 WHERE email = '$email'";
            $result=mysqli_query($conn,$sql);
            $rowCount=mysqli_num_rows($result);
            if($rowCount > 0){
                array_push($errors,"Email already exists");
            }
            if(count($errors) > 0){
                foreach($errors as $error){
                    echo "<div class ='alert alert-danger'>".$error."</div>";
                }
            }
            else{
                //insert data into database
                
                $sql = "INSERT INTO users2 (full_name,email,password) VALUES (?,?,?)";
                $stmt = mysqli_stmt_init($conn);
                $prepareStmt = mysqli_stmt_prepare($stmt,$sql);
                if($prepareStmt){
                    mysqli_stmt_bind_param($stmt,"sss",$fullname,$email,$password_hash);
                    mysqli_stmt_execute($stmt);
                    echo "<div class ='alert alert-success'>Registration Successful</div>";
                    header("Location: login.php");
                }else{
                    die("something went wrong");
                }
            }
        }
        ?>


    <form action="registration.php" method="post">
    <div class="form-group">
                <input type="text" class="form-control" name="fullname" placeholder="Full Name:">
            </div>
            <div class="form-group">
                <input type="emamil" class="form-control" name="email" placeholder="Email:">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="password" placeholder="Password:">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="repeat_password" placeholder="Repeat Password:">
            </div>
            <div class="form-btn">
                <input type="submit" class="btn btn-primary" value="Register" name="submit">
            </div>
     </form>
    </div>
</body>
</html>