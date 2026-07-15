# 🎓 TutorFinder

<div align="center">

# TutorFinder – Smart Online Tutor Finder Platform

### Connecting Students with Qualified Tutors through AI

![PHP](https://img.shields.io/badge/PHP-8.x-777BB4?style=for-the-badge&logo=php)
![Python](https://img.shields.io/badge/Python-3776AB?style=for-the-badge&logo=python)
![Rasa](https://img.shields.io/badge/Rasa-AI-5A17EE?style=for-the-badge)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql)
![Bootstrap](https://img.shields.io/badge/Bootstrap-5-7952B3?style=for-the-badge&logo=bootstrap)
![JavaScript](https://img.shields.io/badge/JavaScript-ES6-F7DF1E?style=for-the-badge&logo=javascript)
![HTML5](https://img.shields.io/badge/HTML5-E34F26?style=for-the-badge&logo=html5)
![CSS3](https://img.shields.io/badge/CSS3-1572B6?style=for-the-badge&logo=css3)

A full-stack web application that connects students with qualified tutors while providing an intelligent AI-powered chatbot for instant assistance.

⭐ Star this repository if you find it useful!

</div>

---

# 📖 About

TutorFinder is a web-based platform that simplifies tutor discovery by connecting students with experienced tutors based on subjects and location.

The platform consists of three major modules:

- Student Portal
- Tutor Portal
- Admin Dashboard

Additionally, TutorFinder includes an **AI-powered chatbot built using the Rasa Framework**, enabling users to receive instant assistance, answer common queries, and improve their overall experience.

---

# ✨ Features

## 👨‍🎓 Student Module

- Student Registration
- Secure Login
- Search Tutors
- Filter by Subject
- Filter by Location
- View Tutor Profiles
- Apply for Tutors
- Rate & Review Tutors
- Update Profile
- AI Chatbot Assistance

---

## 👨‍🏫 Tutor Module

- Tutor Registration
- Secure Login
- Profile Management
- Subject Selection
- Qualification Details
- Experience Management
- Receive Student Requests
- Manage Availability

---

## 🛡️ Admin Module

- Admin Dashboard
- Manage Students
- Manage Tutors
- Approve Tutor Accounts
- Subject Management
- Review Management
- Database Monitoring

---

# 🤖 AI Chatbot (Rasa)

TutorFinder integrates an intelligent chatbot powered by **Rasa Open Source Framework**.

### Chatbot Features

- Answer FAQs
- Guide New Users
- Registration Help
- Login Assistance
- Platform Navigation
- Tutor Search Guidance
- Natural Language Understanding (NLU)
- Context-Aware Conversations
- Fast Responses

---

# 🚀 Technology Stack

| Technology | Purpose |
|------------|---------|
| PHP | Backend |
| Python | AI Chatbot |
| Rasa Framework | NLP & Dialogue Management |
| MySQL | Database |
| HTML5 | Structure |
| CSS3 | Styling |
| Bootstrap 5 | Responsive UI |
| JavaScript | Client-side Logic |
| XAMPP | Local Development |

---

# 📂 Project Structure

```
TutorFinder/
│
├── admin/
├── chatbot/
│   ├── actions/
│   ├── data/
│   ├── models/
│   ├── config.yml
│   ├── domain.yml
│   ├── endpoints.yml
│   └── credentials.yml
│
├── student/
├── tutor/
├── css/
├── js/
├── images/
├── uploads/
├── database/
├── includes/
├── index.php
├── login.php
├── register.php
└── README.md
```

---

# ⚙️ Installation

## 1. Clone Repository

```bash
git clone https://github.com/Saini-Codes/TutorFinder.git
```

---

## 2. Move to XAMPP

Copy the project into

```
xampp/htdocs/
```

---

## 3. Start XAMPP

Start:

- Apache
- MySQL

---

## 4. Import Database

Open

```
http://localhost/phpmyadmin
```

Create a database (e.g., `tutorfinder`) and import the SQL file from the `database/` directory.

---

## 5. Configure the Rasa Chatbot

Navigate to the chatbot directory:

```bash
cd chatbot
```

Install dependencies:

```bash
pip install rasa
```

Train the chatbot:

```bash
rasa train
```

Run the action server:

```bash
rasa run actions
```

Run the chatbot server:

```bash
rasa run --enable-api
```

---

## 6. Launch the Website

Open your browser and visit:

```
http://localhost/TutorFinder/
```

---

# 📸 Screenshots

Add screenshots in the `screenshots/` folder.

Example:

```
screenshots/
│
├── home.png
├── student-dashboard.png
├── tutor-dashboard.png
├── admin-dashboard.png
├── chatbot.png
├── profile.png
└── search.png
```

---

# 🎯 Future Scope

- AI-Based Mock Interview for Tutors
- Tutor Recommendation System
- Live Chat
- Video Calling
- Google Maps Integration
- Email Notifications
- Voice Assistant
- Online Payments
- Tutor Booking
- Learning Dashboard
- Mobile Application
- Progressive Web App

---

# 🤝 Contributing

Contributions are welcome.

### Steps

```bash
Fork the repository
```

```bash
git checkout -b feature-name
```

```bash
git commit -m "Added feature"
```

```bash
git push origin feature-name
```

Create a Pull Request.

---

# 📌 Roadmap

- ✅ Student Module
- ✅ Tutor Module
- ✅ Admin Dashboard
- ✅ Tutor Search
- ✅ Authentication
- ✅ AI Chatbot (Rasa)
- ⏳ AI Mock Interview
- ⏳ Recommendation System
- ⏳ Video Meetings
- ⏳ Email Verification
- ⏳ Mobile App

---

# 👨‍💻 Developers

| Name | Role | GitHub |
|------|------|--------|
| **Saini Paul** | Full Stack Developer | https://github.com/Saini-Codes |
| **Jit Hazra** | Full Stack Developer | https://github.com/jit-Codes-ez |

---

# 📄 License

You are free to use and modify it for educational and research purposes.

---

# 🙏 Acknowledgements

Special thanks to:

- Rasa Open Source Community
- PHP Community
- Bootstrap Team
- MySQL Community
- GitHub

---

# 📬 Contact

### Saini Paul

GitHub: https://github.com/Saini-Codes

### Jit Hazra

GitHub: https://github.com/jit-Codes-ez

---

<div align="center">

## ⭐ Support the Project

If you found this project useful, please give it a ⭐ on GitHub.

Made with ❤️ by **Saini Paul** & **Jit Hazra**

Happy Coding 🚀

</div>
