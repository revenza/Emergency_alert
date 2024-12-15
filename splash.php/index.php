<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Emergency Alert</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Righteous&display=swap" rel="stylesheet">
    <style>
        body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            height: 100vh;
            margin: 0;
            font-family: "Poppins", sans-serif;
            background-color: whitesmoke;
            color: white;
            overflow: hidden;
        }

        .hero {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            margin-top: 80px;
        }

        .hero-teks {
            color: black;
            font-size: 2rem;
            margin-bottom: 20px;
            animation: fadeIn 1.5s ease-out;
        }

        h1 {
            font-size: 2.5rem;
            letter-spacing: 1px;
        }

        button {
            margin-top: 50px;
            padding: 12px 24px;
            font-size: 18px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 30px;
            cursor: pointer;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: background-color 0.3s, transform 0.2s;
        }

        button:hover {
            background-color: rgb(24, 66, 25);
            transform: translateY(-5px);
        }

        button:active {
            transform: translateY(1px);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>
    <section class="hero">
        <div class="hero-teks">
            <h1>Keep yourself safe with emergency anticipation</h1>
        </div>
        <a href="../login/login.php"><button>Let's Start</button></a>
    </section>
</body>

</html>