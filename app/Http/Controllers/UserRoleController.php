<?php

namespace App\Http\Controllers;

use PDO;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\UserController;

class UserRoleController extends UserController
{
    private $pdo;

    public function __construct()
    {
        $host = env('DB_HOST');
        $db = env('DB_DATABASE');
        $user = env('DB_USERNAME');
        $pass = env('DB_PASSWORD');
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];

        try {
            $this->pdo = new PDO($dsn, $user, $pass, $options);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }
    
    public function update(Request $request, $id) {
        if ($request->has('role')) {
            Log::info('Updating role for user ID' . $id . ' to' . $request->role);
        }
        parent::update($request, $id);

        Log::info('user role updated for user ID' . $id);
    }

    public function setRole(Request $request, $id) {
        $request->validate([
            'role' => 'required|string|max:255',
        ]);

        try {
            $stmt = $this->pdo->prepare('UPDATE users SET role = ? WHERE id = ?');
            $stmt->execute([$request->role, $id]);
            return response()->json(['message' => 'User role updated successfully']);
        } catch (\PDOException $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
