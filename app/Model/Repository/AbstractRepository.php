<?php


namespace App\Model\Repository;

use Nette\Database\Explorer;
use Nette\Database\Table\ActiveRow;

/**
 * Class Repository
 * @package App\Model
 */
abstract class AbstractRepository
{
    protected Explorer $explorer;
    protected string $table;

    /**
     * Repository constructor.
     * @param Explorer $explorer
     * @param string $table
     */
    public function __construct(Explorer $explorer, string $table)
    {
        $this->explorer = $explorer;
        $this->table = $table;
    }

    /**
     * @param int $id
     * @return ActiveRow|null
     */
    public function getRowById(int $id): ?ActiveRow {
        return $this->explorer->table($this->table)->where("id = ?")->fetch();
    }

    /**
     * @param int $id
     * @return int
     */
    public function deleteRowById(int $id): int {
        return $this->explorer->table($this->table)->where("id = ?", $id)->delete();
    }

    /**
     * @param int $id
     * @param iterable $inputData
     * @return int
     */
    public function updateRowById(int $id, iterable $inputData): int {
        return $this->explorer->table($this->table)->where("id = ?", $id)->update($inputData);
    }

    /**
     * @return Explorer
     */
    public function getExplorer(): Explorer {
        return $this->explorer;
    }
}