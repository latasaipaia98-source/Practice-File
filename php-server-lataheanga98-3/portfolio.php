<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workday-Lite</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body id="home">

    <header style="text-align: center; font-size: 40px;">
        <h1>Welcome to My Portfolio</h1>
    </header>

    <nav>
    <ul style="list-style-type: none; padding: 0; display: flex; justify-content: space-around; font-size: 30px;">
        <li><a href="portfolio.php">Home</a></li>
        <li><a href="projects.php">Projects</a></li>
        <li><a href="contact.php">Contact</a></li>
    </ul>
</nav>

    <main>

        <section id="about">
            <div style="text-align: center; margin-bottom: 20px;">
                <img src="lata.JPG" alt="My Photo" style="width: 150px; height: 150px; border-radius: 50%; object-fit: cover;">
            </div>

            <p style="font-size: 30px; text-align: center;">
                Aloha! My name is Lataheanga Saipaia and I am from Tonga. 
                I am currently studying Computer Science at BYUH. 
                I am a Junior and I will be graduating in Winter 2026. 
                I love to play pickleball in my free time with my friends, 
                and I also love going to the beach and hanging out with friends.
            </p>
        </section>


        <section style="text-align: center; margin-top: 40px;">
            <p>
                <?php 
                if(isset($_GET['value'])) {
                    echo "The query string value is: " . htmlspecialchars($_GET['value']);
                } else {
                    echo "No query string value found.";
                }
                ?>
            </p>
        </section>

    </main>

    <footer>
        <p>&copy; 2024 Lataheanga. All Rights Reserved.</p>
    </footer>

</body>
</html>