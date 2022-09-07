<h1 align="center">Absolute School</h1>
<h3 align="center">Online School Web Project</h3>
<br/>
<p align="justify">
Absolute School is a small online school web project that has mutiple account types like admin, moderator, teacher and student. The project can be used to run an online school where students and teachers can share resources through the subjects they are associated with. The admins and moderators will also be able to manage the accounts and look at several statistics.
</p>
<br/>
<h3>How to Install?</h3>
<br/>
<p align="justify">
Please make sure you have git installed in your personal computer!
</p>
<br/>
<ul>
    <li>Clone the repository to your device - <code>git clone https://github.com/NayAungLin910/absolute-school.git absolute-school</code></li>
    <li>Install project dependencies - <code>composer install</code></li>
    <li>Install npm dependencies - <code>npm install</code> or if you prefer using yarn <code>yarn</code></li>
    <li>Copy .env file - <code>cp .env.example .env</code></li>
    <li>Generate an app encryption key - <code>php artisan key:generate</code></li>
    <li>Create a database using a software like phpMyAdmin, and in .env file of your project at "DB_DATABASE=" write the database name that you created.</li>
    <li>Migrate the database - <code>php artisan migrate</code></li>
    <li>Seed the initial data - <code>php artisan db:seed</code></li>
</ul>
<br/>
<p align="justify">
Now you will be able to run the project by running commands like <code>php artisan serve</code> and <code>yarn watch</code> from the terminal. Of course, the databse you created also need to be running. 
</p>
<br/>
<h3>Using the App</h3>
<p align="justify">
After running the project by running commands mentoined above please go to the route "http://127.0.0.1:8000/login/student" in order to login. There you will be able to choose to login or register your account as a student, teacher, or moderator. But something you will notice that there is no option to login as an admin described in the navbar. You can try to login as an admin by simply replacing the "student" text with "admin" in the adress bar which will change the address into "http://127.0.0.1:8000/login/admin". Some of the accounts built as default during database seeding are -
</p>
<br/>
<ul>
    <li>(admin) mail - admin@gmail.com, pw - admin123</li>
    <li>(moderator) mail - mod1@gmail.com, pw - mod1</li>
    <li>(student) mail - stu1@gmail.com, pw - stu1</li>
    <li>(teacher) mail - teach1@gmail.com, pw - teach1</li>
</ul>
<br/>
<h3>Admin Access</h3>
<br/>
<p align="justify">
An admin will be able to approve the registered account of moderators, teachers and students. Only after getting approved that the accounts will be able to be logged in by the users. An admin will also be able to search and delete accounts, create batches and subjects, assign batch to the users and also check statistics.
</p>
<h3>Moderator Access</h3>
<br/>
<p align="justify">
Moderators will also be able to do most of the features that the the admin can except they will not be permitted to delete other moderator accounts.
</p>
<br/>
<h3>Teacher Access</h3>
<br/>
<p align="justify">
Teachers will be able to search only teacher and student accounts. From the associated subjects, the teachers will also be able to create sections where they can upload files to share with the students. They will also be able to create forms where students can submit their files. They will also be able to update the zoom meeting information of the associated subject too.
</p>
<h3>Student Access</h3>
<br/>
<p align="justify">
Students will be able to download files the teachers uploaded at the sections of the associated subjects. They will also be able to submit multiple files in the forms the teachers created. 
</p>
