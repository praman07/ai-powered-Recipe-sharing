<?php
require 'db_connect.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    if (empty($username) || empty($email) || empty($password)) {
        $error = "Please fill all fields.";
    } else {
        $query = "SELECT id FROM users WHERE email = '$email' OR username = '$username'";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) > 0) {
            $error = "Email or username already exists.";
        } else {
            $query = "INSERT INTO users (username, email, password) VALUES ('$username', '$email', '$password')";
            if (mysqli_query($conn, $query)) {
                $success = "Registration successful! <a href='signin.php'>Sign in</a>.";
            } else {
                $error = "Registration failed.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Recipe Sharing Website</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Arial', sans-serif;
            cursor: pointer;
        }

        #bgVideo {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            object-fit: cover;
            z-index: -1;
            opacity: 0.4;
            pointer-events: none;
        }

        body {
            background-color: #121212;
            color: #f0f0f0;
            line-height: 1.6;
        }

        header {
            background-color: black;
            padding: 1.5rem;
            box-shadow: 0 8px 10px rgba(255, 0, 0, 1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            z-index: 10;
        }

        #logo {
            height: 95px;
            box-shadow: 0 8px 10px rgba(255, 0, 0, 1);
            border-radius: 10px;
            transition: 0.5s ease;
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
            box-shadow: 0 2px 50px rgba(255, 0, 0, 1);
        }

        nav a:hover {
            background-color: #ff3333;
            color: white;
            transform: translateY(-3px);
            box-shadow: 0 9px 15px rgba(255, 0, 0, 1);
            border-top-left-radius: 999px;
            border-top-right-radius: 10px;
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 999px;
        }

        main {
            max-width: 600px;
            margin: 2rem auto;
            padding: 2rem;
            background-color: rgba(0, 0, 0, 0.7);
            border-radius: 8px;
            border: 2px solid #ff3333;
            transition: all 0.3s ease;
            box-shadow: 0 8px 10px rgba(255, 0, 0, 1);
            z-index: 1;
            position: relative;
        }

        main:hover {
            background-color: rgba(0, 0, 0, 0.8);
            transform: translateY(-5px);
            box-shadow: 0 20px 30px rgba(255, 0, 0, 1);
        }

        .error {
            color:rgb(0, 0, 0);
            background-color: rgba(255, 0, 0, 1);
            padding: 0.5rem;
            margin-bottom: 1rem;
            border-radius: 4px;
            border-left: 3px solid #ff3333;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
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
            box-shadow: 0 0 8px rgb(160, 158, 158);
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
            box-shadow: 0 9px 15px rgba(255, 0, 0, 1);
            border-top-left-radius: 999px;
            border-top-right-radius: 10px;
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 999px;
        }
    </style>
</head>
<body>
    <video autoplay muted loop id="bgVideo">
        <source src="video3.mp4" type="video/mp4">
        Your browser does not support HTML5 video.
    </video>
    <header>
        <img id="logo" src="logo.png"/>
        <nav>
            <a href="index.php">Home</a>
            <a href="signin.php">Sign In</a>
            <a href="view_recipes.php">View Recipes</a>
        </nav>
    </header>
    <main style="margin-top:130px;">
        <?php if (isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        
        <?php if (isset($success)): ?>
            <p class="success"><?php echo $success; ?></p>
        <?php endif; ?>
     
        <form method="post">
            <input type="text" id="username" name="username" required placeholder="Username">
            <input type="email" id="email" name="email" required placeholder="E-mail">
            <input type="password" id="password" name="password" required placeholder="Password">
            <button type="submit">Sign Up</button>
        </form>
    </main>

</body>
</html>
