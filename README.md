# micro-framework
Little MVC framework to start working on any front&backend proyect

### Features
- Error reporting and Exception raising on redirects.
- Render views and template overwritting.
- User magnament.
- Database interface.

### Installation
1. Clone the repository
2. Create table in MySQL and excute `core/docs/db/users.sql`.
3. Copy `app/config-sample.php` to `app.config.php` and fill with your database credentials.
4. Read First steps

### First steps

#### Create following folders into `app` folder:
- `controller`: Contains controllers with views logic. **Important:** controllers files must be called `<name>Controller.php`.
- `model`: Contains database models abstractions.
- `view`: Contains templates. You can overwrite `core` views creating again here.
- `lib`: Contains user libs and helpers.
