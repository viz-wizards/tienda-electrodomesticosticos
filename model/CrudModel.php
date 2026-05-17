<?php

require_once __DIR__ . '/../config/Database.php';

abstract class CrudModel
{
    protected ?PDO $db;
    protected string $table;
    protected string $primaryKey;
    protected array $fillable = [];
    protected ?string $statusColumn = 'estado';

    public function __construct()
    {
        $this->db = (new Database())->connect();
    }

    public function listar(string $orderBy = ''): array
    {
        if (!$this->db) {
            return [];
        }

        $sql = "SELECT * FROM {$this->table}";
        if ($orderBy !== '') {
            $sql .= " ORDER BY {$orderBy}";
        }

        try {
            return $this->db->query($sql)->fetchAll();
        } catch (Throwable $exception) {
            return [];
        }
    }

    public function obtener(int $id): ?array
    {
        if (!$this->db || $id <= 0) {
            return null;
        }

        try {
            $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE {$this->primaryKey} = :id LIMIT 1");
            $stmt->execute(['id' => $id]);
            $row = $stmt->fetch();
        } catch (Throwable $exception) {
            return null;
        }

        return $row ?: null;
    }

    public function guardar(array $data): bool
    {
        if (!$this->db) {
            return false;
        }

        $id = (int) ($data[$this->primaryKey] ?? 0);
        $values = $this->cleanData($data);

        if (empty($values)) {
            return false;
        }

        try {
            if ($id > 0) {
                $sets = array_map(fn($field) => "{$field} = :{$field}", array_keys($values));
                $values['id'] = $id;
                $stmt = $this->db->prepare("UPDATE {$this->table} SET " . implode(', ', $sets) . " WHERE {$this->primaryKey} = :id");
                return $stmt->execute($values);
            }

            $fields = array_keys($values);
            $placeholders = array_map(fn($field) => ":{$field}", $fields);
            $stmt = $this->db->prepare(
                "INSERT INTO {$this->table} (" . implode(', ', $fields) . ") VALUES (" . implode(', ', $placeholders) . ")"
            );

            return $stmt->execute($values);
        } catch (Throwable $exception) {
            return false;
        }
    }

    public function eliminar(int $id): bool
    {
        if (!$this->db || $id <= 0) {
            return false;
        }

        if ($this->statusColumn) {
            try {
                $stmt = $this->db->prepare("UPDATE {$this->table} SET {$this->statusColumn} = :estado WHERE {$this->primaryKey} = :id");
                return $stmt->execute(['estado' => $this->inactiveValue(), 'id' => $id]);
            } catch (Throwable $exception) {
                return false;
            }
        }

        try {
            $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE {$this->primaryKey} = :id");
            return $stmt->execute(['id' => $id]);
        } catch (Throwable $exception) {
            return false;
        }
    }

    protected function cleanData(array $data): array
    {
        $values = [];

        foreach ($this->fillable as $field) {
            if (!array_key_exists($field, $data)) {
                continue;
            }

            $value = is_string($data[$field]) ? trim($data[$field]) : $data[$field];
            $values[$field] = $value === '' ? null : $value;
        }

        return $values;
    }

    protected function inactiveValue(): string
    {
        return 'Inactivo';
    }
}
