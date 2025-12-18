Dynamic Form Builder - Core PHP + MySQL
How to Run
1️⃣ Set up Database

Open phpMyAdmin (http://localhost/phpmyadmin)

Create a new database:

CREATE DATABASE dynamic_form_builder;


Import database/schema.sql to create all required tables.

2️⃣ Configure Database

Open config/db.php and update your database credentials:

$host = "localhost";
$user = "root";
$pass = "";
$db   = "dynamic_form_builder";

3️⃣ Place Project in Web Directory

Copy dynamic-form-builder/ to your web server root (htdocs in XAMPP).

C:\xampp\htdocs\dynamic-form-builder

4️⃣ Start Server

Start Apache and MySQL in XAMPP.

5️⃣ Access Project

Admin Dashboard:

http://localhost/dynamic-form-builder/admin/index.php


User Forms:

http://localhost/dynamic-form-builder/user/forms.php

6️⃣ Usage

Admin: Create forms, add fields, view responses.

User: Select a form, fill dynamically, submit.

Name: Aravind
Phone: +91-9025854133
