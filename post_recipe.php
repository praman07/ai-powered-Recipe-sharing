<?php
session_start();
require 'db_connect.php';
if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit;
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $ingredients = $_POST['ingredients'];
    $instructions = $_POST['instructions'];
    
    if (empty($title) || empty($ingredients) || empty($instructions)) {
        $error = "Please fill all fields.";
    } else {
        $image_path = '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
            $upload_dir = 'uploads/';
            $image_name = time() . '_' . basename($_FILES['image']['name']);
            $image_path = $upload_dir . $image_name;
            if (!move_uploaded_file($_FILES['image']['tmp_name'], $image_path)) {
                $error = "Failed to upload image.";
                $image_path = '';
            }
        }
        
        if (!isset($error)) {
            $user_id = $_SESSION['user_id'];
            $query = "INSERT INTO recipes (user_id, title, ingredients, instructions, image) VALUES ('$user_id', '$title', '$ingredients', '$instructions', '$image_path')";
            if (mysqli_query($conn, $query)) {
                $success = "Recipe posted successfully!";
            } else {
                $error = "Failed to post recipe.";
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
    <title>Post Recipe</title>
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
            box-shadow: 0 2px 50px rgba(255, 0, 0, 1    );
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
            max-width: 600px;
            margin: 2rem auto;
            padding: 2rem;
            background-color: rgba(0, 0, 0, 0.7);
            border-radius: 8px;
            border: 2px solid #ff3333;
            transition: all 0.3s ease;
            box-shadow: 0 8px 10px rgba(255, 0, 0, 1);
        }
        
        main:hover {
            background-color: rgba(0, 0, 0, 0.8);
            transform: translateY(-5px);
            box-shadow: 0 20px 30px rgba(255, 0, 0, 1);
        }
        
        .error {
            color: #ff3333;
            background-color: rgba(255, 0, 0, 1);
            padding: 0.5rem;
            margin-bottom: 1rem;
            border-radius: 4px;
            border-left: 3px solid #ff3333;
        }
        
        .success {
            background-color: rgba(255, 0, 0, 1);
            padding: 0.5rem;
            margin-bottom: 1rem;
            border-radius: 4px;
            border-left: 3px solid #33ff33;
        }
        
        .success a {
            
            background-color: rgba(255, 0, 0, 1);
            text-decoration: underline;
            background-color: transparent;
            padding: 0;
            border-radius: 0;
            box-shadow: none;
        }
        
        .success a:hover {
            background-color: rgba(255, 0, 0, 1);
            background-color: transparent;
            transform: none;
        }
        
        form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        
        label {
            color:white;
            font-weight: bold;
        }
        
        input, textarea {
            padding: 0.8rem;
            border-radius: 4px;
            border: 1px solid #ff3333;
            background-color: #1e1e1e;
            color: #f0f0f0;
            cursor: text;
            transition: all 0.3s ease;
        }

        textarea {
            resize: vertical;
            min-height: 100px;
        }
        
        input:focus, textarea:focus {
            outline: none;
            border-color: #ff7777;
            box-shadow: 0 0 8px rgba(255, 0, 0, 1);
        
        }
        button{
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
            transition: all 0.3s ease;
            border-top-left-radius: 999px;
            border-top-right-radius: 10px;
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 999px;
        }
    
    </style>
</head>
<body>
    <header>
        <h1>Post a Recipe</h1>
        <nav><a href="index.php">Home</a></nav>
    </header>
    <main>
        <?php if (isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <?php if (isset($success)): ?>
            <p class="success"><?php echo $success; ?></p>
        <?php endif; ?>
        <form method="post" enctype="multipart/form-data">
            <label for="title">Recipe Title:</label>
            <input type="text" id="title" name="title" required>
            <label for="ingredients">Ingredients:</label>
            <textarea id="ingredients" name="ingredients" required></textarea>
            <label for="instructions">Instructions:</label>
            <textarea id="instructions" name="instructions" required></textarea>
            <label for="image">Upload Image (optional):</label>
            <input type="file" id="image" name="image" accept="image/*">
            <button type="submit">Post Recipe</button>
        </form>
    </main>
</body>
</html>
