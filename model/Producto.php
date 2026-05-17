<?php

require_once __DIR__ . '/../config/Database.php';

class Producto
{
    private ?PDO $db;

    public function __construct()
    {
        $this->db = (new Database())->connect();
    }

    public function destacados(): array
    {
        if (!$this->db) {
            return $this->demoProductos();
        }

        $sql = "SELECT p.*, c.nombre AS categoria
                FROM productos p
                LEFT JOIN categorias c ON c.id_categoria = p.id_categoria
                WHERE p.estado IN ('Disponible', 'Agotado')
                ORDER BY p.estado = 'Disponible' DESC, p.creado_en DESC
                LIMIT 12";

        try {
            return $this->db->query($sql)->fetchAll() ?: $this->demoProductos();
        } catch (Throwable $exception) {
            return $this->demoProductos();
        }
    }

    public function porCategoria(int $idCategoria): array
    {
        if (!$this->db) {
            return array_values(array_filter($this->demoProductos(), fn($item) => (int) $item['id_categoria'] === $idCategoria));
        }

        try {
            $stmt = $this->db->prepare("SELECT p.*, c.nombre AS categoria
                FROM productos p
                LEFT JOIN categorias c ON c.id_categoria = p.id_categoria
                WHERE p.id_categoria = :categoria AND p.estado IN ('Disponible', 'Agotado')
                ORDER BY p.nombre");
            $stmt->execute(['categoria' => $idCategoria]);

            return $stmt->fetchAll();
        } catch (Throwable $exception) {
            return [];
        }
    }

    public function buscar(string $termino): array
    {
        $termino = trim($termino);
        if ($termino === '') {
            return $this->destacados();
        }

        if (!$this->db) {
            return array_values(array_filter($this->demoProductos(), function ($item) use ($termino) {
                return stripos($item['nombre'] . ' ' . $item['descripcion'], $termino) !== false;
            }));
        }

        try {
            $stmt = $this->db->prepare("SELECT p.*, c.nombre AS categoria
                FROM productos p
                LEFT JOIN categorias c ON c.id_categoria = p.id_categoria
                WHERE (p.nombre LIKE :q OR p.descripcion LIKE :q) AND p.estado IN ('Disponible', 'Agotado')
                ORDER BY p.nombre");
            $stmt->execute(['q' => "%{$termino}%"]);

            return $stmt->fetchAll();
        } catch (Throwable $exception) {
            return [];
        }
    }

    public function encontrar(int $id): ?array
    {
        if (!$this->db) {
            foreach ($this->demoProductos() as $producto) {
                if ((int) $producto['id_producto'] === $id) {
                    return $producto;
                }
            }
            return null;
        }

        try {
            $stmt = $this->db->prepare("SELECT p.*, c.nombre AS categoria
                FROM productos p
                LEFT JOIN categorias c ON c.id_categoria = p.id_categoria
                WHERE p.id_producto = :id
                LIMIT 1");
            $stmt->execute(['id' => $id]);
            $producto = $stmt->fetch();
        } catch (Throwable $exception) {
            return null;
        }

        return $producto ?: null;
    }

    public function categorias(): array
    {
        if (!$this->db) {
            return [
                ['id_categoria' => 1, 'nombre' => 'Televisores', 'descripcion' => 'Smart TV, LED, 4K y OLED'],
                ['id_categoria' => 2, 'nombre' => 'Linea Blanca', 'descripcion' => 'Refrigeradoras, lavadoras y cocinas'],
                ['id_categoria' => 3, 'nombre' => 'Cocina Pequena', 'descripcion' => 'Microondas, licuadoras y cafeteras'],
                ['id_categoria' => 4, 'nombre' => 'Climatizacion', 'descripcion' => 'Aires acondicionados y ventiladores'],
                ['id_categoria' => 5, 'nombre' => 'Audio y Video', 'descripcion' => 'Parlantes, barras y proyectores'],
            ];
        }

        try {
            return $this->db->query("SELECT * FROM categorias WHERE estado = 'Activo' ORDER BY nombre")->fetchAll();
        } catch (Throwable $exception) {
            return [];
        }
    }

<<<<<<< HEAD
    public function listar(string $orderBy = 'p.creado_en DESC'): array
    {
        if (!$this->db) {
            return $this->demoProductos();
        }

        try {
            return $this->db->query("SELECT p.*, c.nombre AS categoria, pr.razon_social AS proveedor
                FROM productos p
                LEFT JOIN categorias c ON c.id_categoria = p.id_categoria
                LEFT JOIN proveedores pr ON pr.id_proveedor = p.id_proveedor
                ORDER BY {$orderBy}")->fetchAll();
        } catch (Throwable $exception) {
            return [];
        }
    }

    public function guardar(array $data): bool
    {
        if (!$this->db) {
            return false;
        }

        $id = (int) ($data['id_producto'] ?? 0);
        $values = [
            'id_categoria' => $this->nullableInt($data['id_categoria'] ?? null),
            'id_proveedor' => $this->nullableInt($data['id_proveedor'] ?? null),
            'nombre' => trim($data['nombre'] ?? ''),
            'descripcion' => trim($data['descripcion'] ?? ''),
            'precio' => (float) ($data['precio'] ?? 0),
            'stock' => (int) ($data['stock'] ?? 0),
            'imagen' => trim($data['imagen'] ?? ''),
            'estado' => trim($data['estado'] ?? 'Disponible'),
        ];

        $values['descripcion'] = $values['descripcion'] === '' ? null : $values['descripcion'];
        $values['imagen'] = $values['imagen'] === '' ? null : $values['imagen'];

        try {
            if ($id > 0) {
                $values['id'] = $id;
                $stmt = $this->db->prepare("UPDATE productos SET id_categoria = :id_categoria, id_proveedor = :id_proveedor,
                    nombre = :nombre, descripcion = :descripcion, precio = :precio, stock = :stock, imagen = :imagen,
                    estado = :estado WHERE id_producto = :id");
                return $stmt->execute($values);
            }

            $stmt = $this->db->prepare("INSERT INTO productos
                (id_categoria, id_proveedor, nombre, descripcion, precio, stock, imagen, estado)
                VALUES (:id_categoria, :id_proveedor, :nombre, :descripcion, :precio, :stock, :imagen, :estado)");

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

        try {
            $stmt = $this->db->prepare("UPDATE productos SET estado = 'Inactivo' WHERE id_producto = :id");
            return $stmt->execute(['id' => $id]);
        } catch (Throwable $exception) {
            return false;
        }
    }

    public function proveedores(): array
    {
        if (!$this->db) {
            return [];
        }

        try {
            return $this->db->query("SELECT * FROM proveedores WHERE estado = 'Activo' ORDER BY razon_social")->fetchAll();
        } catch (Throwable $exception) {
            return [];
        }
    }

    private function nullableInt($value): ?int
    {
        $value = (int) $value;
        return $value > 0 ? $value : null;
    }

=======
>>>>>>> 38ddd9f37320cc1c5bbd520b648079b846e81dbf
    private function demoProductos(): array
    {
        return [
            ['id_producto' => 1, 'id_categoria' => 1, 'nombre' => 'Smart TV 55 4K UHD', 'descripcion' => 'Televisor inteligente con HDR10, WiFi, Bluetooth y control por voz.', 'precio' => 1899, 'stock' => 15, 'estado' => 'Disponible', 'imagen' => 'tv-55-4k.jpg', 'categoria' => 'Televisores'],
            ['id_producto' => 2, 'id_categoria' => 2, 'nombre' => 'Refrigeradora Inverter 350L', 'descripcion' => 'Refrigeradora de 2 puertas con bajo consumo energetico.', 'precio' => 2499, 'stock' => 8, 'estado' => 'Disponible', 'imagen' => 'refri-inverter.jpg', 'categoria' => 'Linea Blanca'],
            ['id_producto' => 3, 'id_categoria' => 2, 'nombre' => 'Lavadora Automatica 12kg', 'descripcion' => 'Lavadora frontal con 15 programas y tecnologia eco.', 'precio' => 1599, 'stock' => 12, 'estado' => 'Disponible', 'imagen' => 'lavadora-12kg.jpg', 'categoria' => 'Linea Blanca'],
            ['id_producto' => 4, 'id_categoria' => 3, 'nombre' => 'Microondas Digital 30L', 'descripcion' => 'Microondas con grill, descongelado automatico y panel tactil.', 'precio' => 349, 'stock' => 25, 'estado' => 'Disponible', 'imagen' => 'microondas-30l.jpg', 'categoria' => 'Cocina Pequena'],
            ['id_producto' => 5, 'id_categoria' => 4, 'nombre' => 'Aire Acondicionado Split 12000 BTU', 'descripcion' => 'Aire acondicionado frio/calor con control remoto y modo silencioso.', 'precio' => 1299, 'stock' => 10, 'estado' => 'Disponible', 'imagen' => 'aire-split.jpg', 'categoria' => 'Climatizacion'],
            ['id_producto' => 6, 'id_categoria' => 3, 'nombre' => 'Licuadora Profesional 1500W', 'descripcion' => 'Licuadora de alta potencia con vaso de vidrio templado.', 'precio' => 189, 'stock' => 0, 'estado' => 'Agotado', 'imagen' => 'licuadora-pro.jpg', 'categoria' => 'Cocina Pequena'],
            ['id_producto' => 7, 'id_categoria' => 5, 'nombre' => 'Soundbar 2.1 Canales 300W', 'descripcion' => 'Barra de sonido con subwoofer inalambrico y HDMI ARC.', 'precio' => 599, 'stock' => 20, 'estado' => 'Disponible', 'imagen' => 'soundbar-21.jpg', 'categoria' => 'Audio y Video'],
            ['id_producto' => 8, 'id_categoria' => 1, 'nombre' => 'Smart TV 32 HD', 'descripcion' => 'Televisor LED inteligente ideal para dormitorios.', 'precio' => 799, 'stock' => 30, 'estado' => 'Disponible', 'imagen' => 'tv-32-hd.jpg', 'categoria' => 'Televisores'],
        ];
    }
}
