<?php


class Database
{
    private $pdo;

    /**
     * Constructor to initialize the PDO connection.
     * 
     * @param string $type Database type (mysql, pgsql, sqlite).
     * @param array $config Configuration details (host, dbname, username, password).
     */
    public function __construct(string $type, array $config)
    {
        try {
            switch ($type) {
                case 'mysql':
                    $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8mb4";
                    break;
                case 'pgsql':
                    $dsn = "pgsql:host={$config['host']};dbname={$config['dbname']}";
                    break;
                case 'sqlite':
                    $dsn = "sqlite:{$config['path']}";
                    break;
                default:
                    throw new Exception("Unsupported database type: $type");
            }

            $this->pdo = new PDO($dsn, $config['username'] ?? null, $config['password'] ?? null);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    /**
     * Executes a query and returns results.
     * 
     * @param string $query The SQL query.
     * @param array $params Parameters for prepared statements.
     * @return array Query results.
     */
    public function query(string $query, array $params = []): array
    {
        $stmt = $this->pdo->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

// Configuration for different databases
$configurations = [
    'mysql' => [
        'host' => '127.0.0.1',
        'dbname' => 'test_db',
        'username' => 'root',
        'password' => ''
    ],
    'pgsql' => [
        'host' => '127.0.0.1',
        'dbname' => 'test_db',
        'username' => 'postgres',
        'password' => 'secret'
    ],
    'sqlite' => [
        'path' => __DIR__ . '/database.sqlite'
    ]
];

// Example usage:

// 1. Connect to MySQL
$db = new Database('mysql', $configurations['mysql']);
$results = $db->query('SELECT * FROM users WHERE age > ?', [25]);
print_r($results);

// 2. Switch to PostgreSQL (minimal changes)
$db = new Database('pgsql', $configurations['pgsql']);
$results = $db->query('SELECT * FROM users WHERE age > ?', [25]);
print_r($results);

// 3. Switch to SQLite (minimal changes)
$db = new Database('sqlite', $configurations['sqlite']);
$results = $db->query('SELECT * FROM users WHERE age > ?', [25]);
print_r($results);
