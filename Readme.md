# Screen Shots

![image](https://github.com/user-attachments/assets/56c54b80-1303-46aa-b0f5-4859a8ad6593)
![image](https://github.com/user-attachments/assets/454684f6-cbe0-49c6-824b-22f4db48bb41)
![image](https://github.com/user-attachments/assets/4432cb6a-fbae-446d-a7ee-e5a8adfb9698)
![image](https://github.com/user-attachments/assets/57ea7354-109b-4d59-964a-2055e4205901)
![image](https://github.com/user-attachments/assets/4542d4bc-6b26-4e5b-9ed9-8299e38602cc)



# Project Setup Guide for Web Application

## Creating the Database

Follow these steps to create and import the database using phpMyAdmin:

1. **Navigate to phpMyAdmin**:
   - Access phpMyAdmin, which is one of the containers created in Docker.

2. **Create a New Database**:
   - Click on “New” to create a database.
   - Enter the name for the new database and click “Create”.

3. **Import the Database SQL File**:
   - Select the newly created database.
   - Click on the “Import” tab.
   - Click “Browse” and locate the `attendance_system.sql` file in the `src/database` folder.
   - Select the `attendance_system.sql` file and click “Open” in the system dialog.
   - Click “Go” to start the import process.

## Enabling the `mod_rewrite` Module

Follow these steps to enable the `mod_rewrite` module in the application container:

1. **Access the Application Container**:
   - In Docker, select the container for the application.

2. **Open the Command Line Interface (CLI)**:
   - Click “CLI” to open the command line interface for the container.

3. **Enable `mod_rewrite`**:
   - Type the following command to enable the `mod_rewrite` module:
     ```sh
     a2enmod rewrite
     ```

4. **Restart the Application Server**:
   - After successfully enabling `mod_rewrite`, restart your application server to apply the changes.

