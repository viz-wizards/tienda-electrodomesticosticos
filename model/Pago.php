<?php

require_once __DIR__ . '/CrudModel.php';

class Pago extends CrudModel
{
    protected string $table = 'pagos';
    protected string $primaryKey = 'id_pago';
    protected array $fillable = ['id_venta', 'monto', 'metodo_pago', 'fecha_pago', 'estado', 'observacion'];

    public function listar(string $orderBy = 'creado_en DESC'): array
    {
        if (!$this->db) {
            return [];
        }

        try {
            return $this->db->query("SELECT pg.*, v.fecha_venta, c.nombres, c.apellidos
                FROM pagos pg
                INNER JOIN ventas v ON v.id_venta = pg.id_venta
                INNER JOIN clientes c ON c.id_cliente = v.id_cliente
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
