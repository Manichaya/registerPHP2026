<?php
    session_start(); //เก็บ session ไว้แจ้งเตือนการ register/login ว่า success มั้ย
    //test connect db
    require_once "config/db.php";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous"></head>
<body>
    <div class="container">
        <h3 class="mt-4">Register</h3>
        <hr>
        <form action="signup_db.php" method="post">
            <?php if(isset($_SESSION['error'])){?>
                <div class="alert alert-danger" role="alert">
                    <?php 
                        echo $_SESSION['error']; 
                        unset($_SESSION['error']);
                    ?>
                </div>
            <?php } ?>
            <?php if(isset($_SESSION['warning'])){?>
                <div class="alert alert-warning" role="alert">
                    <?php 
                        echo $_SESSION['warning']; 
                        unset($_SESSION['warning']);
                    ?>
                </div>
            <?php } ?>
            <?php if(isset($_SESSION['success'])){?>
                <div class="alert alert-success" role="alert">
                    <?php 
                        echo $_SESSION['success']; 
                        unset($_SESSION['success']);
                    ?>
                </div>
            <?php } ?>
            <div class="mb-3">
                <label for="firstname" class="form-label">First Name <span style="color: red;">*</span></label>
                <input type="text" class="form-control" name="firstname" required>
            </div>
            <div class="mb-3">
                <label for="lastname" class="form-label">Last Name <span style="color: red;">*</span></label>
                <input type="text" class="form-control" name="lastname" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email <span style="color: red;">*</span></label>
                <input type="email" class="form-control" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password <span style="color: red;">*</span></label>
                <input type="password" class="form-control" name="password" required>
            </div>
            <div class="mb-3">
                <label for="confirmPassword" class="form-label">Confirm Password <span style="color: red;">*</span></label>
                <input type="password" class="form-control" name="confirmPassword" required>
            </div>
            <button type="submit" name="signup" class="btn btn-primary">Sign Up</button>
        </form>
        <hr>
        <p>Already have an account? <a href="signin.php">Login</a></p>
    </div>
    
</body>
</html>