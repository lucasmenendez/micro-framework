# micro-framework
Little MVC framework to start working on any front&backend proyect

### Features
- Error reporting
- Render views
- User magnament
- Database interface
- SQL file to init database tables

### Installation
1. Clone the repository
2. Open `app` folder and create `config.php` file.
3. Paste this content and change it according to the database data.
``` 
    define('DB_HOST', '<host>');
    define('DB_USER', '<user>');
    define('DB_PASS', '<pass>');
    define('DB_NAME', '<dbname>');

    define('SALT_PASSWORD', '<salt>');

    date_default_timezone_set('<timezone>');
```
