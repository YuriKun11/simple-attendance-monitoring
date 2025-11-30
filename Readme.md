# Screenshots
N/A

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
   - Click “Browse” and locate the `touride.sql` file in the `src/database` folder.
   - Select the `touride.sql` file and click “Open” in the system dialog.
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

