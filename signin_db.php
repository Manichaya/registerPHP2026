<?php
    session_start(); //เก็บ session ไว้แจ้งเตือนการ register/login ว่า success มั้ย
    require_once "config/db.php";

    if(isset($_POST['signin'])){ //ถ้ามีการกดปุ่ม signup ให้ทำการเก็บข้อมูลจากฟอร์ม
        $email = $_POST['email'];
        $password = $_POST['password'];
 
        //ตรวจสอบว่ากรอกข้อมูลครบมั้ย
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){ //กรณีพิมพ์รูปแบบ email ไม่ถูกต้อง
            $_SESSION['error'] = "รูปแบบ email ไม่ถูกต้อง";
            header("location: signin.php");
        }else if(empty($password)){
            $_SESSION['error'] = "กรุณากรอก Password";
            header("location: signin.php");
        }else{
            try {
                $check_data = $conn->prepare("SELECT * FROM users WHERE email = :email");
                $check_data->bindParam(":email", $email);
                $check_data->execute();
                $row = $check_data->fetch(PDO::FETCH_ASSOC);
               
                if($check_data -> rowCount() > 0){ //เช็คข้อมูลที่ login ว่ามีในระบบมั้ย
                    if($email == $row['email']){ //เช็ค email ว่าตรงกันมั้ย
                        if(password_verify($password, $row['password'])){ //เช็คว่ารหัสผ่านตรงกันมั้ย
                            if($row['role'] == 'admin') { //check role
                                $_SESSION['admin_login'] = $row['id']; //เก็บ session ของ admin
                                header("location: admin.php");
                            } else {
                                $_SESSION['user_login'] = $row['id']; //เก็บ session ของ user
                                header("location: user.php");
                            }
                        } else {
                            $_SESSION['error'] = "รหัสผ่านไม่ถูกต้อง";
                            header("location: signin.php");
                        }
                    }else{
                        $_SESSION['error'] = "ไม่มี email นี้ในระบบ";
                        header("location: signin.php");
                    }
                }else{
                    $_SESSION['error'] = "ไม่มีข้อมูลในระบบ";
                    header("location: signin.php");
                }
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }
    }
?>
    