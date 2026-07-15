<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Contact Us</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"/>
  <style>
    body {
      background: linear-gradient(to right, #ff9a9e, #fad0c4);
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      text-align: center;
      display: flex;
      flex-direction: column;
      align-items: center;
      min-height: 100vh;
      justify-content: center;
    }

    h1.page-title {
      font-size: 38px;
      color: #333;
      text-transform: uppercase;
      margin-bottom: 20px;
    }

    .container {
      background: #fff;
      padding: 40px 30px;
      border-radius: 20px;
      max-width: 600px;
      width: 90%;
      box-shadow: 0 12px 25px rgba(0, 0, 0, 0.25);
      text-align: center;
      border-top: 5px solid #000;
      transition: transform 0.3s ease;
    }

    .logo {
      width: 120px;
      height: 120px;
      object-fit: cover;
      border-radius: 50%;
      margin-bottom: 20px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .logo:hover {
      transform: scale(1.1);
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.4);
    }

    .message-text {
      font-size: 18px;
      color: #444;
      margin-bottom: 30px;
      line-height: 1.6;
    }

    .info p {
      font-size: 16px;
      margin: 8px 0;
      color: #555;
      transition: color 0.3s ease, transform 0.3s ease;
    }

    .info p:hover {
      color: #d32f2f;
      transform: scale(1.05);
    }

    .info p i {
      color: #000;
      margin-right: 8px;
      transition: color 0.3s ease;
    }

    .contact a {
      font-size: 24px;
      color: #d32f2f;
      margin: 10px;
      transition: transform 0.3s ease, color 0.3s ease;
      text-decoration: none;
    }

    .contact a:hover {
      color: #b71c1c;
      transform: scale(1.2);
    }
  </style>
</head>
<body>

  <h1 class="page-title">Contact Us</h1>

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
    
  <div class="container">
    <img src="Images/TutorFinder1.png" alt="TutorFinder Logo" class="logo">

    <div class="message-text">
      We'd love to hear from you! Whether you have questions, suggestions, or need any assistance — our team is here to support you. Please feel free to reach out by email:
    </div>

    <div class="info">
      <p><i class="fas fa-envelope"></i><b>Email:</b> tutor.finder.js@gmail.com</p>
    </div>

    <div class="contact">
      <a href="mailto:tutor.finder.js@gmail.com" title="Send Email"><i class="fas fa-envelope"></i></a>
    </div>
  </div>

</body>
</html>
