# E-Learning Platform

This repository contains the source code for an **E-Learning Platform** that provides a user-friendly interface for accessing and enrolling in online courses. The platform is designed to enhance online education by delivering course details, enrollment options, and user account management features such as login and signup.

## Features

### 1. User-Friendly Dashboard
- Displays a grid layout of available courses with essential details such as course title, duration, and image.
- Hover effects on course cards for enhanced interactivity.

### 2. Course Details Page
- Displays detailed information about a selected course.
- Includes a back button, course description, and enrollment status.
- "Let’s Start" button for accessing the course content after enrollment.

### 3. User Authentication
- Login and Signup functionality to manage user accounts.
- Secure handling of user credentials.

### 4. Course player Page
- Learn any courses Available in the catalog.

### 5. Dynamic Course Content
- Dynamically fetches and displays course details from the database using PHP and MySQL.
- Ensures that content is up-to-date and easy to manage.


### 5. Profile Page
- Display Profile image , User Loged in information.
- Edit user account information and Logout from this account.

## Technologies Used

- **Frontend:** HTML5, CSS3, JavaScript
- **Backend:** PHP (with PDO for database interactions)
- **Database:** MySQL
- **Server:** Apache (XAMPP/WAMP/LAMP stack recommended)

---

## Project Files

1. **index.php:** Displays the main dashboard with the course list.
2. **course_detail.php:** Shows detailed information about a selected course.
3. **enroll.php:** Handles course enrollment logic and updates the database.

---

## Setup Instructions

1. Clone the repository:
   ```bash
   git clone https://github.com/your-username/e-learning-platform.git
   ```

2. Import the database:
   - Locate the `database.sql` file in the project folder.
   - Use phpMyAdmin or any MySQL client to import the file into your MySQL server.

3. Configure the database connection:
   - Edit the `db_connection.php` file to include your database credentials:
     ```php
     $host = 'localhost';
     $dbname = 'e_learning';
     $username = 'root';
     $password = '';
     ```

4. Start the server:
   - Use XAMPP or WAMP to start the Apache and MySQL servers.
   - Place the project folder in the `htdocs` directory.
   - Access the application at `http://localhost/e-learning-platform`.

5. Access Login/Signup:
   - Navigate to the Login or Signup page to create an account.
   - Start exploring courses and enroll in your preferred ones.

---

## Repository Description

This repository contains the complete source code for an e-learning platform. The platform includes a dynamic dashboard for displaying available courses, detailed course pages, and user authentication features (login and signup). Built with PHP, MySQL, and responsive design principles, this platform provides an intuitive way to manage and deliver online educational content.

---

## Screenshots
1. Login/Sign up Page
   ![Screenshot (199)](https://github.com/user-attachments/assets/c2aee88a-c557-41f4-a8f6-88b0debd16b8)
2. Course Catalog page
   ![Screenshot (201)](https://github.com/user-attachments/assets/347d4aca-edd7-469b-a0cc-c9cbb6ed3419)
3. Course details Page
   ![Screenshot (202)](https://github.com/user-attachments/assets/72d1af1b-7127-46eb-a450-04fd94afca4c)
4. Course Player Page
   ![Screenshot (203)](https://github.com/user-attachments/assets/8ef21572-c41a-450a-8092-000b78aadd15)
5. Enrolled Courses Page
   ![Screenshot (204)](https://github.com/user-attachments/assets/1dd32897-2f36-4b46-b60b-371958fa5b83)
6. Profile Page
   ![Screenshot (205)](https://github.com/user-attachments/assets/8f38a5a5-e826-477e-8913-2ade23ae9e4e)
---

## Contributing

We welcome contributions! Please follow these steps to contribute:

1. Fork the repository.
2. Create a new branch for your feature/bug fix.
   ```bash
   git checkout -b feature-name
   ```
3. Commit your changes.
   ```bash
   git commit -m "Add your message here"
   ```
4. Push to the branch.
   ```bash
   git push origin feature-name
   ```
5. Create a pull request.

---

## License

This project is licensed under the MIT License. Feel free to use, modify, and distribute it as per the license terms.

---

## Contact

For any queries, feel free to reach out:
- Email: [your-email@example.com](mailto:your-email@example.com)
- GitHub: [https://github.com/your-username](https://github.com/your-username)

