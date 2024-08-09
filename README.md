# CronJobManager - PHP Cron Job Management Library

CronJobManager is a PHP class designed to simplify the management of cron jobs. This library allows you to programmatically add, remove, and check the existence of cron jobs within a crontab file. It also includes utilities to set a specific crontab as active and handle paths and files that do not yet exist.

## Table of Contents

- [Features](#features)
- [Requirements](#requirements)
- [Installation](#installation)
- [Usage](#usage)
  - [Initializing the CronJobManager](#initializing-the-cronjobmanager)
  - [Setting the Active Crontab](#setting-the-active-crontab)
  - [Adding a Cron Job](#adding-a-cron-job)
  - [Checking if a Cron Job Exists](#checking-if-a-cron-job-exists)
  - [Removing a Cron Job](#removing-a-cron-job)
  - [Emptying the Crontab](#emptying-the-crontab)
  - [Removing the Current Crontab](#removing-the-current-crontab)
- [Permissions Required](#permissions-required)
- [License](#license)
- [Author](#author)

## Features

- **Add Cron Jobs**: Easily add new cron jobs with specified time parameters.
- **Remove Cron Jobs**: Remove cron jobs based on their command.
- **Check Existence**: Check if a cron job already exists in the crontab.
- **Set Active Crontab**: Set a specific crontab file as active, with automatic directory and file creation if needed.
- **Empty Crontab**: Clear all entries from the current crontab.
- **Remove Crontab**: Completely remove the current crontab from the system.

## Requirements

- **PHP**: This library requires PHP 5.6 or later.
- **Operating System**: Linux or any other Unix-like system where cron is available.
- **Permissions**: The user running the PHP script must have appropriate permissions to access and modify crontab files.

## Installation

To install this library, simply clone the repository and include the `CronJobManager.php` file in your project:

```sh
git clone https://github.com/baaziznasser/php-cron-job-manager.git
```

Then include the class in your PHP file:

```php
require_once 'path/to/Cron_job_manager.php';
```

## Usage

### Initializing the CronJobManager

Start by initializing the `CronJobManager` class. You can optionally provide a path to the crontab file you want to manage.

```php
$cronManager = new CronJobManager('/path/to/your/crontab/tmp/crontab.tmp');
```

### Setting the Active Crontab

You can set a specific crontab file as active. If the path or file does not exist, the method will create them.

```php
$cronManager->setCrontabActive('/path/to/your/crontab/tmp/crontab.tmp');
```

### Adding a Cron Job

To add a new cron job that runs every Sunday at 6:05 AM:

```php
$cronManager->addCronJob('5', '6', '*', '*', '0', '/usr/bin/php /path/to/your/script.php');
```

### Checking if a Cron Job Exists

To check if a specific cron job exists:

```php
if ($cronManager->cronExists('/usr/bin/php /path/to/your/script.php')) {
    echo "Cron job exists!";
} else {
    echo "Cron job does not exist!";
}
```

### Removing a Cron Job

To remove a cron job based on its command:

```php
$cronManager->removeCronJob('/usr/bin/php /path/to/your/script.php');
```

### Emptying the Crontab

To remove all cron jobs from the current crontab:

```php
$cronManager->emptyCrontab();
```

### Removing the Current Crontab

To remove the current crontab from the system and set its path to `null`:

```php
$cronManager->removeCurrentCrontab();
```

## Permissions Required

- The user running the script must have permission to read, write, and execute commands related to crontab management.
- The PHP script must have file system permissions to create directories and files if they do not already exist.

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for more details.

## Author

This library was created by [Nacer Baaziz](https://github.com/baaziznasser). If you have any questions or suggestions, feel free to contact me through GitHub or at my [email](mailto:baaziznacer.140@gmail.com).

---

Happy coding! If you find this library useful, consider giving the repository a star 🌟.
