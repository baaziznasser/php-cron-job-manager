<?php
/**
 * CronJobManager - A PHP class for managing cron jobs in a crontab file.
 *
 * This library was created by Nacer Baaziz.
 *
 * This software is provided 'as-is', without any express or implied
 * warranty. In no event will the author be held liable for any damages
 * arising from the use of this software.
 *
 * Permission is granted to anyone to use this software for any purpose,
 * including commercial applications, and to alter it and redistribute it
 * freely, subject to the following restrictions:
 *
 * 1. The origin of this software must not be misrepresented; you must not
 *    claim that you wrote the original software. If you use this software
 *    in a product, an acknowledgment in the product documentation would
 *    be appreciated but is not required.
 * 2. Altered source versions must be plainly marked as such, and must not
 *    be misrepresented as being the original software.
 * 3. This notice may not be removed or altered from any source distribution.
 *
 * @author     Nacer Baaziz
 * @link       https://github.com/baaziznasser/php-cron-job-manager/
 * @license    MIT License
 * @version    1.0.0
 * @since      2024
 */


class CronJobManager
{
    private $crontabFile;

    public function __construct($filePath = null)
    {
        $this->crontabFile = $filePath;
$this->setCrontabActive($this->crontabFile);
    }

    // Set the crontab file to be active
    public function setCrontabActive($filePath)
    {
        $this->crontabFile = $filePath;

        if ($this->crontabFile === null) {
            throw new Exception("No crontab file set. Use setCrontabActive() to specify a file.");
        }

        // Check if the directory exists, if not create it
        $directory = dirname($this->crontabFile);
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true); // Create the directory with appropriate permissions
        }

        // Check if the file exists, if not create it
        if (!file_exists($this->crontabFile)) {
            touch($this->crontabFile); // Create an empty file
        }

        // Set the crontab file as active
        exec('crontab ' . escapeshellarg($this->crontabFile), $output, $returnVar);
        return $returnVar === 0;
    }

    public function isCronExists($command)
    {
        if ($this->crontabFile === null) {
            throw new Exception("No crontab file set. Use setCrontabActive() to specify a file.");
        }

        $crontabContents = file_get_contents($this->crontabFile);
        return strpos($crontabContents, $command) !== false;
    }

    // Add a new cron job with detailed time parameters
    public function addCronJob($minute = '*', $hour = '*', $dayOfMonth = '*', $month = '*', $dayOfWeek = '*', $command)
    {
        if ($this->crontabFile === null) {
            throw new Exception("No crontab file set. Use setCrontabActive() to specify a file.");
        }

        if ($this->isCcronExists($command)) {
            return false; // Job already exists, so no need to add it again
        }
        $cronJob = "$minute $hour $dayOfMonth $month $dayOfWeek $command" . PHP_EOL;
        file_put_contents($this->crontabFile, $cronJob, FILE_APPEND | LOCK_EX);
    shell_exec("crontab $this->crontabFile");
        return true;
    }

    // Remove a cron job by its command
    public function removeCronJob($command)
    {
        if ($this->crontabFile === null) {
            throw new Exception("No crontab file set. Use setCrontabActive() to specify a file.");
        }

        $crontabContents = file_get_contents($this->crontabFile);
        $updatedContents = preg_replace('/^.*' . preg_quote($command, '/') . '.*$/m', '', $crontabContents);
        file_put_contents($this->crontabFile, $updatedContents, LOCK_EX);
    shell_exec("crontab $this->crontabFile");
        return true;
    }

    // Empty the crontab file
    public function emptyCrontab()
    {
        if ($this->crontabFile === null) {
            throw new Exception("No crontab file set. Use setCrontabActive() to specify a file.");
        }

        file_put_contents($this->crontabFile, '', LOCK_EX);
    shell_exec("crontab $this->crontabFile");
        return true;
    }

    // Remove the current crontab and set its path to null
    public function removeCurrentCrontab()
    {
        if ($this->crontabFile === null) {
            throw new Exception("No crontab file set. Use setCrontabActive() to specify a file.");
        }

        exec('crontab -r', $output, $returnVar);
        if ($returnVar === 0) {
            $this->crontabFile = null;
        }
        return $returnVar === 0;
    }

    // Display the current crontab entries
    public function showCrontab()
    {
        exec('crontab -l', $output);
        return implode(PHP_EOL, $output);
    }
}
?>