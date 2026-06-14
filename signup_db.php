<?php
    session_start(); //เก็บ session ไว้แจ้งเตือนการ register/login ว่า success มั้ย
    require_once "config/db.php";

    if(isset($_POST['signup'])){ //ถ้ามีการกดปุ่ม signup ให้ทำการเก็บข้อมูลจากฟอร์ม
        $firstname = $_POST['firstname'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $confirmPassword = $_POST['confirmPassword'];
        $role = "user"; //default role = user
 
        //ตรวจสอบว่ากรอกข้อมูลครบมั้ย
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){ //กรณีพิมพ์รูปแบบ email ไม่ถูกต้อง
            $_SESSION['error'] = "รูปแบบ email ไม่ถูกต้อง";
            header("location: index.php");
        }else if(strlen($password) < 6){ //ตรวจสอบความยาวของรหัสผ่าน
            $_SESSION['error'] = "รหัสผ่านต้องมีความยาวอย่างน้อย 6 ตัวอักษร";
            header("location: index.php");
        }else if(empty($confirmPassword)){
            $_SESSION['error'] = "กรุณากรอก Confirm Password";
            header("location: index.php");
        }else if($password != $confirmPassword){ //ตรวจสอบว่ารหัสผ่านตรงกันมั้ย
            $_SESSION['error'] = "รหัสผ่านไม่ตรงกัน";
            header("location: index.php");
        }else{
            try {
                //ตรวจสอบว่ามี email นี้ในระบบหรือยัง
                $check_email = $conn->prepare("SELECT email FROM users WHERE email = :email");
                $check_email->bindParam(":email", $email);
                $check_email->execute();
                $row = $check_email->fetch(PDO::FETCH_ASSOC);

                if($row['email'] == $email){
                    $_SESSION['warning'] = "มี email นี้ในระบบแล้ว <a href='signin.php'>ไปที่หน้า login</a>";
                    header("location: index.php");
                } else if (!isset($_SESSION['error'])) {
                    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = $conn->prepare("INSERT INTO users (firstname, lastname, email, password, role) 
                                            VALUES (:firstname, :lastname, :email, :password, :role)");
                    $stmt->bindParam(":firstname", $firstname);
                    $stmt->bindParam(":lastname", $lastname);
                    $stmt->bindParam(":email", $email);
                    $stmt->bindParam(":password", $passwordHash);
                    $stmt->bindParam(":role", $role);
                    $stmt->execute();
                    $_SESSION['success'] = "register successfully <a href='signin.php' class='alert-link'>Click here to login</a>";
                    header("location: index.php");
                }else{
                    $_SESSION['error'] = "เกิดข้อผิดพลาดในการสมัครสมาชิก";
                    header("location: index.php");
                }
            } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
        }
    }
?>