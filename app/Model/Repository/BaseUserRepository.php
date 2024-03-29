<?php

namespace App\Model\Repository;

use App\Security\User\SessionIdentity;
use Nette\Database\SqlLiteral;
use Nette\Database\Table\ActiveRow;

/**
 * Class UserRepository
 * @package App\Model
 */
abstract class BaseUserRepository extends AbstractRepository
{
    /**
     * @param string $identificationName username, email or phone number
     * @param array $columns
     * @param bool $useID
     * @return ActiveRow|null
     */
    public function findUserByIdentificationName(string $identificationName, array $columns = ["*"], bool $useID = false): ?ActiveRow
    {
        $select = $this->explorer->table($this->table)->select($columns);
        $where = $useID ? $select->where("id = ?", $identificationName) : $select->where("username = ? OR email = ? OR phoneNumber = ?", $identificationName,
            $identificationName,
            $identificationName);
        return $where->fetch();
    }

    /**
     * @param string $identificationName
     * @return SessionIdentity
     */
    public function getUserIdentity(string $identificationName): ?SessionIdentity {
        $row = $this->findUserByIdentificationName($identificationName, ["username", "email", "phoneNumber", "password", "id"]);
        return $row ? new SessionIdentity($row->username, $row->email, $row->password, $row->phoneNumber, $row->mode, $row->id) : null;
    }

    /**
     * @param string $id
     * @return int
     */
    public function updateUserLastLogin(string $id): int {
        return $this->updateRowById($id, [
            "lastLogin" => new SqlLiteral("NOW()")
        ]);
    }
}