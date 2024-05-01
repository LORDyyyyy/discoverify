<?php

declare(strict_types=1);

use App\Config\Paths;
use App\Services\{
    ValidatorService,
};
use App\Models\{
    UserModel,
    FriendModel
};
use Framework\{
    TemplateEngine,
    Database,
    Container
};

use App\Models\Storage\DBStorage;


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
    ),
    UserModel::class => fn (Container $container) => new UserModel($container->get(Database::class)),
    FriendModel::class => fn (Container $container) => new FriendModel($container->get(Database::class)),
];
