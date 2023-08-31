# **Task-!t**

_Task-!t_ is a full-stack web app made with PHP and MySQL designed for creating kanban boards. This application was created as a semester-long project for my _Server-Side Programming for the Web_ class at IUPUI. This class introduced me to many server-side programming concepts while using PHP such as connecting to a database, CRUD operations, form validation, and user sessions. We also learned how to create and manage databases using MySQL and phpMyAdmin while also studying sound database design,  normalization, and restriction techniques.

_Task-!t_ was designed to be a software project management system using the kanban board method. Users can create projects, where they can plan out current and future releases of their software. Each release starts with three stacks: _Blocked, In Progress,_ and _Done_. Stacks are where task cards are found, with each stack signifying the status of that task.

## Running the Application
Currently the application can only be run on a local web server. I personally use [XAMPP](https://www.apachefriends.org/index.html) because it automatically installs PHP and MySQL. Therefore, I will continue my installation instructions based on using XAMPP:

1. Install XAMPP
2. Using the XAMPP control panel, make sure the web server and MySQL database are running.
3. In the XAMPP application folder, navigate to the "htdocs" directory.
4. Create a folder for the project called “task-it”.
5. Pull the project files from Github into this directory.
6. Open your web browser and navigate to  “http://localhost/phpmyadmin”.
7. Create a database called “task_it’.
8. Import the “init_DB.sql” file into this database.
9. Create a new tab in your web browser and navigate to “http://localhost/Task-It/“.
10. Click the "Sign up" button at the top right corner to create an account and use the application.

