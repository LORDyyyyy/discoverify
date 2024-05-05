<?php

declare(strict_types=1);

namespace App\Config;

/**
 * Class Paths
 * 
 * This class contains constants that define the file paths used in the application.
 */
class Paths
{
    /**
     * The root directory path.
     * 
     * @var string
     */
    public const ROOT = __DIR__ . "/../../../";

    /**
     * The source directory path.
     * 
     * @var string
     */
    public const SOURCE = __DIR__ . "/../../";

    /**
     * The view directory path.
     * 
     * @var string
     */
    public const VIEW = __DIR__ . "/../views";

    /**
     * The storage directory path.
     * 
     * @var string
     */
    public const STORAGE = __DIR__ . "/../../../public/storage";

    /**
     * The storage uploads directory path.
     * 
     * @var string
     */
    public const STORAGE_UPLOADS = __DIR__ . "/../../../public/storage/uploads";

    /**
     * The storage defaults directory path.
     * 
     * @var string
     */
    public const STORAGE_DEFAULTS = __DIR__ . "/../../../public/storage/defaults";

    /**
     * The SQL scripts directory path.
     * 
     * @var string
     */
    public const SQL_SCRIPTS = __DIR__ . "/../../../sql";
}
