# AlpargateTech v2.0

Sistema de punto de venta (POS) para restaurantes con panel de cocina en tiempo real, gestión de inventario y reportes de ventas.

## Stack Tecnológico

| Capa | Tecnología |
|------|-----------|
| Backend | Laravel 12 + PHP 8.2 |
| Base de datos | PostgreSQL |
| Frontend | Blade + Alpine.js + Tailwind CSS |
| WebSockets | Laravel Reverb |
| PDF | DomPDF |
| Cola de trabajos | Laravel Queue (database) |

## Módulos del Sistema

| Módulo | Roles con acceso |
|--------|----------------|
| 🗺️ Mesas | Admin, Mesero |
| 🍽️ Pedidos | Admin, Mesero |
| 🔥 Cocina (tiempo real) | Admin, Cocinero |
| 📊 Reportes & Ventas | Admin |
| 🧂 Inventario - Ingredientes | Admin |
| 🏢 Activos Fijos | Admin |
| 🍕 Menú (Categorías + Productos) | Admin |
| 👥 Clientes | Admin |
| 🔐 Usuarios | Admin |
| 📋 Auditoría | Admin |

## Requisitos Previos

- PHP 8.2+
- Composer
- Node.js 18+
- PostgreSQL 14+

## Instalación

```bash
# 1. Clonar el repositorio
git clone https://github.com/TU_USUARIO/ALPARGATETECH-v2.0.git
cd ALPARGATETECH-v2.0

# 2. Instalar dependencias PHP
composer install

# 3. Instalar dependencias JavaScript
npm install

# 4. Copiar y configurar variables de entorno
cp .env.example .env
# Editar .env con tu editor de texto

# 5. Generar clave de aplicación
php artisan key:generate

# 6. Crear la base de datos en PostgreSQL
# psql -U postgres -c "CREATE DATABASE alpargatetech;"

# 7. Correr las migraciones y seeders
php artisan migrate --seed

# 8. Compilar assets
npm run build
```

## Configuración del Correo (2FA)

El sistema usa autenticación de dos factores por correo. Para configurar Gmail:

1. Ve a tu cuenta Google → **Seguridad** → **Verificación en 2 pasos**
2. Al fondo de la página busca **Contraseñas de aplicación**
3. Crea una contraseña para "Correo" y "Otro dispositivo"
4. Copia la contraseña de 16 caracteres en tu `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tu_correo@gmail.com
MAIL_PASSWORD=xxxx_xxxx_xxxx_xxxx
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS="tu_correo@gmail.com"
```

## Ejecutar en Desarrollo

```bash
composer run dev
```

Esto inicia simultáneamente:
- Servidor PHP (`php artisan serve`)
- Cola de trabajos (`php artisan queue:listen`)
- Compilador Vite (`npm run dev`)
- Servidor WebSocket Reverb (`php artisan reverb:start`)

## Arquitectura

```
app/
├── Http/
│   ├── Controllers/     # Solo orquestación — sin lógica de negocio
│   ├── Middleware/       # Autenticación, roles
│   └── Requests/        # Validación con Form Requests
├── Models/              # Eloquent ORM
├── Services/            # Lógica de negocio (OrderService, AuditLogger)
└── Enums/               # OrderStatus, TableStatus, UserRole

resources/views/
├── layouts/             # Layout principal con sidebar
├── admin/               # Vistas de administración (menú, reportes)
├── inventory/           # Módulo de inventario
├── orders/              # Flujo de pedidos
├── kitchen/             # Panel de cocina
└── auth/                # Login, 2FA, recuperación de contraseña
```

## Roles y Permisos

| Rol | Panel | Mesas | Pedidos | Cocina | Admin |
|-----|-------|-------|---------|--------|-------|
| `admin` | ✅ | ✅ | ✅ | ✅ | ✅ |
| `mesero` | — | ✅ | ✅ | — | — |
| `cocinero` | — | — | — | ✅ | — |

## Flujo de un Pedido

```
Mesero selecciona mesa
    → Escoge productos del menú
        → Pedido creado (estado: En Cocina)
            → Cocina recibe en tiempo real (WebSocket)
                → Cocinero actualiza estado
                    → Mesero entrega → Pago → Mesa libre
```

## Licencia

Proyecto privado — Todos los derechos reservados.
