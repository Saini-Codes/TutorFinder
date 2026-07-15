<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registration Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: Arial, sans-serif; }
        body {
            background: linear-gradient(to right, #ff9a9e, #fad0c4);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 1300px;
            padding: 20px;
        }
        .registration-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            text-align: center;
            width: 1000px;
        }

        .registration-container h1{
            color:rgb(255, 86, 92);
        }

        .form-control, .form-select {
            border-radius: 5px;
            margin-bottom: 10px;
        }
        .gender-container {
            display: flex;
            justify-content: left;
            gap: 100px;
            margin-bottom: 10px;
        }
        .file-input {
            display: block;
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            cursor: pointer;
        }
        .subject-container, .fees-container {
            display: flex;
            gap: 10px;
            margin-bottom: 10px;
        }
        #location-btn {
            display: none;
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

<div class="registration-container">
    <h1>Tutor Registration Form</h1>
    <form action="TutorRegistrationSubmitOTP.php" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate> 
        <input type="text" name="name" class="form-control" placeholder="Full Name" required>

        <!-- Address Fields -->
        <input type="text" name="street" class="form-control address-field" placeholder="Street Name" required>
        <button type="button" class="btn btn-info w-100 mb-2" id="location-btn" onclick="getLocation()">Use My Current Location</button>
        <input type="text" name="city" class="form-control address-field" placeholder="City Name" required>
        <input type="text" name="pin" class="form-control address-field" placeholder="Zip Code" required>
        <input type="text" name="district" class="form-control address-field" placeholder="District" required>
        <input type="text" name="state" class="form-control address-field" placeholder="State" required>



        <input type="email" name="email1" class="form-control" placeholder="Enter Email" required>
        <input type="password" name="email2" class="form-control" placeholder="Confirm Email" required>
        <input type="number" name="phone" class="form-control" placeholder="Phone Number" required>

        <div class="gender-container">
            <label class="form-label">Gender:</label>
            <div class="form-check">
                <input type="radio" id="male" name="gender" value="Male" class="form-check-input" required>
                <label for="male" class="form-check-label">Male</label>
            </div>
            <div class="form-check">
                <input type="radio" id="female" name="gender" value="Female" class="form-check-input" required>
                <label for="female" class="form-check-label">Female</label>
            </div>
        </div>

        <div class="subject-container">
            <input type="text" name="sub1" class="form-control" placeholder="Subject 1" required>
            <input type="text" name="sub2" class="form-control" placeholder="Subject 2">
            <input type="text" name="sub3" class="form-control" placeholder="Subject 3">
        </div>

        <div class="fees-container">
            <input type="text" name="fees1" class="form-control" placeholder="Fees For Subject 1" required>
            <input type="text" name="fees2" class="form-control" placeholder="Fees For Subject 2">
            <input type="text" name="fees3" class="form-control" placeholder="Fees For Subject 3">
        </div>

        <input type="text" name="qualifications" class="form-control" placeholder="Qualifications: i.g. 'M.Sc','M.Tech'" required>

        <input type="text" name="profession" class="form-control" placeholder="Current State of Profession i.g. 'Proff. at XYZ University'" required>

        <label for="logo">Upload Tuition Logo</label>
        <input type="file" id="logo" name="logo" accept="image/*" class="file-input" required>

        <label for="cv">Upload Teacher CV</label>
        <input type="file" id="cv" name="cv" accept="image/*" class="file-input" required>

        <input type="hidden" name="latitude" id="latitude">
        <input type="hidden" name="longitude" id="longitude">

        <button type="submit" class="btn btn-danger w-100">Submit</button>
    </form>
</div>

<script>
    let locationUsed = false;
    
document.querySelectorAll('.address-field').forEach(input => {
    input.addEventListener('focus', () => {
        if (!locationUsed) {
            document.getElementById('location-btn').style.display = 'block';
        }
    });
});

function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(async function (position) {
            const lat = position.coords.latitude.toFixed(6);
            const lon = position.coords.longitude.toFixed(6);

            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lon;

            const apiKey = 'c06ff9bdc641449bbf150318f6ea9842';
            const url = `https://api.opencagedata.com/geocode/v1/json?q=${lat}+${lon}&key=${apiKey}`;

            const response = await fetch(url);
            const data = await response.json();

            if (data && data.results.length > 0) {
                const components = data.results[0].components;
                document.querySelector('input[name="street"]').value = components.road || '';
                document.querySelector('input[name="city"]').value = components.city || components.town || components.village || '';
                document.querySelector('input[name="pin"]').value = components.postcode || '';
                document.querySelector('input[name="district"]').value =components.state_district|| '';
                document.querySelector('input[name="state"]').value = components.state || '';

                document.getElementById('location-btn').style.display = 'none';
                locationUsed = true;
            } else {
                alert("Could not fetch address details.");
            }
        },
        function () {
            alert("Permission denied or unable to fetch location.");
        });
    } else {
        alert("Geolocation not supported by this browser.");
    }
}
</script>

</body>
</html>
