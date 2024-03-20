
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WebAuthn Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f4f6;
            color: #333;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            text-align: center;
        }
        .logo {
            width: 150px;
            margin-bottom: 20px;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff; /* Blue button color */
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            margin: 0 10px; /* Add margin between buttons */
        }
        .btn:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }
    </style>
</head>
<body>
    <div class="container">
        <img src="https://webauthn.io/static/images/shield.svg" alt="Logo" class="logo">
        <h1>Welcome to WebAuthn Authentication on Laravel</h1>
        <p>Please log in to continue.</p>
        <a href="{{ route('login') }}" class="btn">Log In</a>
        <a href="{{ route('register') }}" class="btn">Register</a>
    </div>
</body>
</html>
