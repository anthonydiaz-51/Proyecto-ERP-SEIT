# Base de datos y validación operativa del ERP SEIT

## Fuente del esquema

La base `ERP_SEIT` se originó con SQL ejecutado manualmente. La estructura consultada en MySQL el 3 de noviembre de 2026 contiene las tablas principales de clientes, usuarios, servicios, cotizaciones, órdenes de servicio, pagos, productos e inventario, además de las tablas Laravel y los módulos de proveedores y compras.

El archivo SQL compartido se conserva como referencia histórica. Para describir la instalación activa se verificaron columnas, tipos e integridad referencial desde `information_schema`; no se leyeron filas de clientes ni de usuarios.

Se encontraron diferencias entre el SQL original y la base activa:

- La tabla activa `servicios` usa la columna `servicio`; el SQL original decía `nombre`. Los modelos y formularios actuales también usan `servicio`.
- La tabla activa `ordenes_servicio` contiene `cotizacion_id` y su relación con `cotizaciones`, aunque no aparece en el SQL original.
- `contactos_cliente.nombre` tiene longitud 250 en la base activa.
- Los nombres ENUM de las categorías de productos ya están normalizados en MySQL; el SQL pegado contenía comillas tipográficas.

La migración base nueva se ajusta a la estructura activa de estas tablas. No renombra columnas ni transforma datos.

## Migraciones

La migración `2026_10_26_000001_create_erp_core_tables` versiona las tablas de negocio originales. Para cada tabla, verifica si existe y solo la crea cuando falta. Esto permite usar el mismo historial de migraciones en dos escenarios:

1. En una base nueva, crea el esquema principal y después se ejecutan las migraciones de proveedores y compras.
2. En la base existente de SEIT, adopta las tablas actuales sin recrearlas. La migración se registra en `migrations` y conserva sus filas.

Esta migración base no se revierte automáticamente. Su `down()` no elimina tablas, porque en una instalación heredada podría borrar datos que existían antes de agregar la migración. Para reiniciar una base de desarrollo desechable se puede usar el procedimiento de recreación correspondiente, pero nunca `migrate:fresh` sobre la base real.

Las migraciones de Proveedores y Compras ya aparecen registradas en la base activa. No se vuelven a ejecutar al actualizar esa instalación.

## Preparar una base nueva

1. Crear una base MySQL vacía llamada `ERP_SEIT` con codificación `utf8mb4`.
2. Configurar en `.env` la conexión `mysql`, el host, puerto, nombre de base, usuario y contraseña. No guardar credenciales reales en Git.
3. Instalar las dependencias del proyecto y generar `APP_KEY` si la instalación lo requiere.
4. Si se desea crear el primer administrador desde el seeder, definir antes de sembrar:

   ```dotenv
   SEIT_CREATE_INITIAL_ADMIN=true
   SEIT_ADMIN_NAME=Nombre del administrador
   SEIT_ADMIN_EMAIL=correo-administrador
   SEIT_ADMIN_PASSWORD=contraseña-de-al-menos-12-caracteres
   ```

   Las variables aparecen vacías y desactivadas en `.env.example`. El usuario inicial se crea solo cuando `SEIT_CREATE_INITIAL_ADMIN=true`; no existe una contraseña predeterminada.

5. Ejecutar:

   ```bash
   php artisan migrate --seed
   ```

6. Después de crear el usuario inicial, cambiar `SEIT_CREATE_INITIAL_ADMIN=false` o retirar sus variables locales. No compartir el valor de `SEIT_ADMIN_PASSWORD`.

El seeder crea los cinco roles con los IDs que usa actualmente el middleware y agrega las categorías iniciales de servicios y productos si aún no existen. Usa `firstOrCreate`, por lo que conserva las filas existentes y no reemplaza los nombres ni los estados ya capturados.

## Actualizar la base activa de SEIT

Antes de aplicar cambios:

1. Crear y verificar un respaldo de la base completa.
2. Confirmar que `.env` apunta a `ERP_SEIT`.
3. Revisar los cambios pendientes con `php artisan migrate:status`.
4. Esta migración usa `Schema::hasTable` para adoptar las tablas existentes. En `--pretend`, Laravel no evalúa correctamente el resultado de esas consultas condicionales y puede mostrar los `CREATE TABLE` aunque las tablas ya existan. Por eso, no uses el SQL de `php artisan migrate --pretend` de esta migración como prueba de que va a recrear tablas; confirma primero la estructura con `migrate:status` y una inspección de `information_schema` o phpMyAdmin.
5. Ejecutar `php artisan migrate` en una ventana acordada y verificar después la versión registrada. En ejecución normal, la migración comprueba cada tabla en MySQL y omite las que ya existen.

La migración base solo crea las tablas que falten. Aun así, debe revisarse el respaldo y el SQL previsto antes de aplicar cualquier migración en una base de producción.

## Lista de validación funcional

Realizar estas comprobaciones con usuarios y datos de prueba aprobados por SEIT:

### Acceso y catálogos

- Iniciar sesión con cada rol acordado y confirmar que puede ver únicamente las funciones que le corresponden.
- Crear, editar, buscar y desactivar un cliente sin perder las relaciones con cotizaciones y órdenes anteriores.
- Crear y desactivar un servicio, y confirmar que los selectores muestran solo los servicios activos.
- Crear un producto con existencia inicial y comprobar el movimiento que deja registro de esa entrada.

### Comercial y servicio técnico

- Crear una cotización con una y varias líneas; revisar cantidades, descuentos fijos y porcentuales, subtotal, impuesto y total.
- Aceptar una cotización y generar una orden. Repetir la acción para confirmar que no se crea una segunda orden activa para la misma cotización.
- Avanzar la orden por los estados operativos, asignar técnico, registrar diagnóstico, solución y fechas, y cerrar con entrega o cancelación.
- Registrar pagos parciales y completos. Confirmar que el importe acumulado no excede el saldo de la orden.

### Compras e inventario

- Registrar una compra con varios productos y confirmar que se actualizan existencias, costo de compra y movimiento de entrada.
- Registrar entrada, salida y ajuste manual; verificar cantidades, referencias, motivos y usuario responsable.
- Intentar una salida mayor a la existencia y confirmar que el sistema la rechaza.
- Consultar productos agotados y por debajo del stock mínimo.

### Respaldo y recuperación

- Crear un respaldo de base y archivos cargados según el procedimiento operativo acordado.
- Restaurar el respaldo en una base de prueba y confirmar que usuarios, catálogos, órdenes, pagos e inventario se pueden consultar.

Registrar el resultado, fecha y responsable de cada escenario. Corregir incidencias y repetir los escenarios afectados antes de habilitar el módulo para el uso diario.
