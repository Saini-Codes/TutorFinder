<html>
<head>
    <title>Admin Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: radial-gradient(circle at top, rgba(255, 0, 0, 0.4), rgba(18, 18, 18, 1));
            color: #ffffff;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .admin-container {
            background: #1e1e1e;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(255, 0, 0, 0.5);
            text-align: center;
            width: 350px;
        }

        .admin-container h1 {
            color: #ff4b5c;
            margin-bottom: 20px;
        }

        .input-group {
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            background: #333;
            border: 1px solid #ff4b5c;
            border-radius: 5px;
            padding: 10px;
            position: relative;
        }

        .input-group input {
            border: none;
            outline: none;
            flex: 1;
            background: transparent;
            color: #ffffff;
            font-size: 16px;
            padding-right: 35px;
        }

        .input-group input::placeholder {
            color: #bbbbbb;
        }

        .toggle-password {
            position: absolute;
            right: 10px;
            cursor: pointer;
            color: #ff4b5c;
        }

        .login-btn {
            background: #ff4b5c;
            color: white;
            padding: 10px;
            width: 100%;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            cursor: pointer;
            transition: 0.3s;
        }

        .login-btn:hover {
            background: #d43f50;
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <h1>Admin Log In</h1>
        <form action="AdminLoginSubmit.php" method="POST">
            <div class="input-group">
                <input type="text" name="username" placeholder="Username" required>
            </div>
            <div class="input-group">
                <input type="password" id="password" name="password" placeholder="Password" required>
                <i class="fa fa-eye toggle-password" id="togglePassword"></i>
            </div>
            <button class="login-btn" type="submit">Log In</button>
        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const passwordInput = document.getElementById("password");
            const togglePassword = document.getElementById("togglePassword");

            togglePassword.addEventListener("click", function () {
                if (passwordInput.type === "password") {
                    passwordInput.type = "text";
                    this.classList.replace("fa-eye", "fa-eye-slash"); 
                } else {
                    passwordInput.type = "password";
                    this.classList.replace("fa-eye-slash", "fa-eye"); 
                }
            });
        });
    </script>
</body>
</html>
