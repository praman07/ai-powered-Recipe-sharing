<?php
session_start();
require 'db_connect.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    if (empty($email) || empty($password)) {
        $error = "Please fill all fields.";
    } else {
        $query = "SELECT id, username, password FROM users WHERE email = '$email'";
        $result = mysqli_query($conn, $query);
        $user = mysqli_fetch_assoc($result);
        if ($user && $password === $user['password']) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: index.php");
            exit;
        } else {
            $error = "Invalid email or password.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - Recipe Sharing Website</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
            cursor: pointer;
        }
        
        body {
            background-color: #121212;
            color: #f0f0f0;
            line-height: 1.6;
        }

        header {
            background-color: black;
            padding: 1.5rem;
            box-shadow: 0 8px 10px rgba(255, 0, 0,  1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            z-index: 10;
        }

        #logo {
            height:95px;
            box-shadow: 0 8px 10px rgba(255, 0, 0,  1);
            border-radius:10px;
            transition:0.5s ease;
        }

        nav {
            display: flex;
            gap: 1.5rem;
            align-items: center;
        }

        nav a {
            color: black;
            text-decoration: none;
            padding: 0.5rem 1rem;
            border-top-left-radius: 10px;
            border-top-right-radius: 999px;
            border-bottom-left-radius: 999px;
            border-bottom-right-radius: 10px;
            background-color: red;
            transition: all 0.3s ease;
            border: 1px solid transparent;
            box-shadow: 0 2px 50px rgba(255, 0, 0,  1);
        }

        nav a:hover {
            background-color: #ff3333;
                  color:white;
            transform: translateY(-3px);
            box-shadow: 0 9px 15px rgba(255, 0, 0, 1);
            transition: all 0.3s ease;
            border-top-left-radius: 999px;
            border-top-right-radius: 10px;
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 999px;
        }

        main {
            margin: 2rem auto;
            padding: 2rem;
            background-color: rgba(0, 0, 0, 0.7);
            border-radius: 8px;
            border: 2px solid #ff3333;
            transition: all 0.3s ease;
            box-shadow: 0 8px 10px rgba(255, 0, 0,  1);
            position:absolute;
            width:50%;
            top:17rem;
            left:25%;
        }

        main:hover {
            background-color: rgba(0, 0, 0, 0.8);
            transform: translateY(-5px);
            box-shadow: 0 20px 30px rgba(255, 0, 0,  1);
        }

        .error {
            color:rgb(0, 0, 0);
            background-color:orange;
            padding: 0.5rem;
            margin-bottom: 1rem;
            border-radius: 4px;
            border-left: 3px;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 2rem;
        }

        label {
            color: #ff7777;
            font-weight: bold;
        }

        input {
            padding: 0.8rem;
            border-radius: 4px;
            border: 1px solid #ff3333;
            background-color: #1e1e1e;
            color: #f0f0f0;
            cursor: text;
            transition: all 0.3s ease;
        }

        input:focus {
            outline: none;
            border-color: #ff7777;
            box-shadow: 0 0 8px rgba(255, 0, 0,  1);
        }

        button {
            color: black;
            text-decoration: none;
            padding: 0.8rem 1rem;
            border-top-left-radius: 10px;
            border-top-right-radius: 999px;
            border-bottom-left-radius: 999px;
            border-bottom-right-radius: 10px;
            background-color: red;
            transition: all 0.3s ease;
            border: none;
            font-weight: bold;
            font-size: 1rem;
            margin-top: 1rem;
            box-shadow: 0 2px 50px rgba(255, 0, 0, 1);
        }

        button:hover {
            background-color: #ff3333;
            color: #000;
            transform: translateY(-3px);
            box-shadow: 0 9px 15px rgba(255, 0, 0,  1);
            transition: all 0.3s ease;
            border-top-left-radius: 999px;
            border-top-right-radius: 10px;
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 999px;
        }
         .video-section {
            width: 100%;
            height: 68vh;
            position: relative;
            overflow: hidden;
            border-radius: 80px;
            margin: 2rem 0;
        }

        video{
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius:80px;
        }
    </style>
</head>
<body>
    <header>
        <img id="logo" src="logo.png"/>
        <nav>
            <a href="index.php">Home</a>
            <a href="signup.php">Sign Up</a>
            <a href="view_recipes.php">View Recipes</a>
        </nav>
    </header>
    <div class="video-section">
    <video autoplay muted loop >
        <source src="video1.mp4" type="video/mp4">
    </video>    
</div>
    <main>
    
        <?php if (isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>

        <form method="post">
            <input type="email" id="email" name="email" required placeholder="E-mail">
            
            <input type="password" id="password" name="password" required placeholder="Password"> 
            
            <button type="submit">Sign In</button>
        </form>
    </main>
</body>
</html>
