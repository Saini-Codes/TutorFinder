<html>
<head>
    <title>Login Page</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background: linear-gradient(to right, #ff9a9e, #fad0c4);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-container {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 320px;
        }

        h1 {
            color: #ff4b5c;
            margin-bottom: 15px;
            font-size: 22px;
        }

        .input-group {
            display: flex;
            align-items: center;
            margin-bottom: 12px;
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 8px;
            background: #f9f9f9;
            position: relative;
        }

        .input-group input {
            border: none;
            outline: none;
            flex: 1;
            background: transparent;
            font-size: 14px;
            padding-right: 30px;
        }

        .input-group i {
            margin-right: 8px;
            color: #ff4b5c;
        }

        .toggle-password {
            position: absolute;
            right: 8px;
            cursor: pointer;
            color: #ff4b5c;
            font-size: 14px;
        }

        .login-btn {
            background: #ff4b5c;
            color: white;
            padding: 10px;
            width: 100%;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
            transition: 0.3s;
        }

        .login-btn:hover {
            background: #d43f50;
        }

        .forgot-password {
            display: block;
            margin-top: 10px;
            color: #555;
            font-size: 13px;
            text-decoration: none;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

        <div style="position: fixed; top: 20px; left: 20px; z-index: 1000;">
    <a href="Main.php" style="
        display: inline-flex;
        align-items: center;
        background: linear-gradient(135deg,rgb(253, 7, 7),rgb(255, 86, 81));
        border: none;
        border-radius: 10px;
        font-weight: 600;
        padding: 8px 16px;
        text-decoration: none;
        color: white;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        transition: transform 0.2s ease;
    " onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
        <img src="Images/Back.png" alt="Back" style="height: 20px; margin-right: 10px;">
        Back to Home
    </a>
</div>

    <div class="login-container">
        <h1>Tutor Log In</h1>
        <form action="TutorLogInSubmit.php" method="POST">
            <div class="input-group">
                <input type="text" name="username" placeholder="Username" required>
            </div>

            <div class="input-group">
                <input type="password" id="password" name="password" placeholder="Password" required>
                <i class="fa fa-eye toggle-password" id="togglePassword"></i>
            </div>

            <button class="login-btn" type="submit">Log In</button>
            <a href="TutorResetPassword.php" class="forgot-password">Reset Password!</a>
        </form>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const passwordInput = document.getElementById("password");
            const togglePassword = document.getElementById("togglePassword");

            togglePassword.addEventListener("click", () => {
            passwordInput.type = passwordInput.type === "password" ? "text" : "password";
            togglePassword.classList.toggle("fa-eye-slash");
            togglePassword.classList.toggle("fa-eye");
            });
        });
    </script>
</body>
</html>
