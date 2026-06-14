<?php
    session_start(); //เก็บ session ไว้แจ้งเตือนการ register/login ว่า success มั้ย
    require_once "config/db.php";
    if(!isset($_SESSION['user_login'])){ //ถ้าไม่มี session user_login ให้กลับไปหน้า login
        $_SESSION['error'] = "กรุณาเข้าสู่ระบบก่อน";
        header("location: signin.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous"></head>
</head>
<body>
    <div class="container">
        <?php 
            if(isset($_SESSION['user_login'])){
                $user_id = $_SESSION['user_login'];
                $stmt = $conn->query("SELECT * FROM users WHERE id = $user_id");
                $stmt->execute();
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
            }
        ?>
            <h1>Welcome, <?php echo $row['firstname'].' '.$row['lastname']?>!</h1>
            <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>
</body>
</html>