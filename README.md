# php-team-metrics
 A PHP application to keep track of Team Metrics
 
 ## Progress so far

Completed the below components:
* Startup first install page
* Login page
* Registration page
* Forgot password page

### Startup

Will create DB and setup DB tables, will also add the system admin user who will setup additional details once the application is ready to be used.

DB credentials and app folder location should be added to the config.php file, there will be declared the required fields from the forms to check if these were entered during the user interaction.

### Login page

Login page will authenticate users using either a username or email address, will also keep a log of users authenticated and will block failed to attempts to login to the application.

### Registration page

Team Members will add their information but registration will be approved by Team Leads, Operations Manager or System admin. The app is using 2 tables to add authorized users.

### Forgot password page

Users are able to reset the password, they will need to add the email address used to register and will receive a password reset link via email.
