<p align="center"><a href="https://centachat.local" target="_blank"><img src="https://iili.io/FhGQITl.md.png" width="200" alt="CentaChat Logo"></a></p> <p align="center"> <a href="#"><img src="https://img.shields.io/badge/Build-Passing-brightgreen" alt="Build Status"></a> <a href="#"><img src="https://img.shields.io/github/stars/yourusername/centachat" alt="GitHub Stars"></a> <a href="#"><img src="https://img.shields.io/github/license/yourusername/centachat" alt="License"></a> </p>
About CentaChat
CentaChat is a real-time chat application built with Laravel 12, Laravel Echo, Socket.IO, and Tailwind CSS. Designed to provide a modern, responsive, and WhatsApp-like chat experience, CentaChat allows users to:

Send & receive real-time messages

Upload and preview images/files before sending

View online/offline status of users

See when other users are typing

Dark/light mode support

Delete messages from chat

Authenticated chat for registered users only

CentaChat is fast, elegant, and ideal for anyone who wants to integrate a secure and powerful messaging platform into a Laravel-based system.

Features
⚡ Real-Time Chat with Socket.IO and Laravel broadcasting

🖼 Image Upload & Preview with file validation

🟢 User Online Presence

📝 Typing Indicator

🌙 Dark Mode Support

🔐 Authentication via Laravel Breeze

🧽 Clean and responsive UI (inspired by WhatsApp Web)

Learning CentaChat
CentaChat is built entirely with Laravel 12 and is intended for developers who want to learn:

How to build a chat application using Laravel broadcasting

How to configure Socket.IO with Laravel

How to manage real-time events, image uploads, typing notifications, and more

Integration with Tailwind CSS and Blade UI

You can learn more about Laravel from the official Laravel documentation or Laracasts.

Installation
bash
Copy
Edit
git clone https://github.com/RhandikaPutraSantoso/Chat-Realtime.git
cd centachat

composer install
npm install
npm run dev

cp .env.example .env
php artisan key:generate
php artisan migrate

php artisan serve
If using Socket.IO server separately:

bash
Copy
Edit
cd socket
node server.js
Contributing
Thank you for considering contributing to CentaChat! We welcome any pull requests or ideas to improve the system. Please follow these steps:

Fork the repo

Create a new branch (git checkout -b feature-name)

Commit your changes (git commit -m 'Add new feature')

Push to the branch (git push origin feature-name)

Open a Pull Request

Code of Conduct
Please review and abide by our Code of Conduct to ensure a welcoming community for everyone.

Security Vulnerabilities
If you discover a security vulnerability in CentaChat, please report it by opening an issue or emailing the maintainer directly. All reports will be addressed promptly.

License
CentaChat is open-sourced software licensed under the MIT license.

Credits
Built with ❤️ using Laravel, Tailwind CSS, and Socket.IO

Maintained by Rhandika Putra Santoso
