<?php

namespace Fast\LogViewer\Utilities;

use Fast\LogViewer\Contracts\Utilities\Factory as FactoryContract;
use Fast\LogViewer\Contracts\Utilities\Filesystem as FilesystemContract;
use Fast\LogViewer\Contracts\Utilities\LogLevels as LogLevelsContract;
use Fast\LogViewer\Entities\LogCollection;
use Fast\LogViewer\Tables\StatsTable;

class Factory implements FactoryContract
{
    /**
     * The filesystem instance.
     *
     * @var \Fast\LogViewer\Contracts\Utilities\Filesystem
     */
    protected $filesystem;

    /**
     * @var \Fast\LogViewer\Contracts\Utilities\LogLevels
     */
    protected $levels;

    /**
     * Create a new instance.
     *
     * @param  \Fast\LogViewer\Contracts\Utilities\Filesystem $filesystem
     * @param  \Fast\LogViewer\Contracts\Utilities\LogLevels $levels
     * @author ARCANEDEV
     */
    public function __construct(
        FilesystemContract $filesystem,
        LogLevelsContract $levels
    )
    {
        $this->setFilesystem($filesystem);
        $this->setLevels($levels);
    }

    /**
     * Get the filesystem instance.
     *
     * @return \Fast\LogViewer\Contracts\Utilities\Filesystem
     * @author ARCANEDEV
     */
    public function getFilesystem()
    {
        return $this->filesystem;
    }

    /**
     * Set the filesystem instance.
     *
     * @param  \Fast\LogViewer\Contracts\Utilities\Filesystem $filesystem
     *
     * @return \Fast\LogViewer\Utilities\Factory
     * @author ARCANEDEV
     */
    public function setFilesystem(FilesystemContract $filesystem)
    {
        $this->filesystem = $filesystem;

        return $this;
    }

    /**
     * Get the log levels instance.
     *
     * @return \Fast\LogViewer\Contracts\Utilities\LogLevels
     * @author ARCANEDEV
     */
    public function getLevels()
    {
        return $this->levels;
    }

    /**
     * Set the log levels instance.
     *
     * @param  \Fast\LogViewer\Contracts\Utilities\LogLevels $levels
     *
     * @return \Fast\LogViewer\Utilities\Factory
     * @author ARCANEDEV
     */
    public function setLevels(LogLevelsContract $levels)
    {
        $this->levels = $levels;

        return $this;
    }

    /**
     * Set the log storage path.
     *
     * @param  string $storagePath
     *
     * @return \Fast\LogViewer\Utilities\Factory
     * @author ARCANEDEV
     */
    public function setPath($storagePath)
    {
        $this->filesystem->setPath($storagePath);

        return $this;
    }

    /**
     * Get the log pattern.
     *
     * @return string
     * @author ARCANEDEV
     */
    public function getPattern()
    {
        return $this->filesystem->getPattern();
    }

    /**
     * Set the log pattern.
     *
     * @param  string $date
     * @param  string $prefix
     * @param  string $extension
     *
     * @return \Fast\LogViewer\Utilities\Factory
     * @author ARCANEDEV
     */
    public function setPattern(
        $prefix = FilesystemContract::PATTERN_PREFIX,
        $date = FilesystemContract::PATTERN_DATE,
        $extension = FilesystemContract::PATTERN_EXTENSION
    )
    {
        $this->filesystem->setPattern($prefix, $date, $extension);

        return $this;
    }

    /**
     * Get all logs.
     *
     * @return \Fast\LogViewer\Entities\LogCollection
     * @author ARCANEDEV
     */
    public function logs()
    {
        return LogCollection::make()->setFilesystem($this->filesystem);
    }

    /**
     * Get all logs (alias).
     *
     * @return \Fast\LogViewer\Entities\LogCollection
     * @author ARCANEDEV
     */
    public function all()
    {
        return $this->logs();
    }

    /**
     * Paginate all logs.
     *
     * @param  int $perPage
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator
     * @author ARCANEDEV
     */
    public function paginate($perPage = 30)
    {
        return $this->logs()->paginate($perPage);
    }

    /**
     * Get a log by date.
     *
     * @param  string $date
     *
     * @return \Fast\LogViewer\Entities\Log
     * @author ARCANEDEV
     */
    public function log($date)
    {
        return $this->logs()->log($date);
    }

    /**
     * Get a log by date (alias).
     *
     * @param  string $date
     *
     * @return \Fast\LogViewer\Entities\Log
     * @author ARCANEDEV
     */
    public function get($date)
    {
        return $this->log($date);
    }

    /**
     * Get log entries.
     *
     * @param  string $date
     * @param  string $level
     *
     * @return \Fast\LogViewer\Entities\LogEntryCollection
     * @author ARCANEDEV
     */
    public function entries($date, $level = 'all')
    {
        return $this->logs()->entries($date, $level);
    }

    /**
     * Get logs statistics.
     *
     * @return array
     * @author ARCANEDEV
     */
    public function stats()
    {
        return $this->logs()->stats();
    }

    /**
     * Get logs statistics table.
     *
     * @param  string|null $locale
     *
     * @return \Fast\LogViewer\Tables\StatsTable
     * @author ARCANEDEV
     */
    public function statsTable($locale = null)
    {
        return StatsTable::make($this->stats(), $this->levels, $locale);
    }

    /**
     * List the log files (dates).
     *
     * @return array
     * @author ARCANEDEV
     */
    public function dates()
    {
        return $this->logs()->dates();
    }

    /**
     * Get logs count.
     *
     * @return int
     * @author ARCANEDEV
     */
    public function count()
    {
        return $this->logs()->count();
    }

    /**
     * Get total log entries.
     *
     * @param  string $level
     *
     * @return int
     * @author ARCANEDEV
     */
    public function total($level = 'all')
    {
        return $this->logs()->total($level);
    }

    /**
     * Get tree menu.
     *
     * @param  bool $trans
     *
     * @return array
     * @author ARCANEDEV
     */
    public function tree($trans = false)
    {
        return $this->logs()->tree($trans);
    }

    /**
     * Get tree menu.
     *
     * @param  bool $trans
     *
     * @return array
     * @author ARCANEDEV
     */
    public function menu($trans = true)
    {
        return $this->logs()->menu($trans);
    }

    /**
     * Determine if the log folder is empty or not.
     *
     * @return bool
     * @author ARCANEDEV
     */
    public function isEmpty()
    {
        return $this->logs()->isEmpty();
    }
}
