<?php require_once __DIR__ . '/Database.php'; ?>

<?php

class AddressesDB extends Database
{
    protected $tableName = 'addresses';

    public function getByOrderId($orderId)
    {
        $sql = "SELECT a.* FROM addresses a
                JOIN orders o ON o.address_id = a.id
                WHERE o.id = :orderId";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['orderId' => $orderId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $columns = implode(', ', array_keys($data));
        $placeholders = ':' . implode(', :', array_keys($data));
        $sql = "INSERT INTO {$this->tableName} ($columns) VALUES ($placeholders)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($data);
        return $this->pdo->lastInsertId();
    }

    public function findByUserId($id)
    {
        $sql = "SELECT a.* FROM addresses a
                JOIN users u ON u.address_id = a.id
                WHERE u.id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function saveOrUpdateUserAddress($id, $data)
    {
        $existing = $this->findByUserId($id);

        if ($existing) {

            $sql = "UPDATE addresses SET 
                        address1 = :address1,
                        address2 = :address2,
                        address3 = :address3,
                        city = :city,
                        state = :state,
                        county = :county,
                        postal_code = :postal_code
                    WHERE id = :address_id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                'address_id' => $existing['id'],
                'address1' => $data['address1'],
                'address2' => $data['address2'],
                'address3' => $data['address3'],
                'city' => $data['city'],
                'state' => $data['state'],
                'county' => $data['county'],
                'postal_code' => $data['postal_code'],
            ]);
        } else {

            $newAddressId = $this->create($data);


            $sql = "UPDATE users SET address_id = :address_id WHERE id = :id";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([
                'address_id' => $newAddressId,
                'id' => $id
            ]);
        }
    }
}
