<?php
namespace phpbu\App;

/**
 * Configuration
 *
 * @package    phpbu
 * @subpackage App
 * @author     Sebastian Feldmann <sebastian@phpbu.de>
 * @copyright  Sebastian Feldmann <sebastian@phpbu.de>
 * @license    https://opensource.org/licenses/MIT The MIT License (MIT)
 * @link       http://phpbu.de/
 * @since      Class available since Release 1.0.0
 */
class Configuration
{
    /**
     * Filename
     *
     * @var string
     */
    private $filename = '';

    /**
     * Path to bootstrap file.
     *
     * @var string
     */
    private $bootstrap = '';

    /**
     * Verbose output
     *
     * @var bool
     */
    private $verbose = false;

    /**
     * Use colors in output.
     *
     * @var bool
     */
    private $colors = false;

    /**
     * Output debug information
     *
     * @var boolean
     */
    private $debug = false;

    /**
     * Don't execute anything just pretend to
     *
     * @var bool
     */
    private $simulate = false;

    /**
     * Show how to restore the backup
     *
     * @var bool
     */
    private $restore = false;

    /**
     * List of logger configurations
     *
     * @var array
     */
    private $loggers = [];

    /**
     * List of backup configurations
     *
     * @var array
     */
    private $backups = [];

    /**
     * List of backus to execute
     *
     * @var array
     */
    private $limit = [];

    /**
     * Working directory
     *
     * @var string
     */
    private static $workingDirectory;

    /**
     * Filename setter.
     *
     * @param string $file
     */
    public function setFilename(string $file)
    {
        $this->filename = $file;
        self::setWorkingDirectory(dirname($file));
    }

    /**
     * Filename getter.
     *
     * @return string
     */
    public function getFilename() : string
    {
        return $this->filename;
    }

    /**
     * Bootstrap setter.
     *
     * @param $file
     */
    public function setBootstrap(string $file)
    {
        $this->bootstrap = $file;
    }

    /**
     * Bootstrap getter.
     *
     * @return string
     */
    public function getBootstrap() : string
    {
        return $this->bootstrap;
    }

    /**
     * Limit setter.
     *
     * @param array $limit
     */
    public function setLimit(array $limit)
    {
        $this->limit = $limit;
    }

    /**
     * Verbose setter.
     *
     * @param bool $bool
     */
    public function setVerbose(bool $bool)
    {
        $this->verbose = $bool;
    }

    /**
     * Verbose getter.
     *
     * @return bool
     */
    public function getVerbose() : bool
    {
        return $this->verbose;
    }

    /**
     * Colors setter.
     *
     * @param bool $bool
     */
    public function setColors(bool $bool)
    {
        $this->colors = $bool;
    }

    /**
     * Colors getter.
     *
     * @return bool
     */
    public function getColors() : bool
    {
        return $this->colors;
    }

    /**
     * Debug setter.
     *
     * @param bool $bool
     */
    public function setDebug(bool $bool)
    {
        $this->debug = $bool;
    }

    /**
     * Debug getter.
     *
     * @return bool
     */
    public function getDebug() : bool
    {
        return $this->debug;
    }

    /**
     * Simulate setter.
     *
     * @param bool $bool
     */
    public function setSimulate(bool $bool)
    {
        $this->simulate = $bool;
    }

    /**
     * Simulate getter.
     *
     * @return bool
     */
    public function isSimulation() : bool
    {
        return $this->simulate;
    }

    /**
     * Restore setter.
     *
     * @param bool $bool
     */
    public function setRestore(bool $bool)
    {
        $this->restore = $bool;
    }

    /**
     * Restore getter.
     *
     * @return bool
     */
    public function isRestore() : bool
    {
        return $this->restore;
    }

    /**
     * Add a logger.
     * This accepts valid logger configs as well as valid Listener objects.
     *
     * @param  mixed $logger
     * @throws \phpbu\App\Exception
     */
    public function addLogger($logger)
    {
        if (!($logger instanceof Listener) && !($logger instanceof Configuration\Logger)) {
            throw new Exception('invalid logger, only \'Listener\' and valid logger configurations are accepted');
        }
        $this->loggers[] = $logger;
    }

    /**
     * Get the list of logger configurations.
     *
     * @return array
     */
    public function getLoggers() : array
    {
        return $this->loggers;
    }

    /**
     * Add a Backup configuration.
     *
     * @param \phpbu\App\Configuration\Backup $backup
     */
    public function addBackup(Configuration\Backup $backup)
    {
        $this->backups[] = $backup;
    }

    /**
     * Get the list of backup configurations.
     *
     * @return \phpbu\App\Configuration\Backup[]
     */
    public function getBackups() : array
    {
        return $this->backups;
    }

    /**
     * Is given backup active.
     * Backups could be skipped by using the --limit option.
     *
     * @param  string $backupName
     * @return bool
     */
    public function isBackupActive($backupName) : bool
    {
        if (empty($this->limit) || in_array($backupName, $this->limit)) {
            return true;
        }
        return false;
    }

    /**
     * Working directory setter.
     *
     * @param string $wd
     */
    public static function setWorkingDirectory(string $wd)
    {
        self::$workingDirectory = $wd;
    }

    /**
     * Working directory getter.
     *
     * @return string
     */
    public static function getWorkingDirectory() : string
    {
        return !empty(self::$workingDirectory) ? self::$workingDirectory : getcwd();
    }
}
