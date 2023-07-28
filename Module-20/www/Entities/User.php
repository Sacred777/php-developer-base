<?php

//namespace www\Entities;

//use Entities\PDO;

class User
{
    private $host = '172.25.208.1';
    private $dbName = 'm20';
    private $user = 'root';
    private $pass = 'test';
    private $port = 3306;
    public $pdo = null;

    public function __construct()
    {
        try {
            $this->pdo = new PDO("mysql:host=$this->host;dbname=$this->dbName;port=$this->port", $this->user, $this->pass);
        } catch (\PDOException $e) {
            echo 'Database Error: ' . $e->getMessage();
        }
    }

    public function create($user)
    {
        if (!empty($user)) {
            $trimedUser = trimAssocArray($user);
            $sql = "INSERT INTO `User`(`id`, `email`, `first_name`, `last_name`, `age`, `date_created`) VALUES (null, :email, :first_name, :last_name, :age, :date_created)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                'email' => $trimedUser['email'],
                'first_name' => $trimedUser['first_name'],
                'last_name' => $trimedUser['last_name'],
                'age' => $trimedUser['age'],
                'date_created' => (new \DateTime())->format('Y-m-d H:i:s'),
            ]);
        }
    }

    public function update(array $user)
    {
        if (empty($user)) return null;


        $trimedUser = trimAssocArray($user);
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

        if (!empty($updateColumns)) {
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
        }
    }

    public function delete(string $id)
    {
        if (empty($id)) return null;

        $sql = "DELETE FROM `User` WHERE id=:id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);

    }

    // TODO посмотри что вернёт, если таблица будет пустая
    public function list(): array
    {
        $sql = "SELECT * FROM `User`";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
