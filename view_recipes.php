<?php
session_start();
require 'db_connect.php';
$query = "SELECT r.id, r.title, r.ingredients, r.instructions, r.image, u.username 
          FROM recipes r JOIN users u ON r.user_id = u.id";
$result = mysqli_query($conn, $query);
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Recipes</title>
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
            box-shadow: 0 2px 50px rgba(255, 0, 0, 1);
        }

        nav a:hover {
            background-color: #ff3333;
           color:white;
            transform: translateY(-3px);
            box-shadow: 0 9px 15px rgba(255, 0, 0, 1);
            border-top-left-radius: 999px;
            border-top-right-radius: 10px;
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 999px;
        }

        main {
            max-width: 1000px;
            margin: 2rem auto;
            padding: 2rem;
            background-color: transparent;
        }

        .recipe {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            margin-bottom: 2rem;
            padding: 1rem;
            border: 1px solid #ff3333;
            border-radius: 10px;
            background-color: #1e1e1e;
            box-shadow: 0 4px 10px rgba(255, 0, 0, 1);
            transition: all 0.3s ease;
            width: 100%;
            min-height: 250px;
            gap: 1rem;
        }

        .recipe:hover {
            background-color: #222;
            transform: translateY(-3px);
            box-shadow: 0 12px 20px rgba(255, 0, 0, 1);
        }

        .recipe img {
            width: 40%;
            height: auto;
            margin-top:auto;
            margin-bottom:auto;
            max-height: 230px;
            border-radius: 10px;
            object-fit: cover;
            box-shadow: 0 4px 10px rgba(255, 0, 0, 1);
        }

        .recipe-content {
            width: 58%;
        }

        .recipe-content h3 {
            color: #ff3333;
            margin-bottom: 0.5rem;
        }

        .recipe-content p {
            margin-bottom: 0.5rem;
        }

        strong {
            color: #ff7777;
        }

        @media screen and (max-width: 768px) {
            .recipe {
                flex-direction: column-reverse;
                align-items: center;
                text-align: center;
            }

            .recipe img,
            .recipe-content {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <header>
        <img id="logo" src="logo.png"/>
        <nav>
            <a href="index.php">Home</a>
            <a href="post_recipe.php">Share Recipe</a>
        </nav>
    </header>
    <main>
        <?php if (mysqli_num_rows($result) == 0): ?>
            <p>No recipes found.</p>
        <?php else: ?>
            <?php while ($recipe = mysqli_fetch_assoc($result)): ?>
                <div class="recipe">
                    <?php if (!empty($recipe['image'])): ?>
                        <img src="<?php echo $recipe['image']; ?>" alt="Recipe Image">
                    <?php endif; ?>
                    <div class="recipe-content">
                        <h3><?php echo $recipe['title']; ?></h3>
                        <p><strong>By:</strong> <?php echo $recipe['username']; ?></p>
                        <p><strong>Ingredients:</strong><br><?php echo nl2br($recipe['ingredients']); ?></p>
                        <p><strong>Instructions:</strong><br><?php echo nl2br($recipe['instructions']); ?></p>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </main>
</body>
</html>
