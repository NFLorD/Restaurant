<?php 
require_once "_DB.php";

abstract class Tables
{
    // To be defined in child class
    protected $table;

    public function __construct()
    {
        if (empty($this->table)) {
            throw new Exception("Vous avez oublié le nom de la table dans votre modèle");
        }
    }

    /**
     * Find all entries
     *
     * @param int $limit your entries
     * @param string $order - SQL
     * @return array
     */
    public function findAll(int $limit = 0, string $order = "")
    {
        $sql = "SELECT * FROM $this->table";
        if ($limit > 0) $sql .= " LIMIT $limit";

        if ($order != "") {
            $sql .= $order;
        }

        $query = DB::getPDO()->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Find some entries
     *
     * @param [type] $whereValue
     * @param string $whereColumn
     * @param boolean $multipleReturns
     * @param string $order - SQL
     * @return array
     */
    public function find($whereValue, string $whereColumn = "id", bool $multipleReturns = false, string $order = "")
    {
        $sql = "SELECT * FROM $this->table WHERE";
        if (is_array($whereColumn)) {
            $exec = [];
            foreach ($whereColumn as $index => $col) {
                $sql .= " $col = :$index AND";
                $exec[":$index"] = $whereValue[$index];
            }
            $sql = substr($sql, 0, -4);
        } else {
            $sql .= " $whereColumn = :val";
            $exec = [":val" => $whereValue];
        }

        if ($order != "") {
            $sql .= $order;
        }
        $query = DB::getPDO()->prepare($sql);
        $query->execute($exec);
        if ($multipleReturns) return $query->fetchAll(PDO::FETCH_ASSOC);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Find LIKE (SQL)
     *
     * @param [type] $whereValue
     * @param array $columns
     * @return void
     */
    public function findLike($whereValue, array $columns)
    {
        $sql = "SELECT * FROM $this->table WHERE";
        $exec = [];
        foreach ($columns as $index => $column) {
            $sql .= " $column LIKE :$index OR";
            $exec[":$index"] = "%" . $whereValue . "%";
        }
        $sql = substr($sql, 0, -3);

        $query = DB::getPDO()->prepare($sql);
        $query->execute($exec);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Creates an entry
     *
     * @param array column => value
     * @return string contains last insert ID
     */
    public function create(array $values)
    {
        $db = DB::getPDO();
        $cols = array_keys($values);
        $placeholders = "";
        foreach ($cols as $col) {
            $placeholders .= ":" . $col . ", ";
        }
        $placeholders = substr($placeholders, 0, -2);
        $cols = implode(", ", $cols);
        $values = array_combine(explode(", ", $placeholders), array_values($values));

        $query = $db->prepare("INSERT INTO $this->table ($cols) VALUES ($placeholders)");
        $query->execute($values);

        return $db->lastInsertId();
    }

    /**
     * Updates an entry
     *
     * @param string $where
     * @param $whereValue
     * @param array $values column => value
     * @return void
     */
    public function update(string $where, $whereValue, array $values)
    {
        $set = "";
        $keys = [];
        foreach ($values as $col => $val) {
            $set .= $col . " = :" . $col . ", ";
            $keys[] .= ":" . $col;
        }
        $set = substr($set, 0, -2);

        $vals = array_values($values);
        $keys[] .= ":whereVal";
        $vals[] .= $whereValue;
        $values = array_combine($keys, $vals);

        $query = DB::getPDO()->prepare("UPDATE $this->table SET $set WHERE $where = :whereVal");
        $query->execute($values);
    }

    /**
     * SQL - Deletes an entry
     *
     * @param string $id
     * @param string $column Default = "id"
     * @return void
     */
    public function delete(string $value, string $column = "id")
    {
        $query = DB::getPDO()->prepare("DELETE FROM $this->table WHERE $column = :placeholder");
        $query->execute([':placeholder' => $value]);
    }
}

?>