# Factory Dashboard

Factory Dashboard is a web application for factory management created using the Laravel framework. In addition to Laravel, Vue was also used. These frameworks were integrated using the Inertia framework that allows for building SPA applications despite following the MVC architecture. The application allows for managing and monitoring the system, sending notification emails, and generating various reports and files for further analysis. The application also utilizes web sockets. The application is created on a PostgreSQL database.

The application logs operations performed by administrators and records each of them as logs, which are accessible to every user.

The application allows generating files in several formats. Firstly, it enables generating a list of factory employees in CSV format. It also allows exporting all system logs in JSON format. Additionally, the system can generate PDF reports of products manufactured in the factory. For these operations, the application uses the League\CSV and DOMPDF libraries.

Creating a new user in the system involves sending them an email notification that their account has been created. The email contains the user's login credentials. The email is sent using SMTP from a specified Gmail account. The task of sending an email goes to the queue first. From there, the queue agent sends them asynchronously.

Administrators receive real-time notifications about actions in the system. This was achieved using web sockets, which operate on a Pusher server. The notification messages themselves were implemented using Vue-Toastification.

## Used Tools

### Backend
- PHP 8.3.6
- Laravel 11.7.0
- Inertia.js 1.0.0
- Laravel DOMPDF 2.2.0
- Pusher 7.2.4
- League\CSV 9.0.0
- Sail 1.30.2
- IDE Helper 3.0.0

### Frontend
- HTML 5
- CSS 3
- TypeScript 5.5.3
- Vue 3 (Inertia.js) 1.2.0
- Bootstrap 5.3.3
- Bootstrap Icons 1.11.3
- Vue Toastification 2.0.0
- Laravel Echo 1.16.1
- Pusher.js 8.4.0
- Vue-Multiselect 3.0.0
- UAParser.js 1.0.38

## Requirements

For running the application you need:

- [PHP](https://www.php.net/manual/en/install.windows.php)
- [composer](https://getcomposer.org)
- [PostgreSQL](https://www.postgresql.org.pl)

Or only:

- [Docker](https://www.docker.com)

## How to run
1. Execute command `git clone https://github.com/Ilvondir/factory-dashboard`.
2. Create `factory` database in PostgreSQL.
3. Run `start.bat` file.
4. If you want to use websocket-based notifications and send e-mails, complete your data in .env file.
5. Log in to the selected account to discover various functionalities.

| Account         | Email	              |   Password  |
|:---------------:|:---------------------:|:-----------:|
| Administrator   | admin@fd.com          |  password   | 
| Viewer 	      | viewer@fd.com         |  password   |

You can also run this app on Docker containers using Laravel Sail.


## First Look
![firstlook1](public/firstlook/firstlook1.png?raw=true)
![firstlook2](public/firstlook/firstlook2.png?raw=true)
![firstlook3](public/firstlook/firstlook3.png?raw=true)
![firstlook5](public/firstlook/firstlook5.png?raw=true)
![firstlook4](public/firstlook/firstlook4.png?raw=true)
