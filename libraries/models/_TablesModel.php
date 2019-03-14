<?php 

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
     * SQL - Finds one or more entries
     *
     * @param [type] $whereValue
     * @param string $whereColumn
     * @param integer $limit
     * @return void
     */
    public function GET($whereValue, string $whereColumn = "id", int $limit = 0)
    {
        //
    }

    /**
     * SQL - Creates or update an entry
     *
     * @param array $values
     * @param string $whereValue
     * @param string $where
     * @return void
     */
    public function PUT(array $values, string $whereValue = null, string $where = null)
    {
        if ($whereValue && $where) {
            $this->update($where, $whereValue, $values);
        } else {
            $this->create($values);
        }
    }

    /**
     * SQL - Deletes an entry
     *
     * @param string $id
     * @param string $column Default = "id"
     * @return void
     */
    public function DELETE(string $value, string $column = "id")
    {
        $query = $this->getPDO()->prepare("DELETE FROM $this->table WHERE $column = :placeholder");
        $query->execute([':placeholder' => $value]);
    }

    // 
    //
    //

    private function getPDO() : PDO
    {
        return new PDO("mysql:host=localhost;dbname=restaurant;charset=utf8", "root", "");
    }

    public function findAll(int $limit = 0, string $order = "")
    {
        $sql = "SELECT * FROM $this->table";
        if ($limit > 0) $sql .= " LIMIT $limit";

        if ($order != "") {
            $sql .= $order;
        }

        $query = $this->getPDO()->prepare($sql);
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

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
        $query = $this->getPDO()->prepare($sql);
        $query->execute($exec);
        if ($multipleReturns) return $query->fetchAll(PDO::FETCH_ASSOC);
        return $query->fetch(PDO::FETCH_ASSOC);
    }

    public function findLike($whereValue, array $columns)
    {
        $sql = "SELECT * FROM $this->table WHERE";
        $exec = [];
        foreach ($columns as $index => $column) {
            $sql .= " $column LIKE :$index OR";
            $exec[":$index"] = "%" . $whereValue . "%";
        }
        $sql = substr($sql, 0, -3);

        $query = $this->getPDO()->prepare($sql);
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
        $db = $this->getPDO();
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

        $query = $this->getPDO()->prepare("UPDATE $this->table SET $set WHERE $where = :whereVal");
        $query->execute($values);
    }
}

?>