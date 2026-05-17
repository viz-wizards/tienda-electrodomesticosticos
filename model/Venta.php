<?php

require_once __DIR__ . '/CrudModel.php';

class Venta extends CrudModel
{
    protected string $table = 'ventas';
    protected string $primaryKey = 'id_venta';
    protected array $fillable = ['id_cliente', 'id_producto', 'cantidad', 'precio_unitario', 'total', 'fecha_venta', 'estado'];

    public function listar(string $orderBy = 'creado_en DESC'): array
    {
        if (!$this->db) {
            return [];
        }

        try {
            return $this->db->query("SELECT v.*, c.nombres, c.apellidos, p.nombre AS producto
                FROM ventas v
                INNER JOIN clientes c ON c.id_cliente = v.id_cliente
                INNER JOIN productos p ON p.id_producto = v.id_producto
                ORDER BY {$orderBy}")->fetchAll();
        } catch (Throwable $exception) {
            return [];
        }
    }

    protected function inactiveValue(): string
    {
        return 'Anulado';
    }
}
