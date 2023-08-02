<?php

namespace Entities;

use \Helpers\UserData;
use \PDO;

class User
{
    private string $host = '172.20.0.1';
    private string $dbName = 'm20';
    private string $user = 'root';
    private string $pass = 'test';
    private int $port = 3306;
    private object|null $pdo = null;
    private $userData = null;

    public function __construct()
    {
        $this->userData = new UserData();

        try {
            $this->pdo = new PDO("mysql:host=$this->host;dbname=$this->dbName;port=$this->port", $this->user, $this->pass);
        } catch (\PDOException $e) {
            echo 'Database Error: ' . $e->getMessage();
        }
    }

    /**
     * @param array $user
     * @return void
     */
    public function create(array $user): void
    {
        if (!empty($user)) {
            $trimedUser = $this->userData->trimedData($user);
            try {
                $sql = "INSERT INTO `User`(`id`, `email`, `first_name`, `last_name`, `age`, `date_created`) VALUES (null, :email, :first_name, :last_name, :age, :date_created)";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([
                    'email' => $trimedUser['email'],
                    'first_name' => $trimedUser['first_name'],
                    'last_name' => $trimedUser['last_name'],
                    'age' => $trimedUser['age'],
                    'date_created' => (new \DateTime())->format('Y-m-d H:i:s'),
                ]);
            } catch (\PDOException $e) {
                echo 'Error adding to the database: ' . $e->getMessage();
            }
        }
    }

    /**
     * @param array $user
     * @return void
     */
    public function update(array $user): void
    {
        if (!empty($user)) {
            $trimedUser = $this->userData->trimedData($user);
            $updateColumns = [];
            if ($trimedUser['email'] !== '') {
                $updateColumns[] = "email = :email";
            }
            if ($trimedUser['first_name'] !== '') {
                $updateColumns[] = "first_name = :first_name";
            }
            if ($trimedUser['last_name'] !== '') {
                $updateColumns[] = "last_name = :last_name";
            }
            if ($trimedUser['age'] !== '') {
                $updateColumns[] = "age = :age";
            }

            try {
                $sql = "UPDATE `User` SET " . implode(", ", $updateColumns) . " WHERE id=:id";
                $stmt = $this->pdo->prepare($sql);

                $stmt->bindParam(':id', $user['id']);
                if ($trimedUser['email'] !== '') {
                    $stmt->bindParam(':email', $trimedUser['email']);
                }

                if ($trimedUser['first_name'] !== '') {
                    $stmt->bindParam(':first_name', $trimedUser['first_name']);
                }

                if ($trimedUser['last_name'] !== '') {
                    $stmt->bindParam(':last_name', $trimedUser['last_name']);
                }

                if ($trimedUser['age'] !== '') {
                    $stmt->bindParam(':age', $trimedUser['age']);
                }

                $stmt->execute();
            } catch (\PDOException $e) {
                echo 'Error updating to the database: ' . $e->getMessage();
            }
        }
    }

    /**
     * @param string $id
     * @return void
     */
    public function delete(string $id): void
    {
        if (!empty($id)) {
            try {
                $sql = "DELETE FROM `User` WHERE id=:id";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute(['id' => $id]);
            } catch (\PDOException $e) {
                echo 'Error deleting to the database: ' . $e->getMessage();
            }
        };
    }

    /**
     * @return array
     */
    public function list(): array
    {
        try {
            $sql = "SELECT * FROM `User`";
            $stmt = $this->pdo->query($sql);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            echo 'Error getting data from the database: ' . $e->getMessage();
            return [];
        }
    }
}
