<?php
    session_start();
    include 'db_connect.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        $username = htmlspecialchars(trim($_POST['username']));
        $password = htmlspecialchars(trim($_POST['password']));

        $stmt = $conn->prepare("SELECT password, role FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1){
            $user = $result->fetch_assoc();
            
            if ($user['password'] === $password){
                $_SESSION['username'] = $username;
                $_SESSION['role'] = $user['role'];
                $_SESSION['user_id'] = $user['user_id'];
                if ($user['role'] === 'admin'){
                    header("Location: ../admin.php");
                } else{
                    header("Location: ../welcome.php?user=" . urlencode($username));
                    exit();
                }
            } else{
                header("Location: signin.php?error=" . urlencode("Invalid username or password"));
                exit();
            }
        } else{
            header("Location: signin.php?error=" . urlencode("Invalid username or password"));
            exit();
        }

    }
?>