<?php

declare(strict_types=1);

use App\Config\Paths;
use App\Services\{
    ValidatorService,
    UserService,
    TransactionService,
    ReceiptService
};
use Framework\{
    TemplateEngine,
    Database,
    Container
};


$db_config = [
    'host' => $_ENV['DB_HOST'] ?? 'localhost',
    'port' => $_ENV['DB_PORT'] ?? 3306,
    'dbname' => $_ENV['DB_DBNAME'] ?? 'phpiggy',
];

return [
    TemplateEngine::class => fn () => new TemplateEngine(Paths::VIEW),
    ValidatorService::class => fn () => new ValidatorService(),
    Database::class => fn () => new Database(
        $_ENV['DB_DRIVER'] ?? 'mysql',
        $db_config,
        $_ENV['DB_USER'] ?? 'root',
        $_ENV['DB_PASS'] ?? ''
    )
];
