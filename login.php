<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="stylelogin.css">
</head>
<body>
    
    <div class="container">
    <p><strong>Login Page</strong></p>
    <?php
      if(isset($_POST["login"])){
        $email=$_POST["email"];
        $password=$_POST["password"];
        require_once "database.php";
        $sql="SELECT * FROM users2 WHERE email = '$email'";
        $result=mysqli_query($conn,$sql);
        $user=mysqli_fetch_array($result,MYSQLI_ASSOC);
        if($user){
            if(password_verify($password,$user["password"])){
                header("Location: index.php");
                die();
            }
            else{
                echo "<div class ='alert alert-danger'>Invalid Password</div>";
            }
        }
        else{
            echo "<div class ='alert alert-danger'>Email does not exist</div>";
        
        }
      }
    ?>
        <form action="login.php" method="post">
            <div class="form-group">
                <input type="email" placeholder="Enter Email:" name="email" class="form-control">
            </div>

            <div class="form-group">
                <input type="password" placeholder="Enter Password:" name="password" class="form-control">
            </div>
            <div class="form-btn">
                <input type="submit" value="login" name="login" class="btn btn-primary">
            </div>
        </form>
    </div>
    
</body>
</html>