# Proyecto PHP con phpMyAdmin

Este repositorio contiene un proyecto desarrollado en **PHP** junto con la gestión de bases de datos a través de **phpMyAdmin**. A continuación, encontrarás todos los pasos y configuraciones necesarias para ejecutar el proyecto de forma local en **Windows**, **Linux**, y **MacOS**.

## Requisitos Previos

Antes de iniciar, asegúrate de tener lo siguiente:

- **XAMPP** (Windows, Mac) o **LAMPP** (Linux): para el servidor Apache y MySQL.
- **phpMyAdmin**: suele venir incluido con XAMPP o LAMPP.
- Un navegador web (Chrome, Firefox, Edge, etc.).

### Instalación de XAMPP / LAMPP

#### Windows
1. Descarga XAMPP desde [https://www.apachefriends.org/es/index.html](https://www.apachefriends.org/es/index.html).
2. Ejecuta el instalador y sigue los pasos.
3. Asegúrate de instalar Apache, MySQL y phpMyAdmin.

#### Linux
1. Descarga el instalador de LAMPP desde el sitio oficial:
   ```bash
   wget https://www.apachefriends.org/xampp-files/8.2.4/xampp-linux-x64-8.2.4-0-installer.run
   ```
2. Asigna permisos de ejecución al instalador:
   ```bash
   chmod +x xampp-linux-x64-8.2.4-0-installer.run
   ```
3. Instala LAMPP:
   ```bash
   sudo ./xampp-linux-x64-8.2.4-0-installer.run
   ```
4. Inicia el servidor Apache y MySQL:
   ```bash
   sudo /opt/lampp/lampp start
   ```

#### MacOS
1. Descarga XAMPP para Mac desde [https://www.apachefriends.org/es/index.html](https://www.apachefriends.org/es/index.html).
2. Instala XAMPP y sigue las instrucciones.
3. Abre el **Panel de Control de XAMPP** y verifica que Apache y MySQL estén corriendo.

## Configuración del Proyecto

1. Clona este repositorio en la carpeta donde XAMPP/LAMPP sirve sus archivos web:

   **Windows** (XAMPP):
   ```bash
   cd C:\xampp\htdocs
   git clone https://github.com/tu-usuario/nombre-repositorio.git
   ```
   
   **Linux** o **MacOS** (LAMPP):
   ```bash
   cd /opt/lampp/htdocs
   git clone https://github.com/tu-usuario/nombre-repositorio.git
   ```

2. Importa la base de datos en phpMyAdmin:
   - Inicia el servidor Apache y MySQL desde el panel de control.
   - Abre [http://localhost/phpmyadmin](http://localhost/phpmyadmin).
   - Crea una nueva base de datos (dentro del codigo podrá encontrar el archivo para la creación de la misma).

3. Configura los archivos de conexión a la base de datos:
   - Abre los archivos `conexion.php`.
   - Actualiza los siguientes parámetros:
     ```php
     define('DB_HOST', 'localhost');
     define('DB_USER', 'root'); // Usuario predeterminado
     define('DB_PASS', '');     // Contraseña vacía por defecto en XAMPP
     define('DB_NAME', 'mi_base_datos');
     ```

## Ejecución del Proyecto

1. Asegúrate de que Apache y MySQL estén corriendo:
   - **Windows**: Abre XAMPP Control Panel y ejecuta Apache y MySQL.
   - **Linux/MacOS**: Ejecuta `sudo /opt/lampp/lampp start`.

2. Abre el navegador web y visita:
   ```
   http://localhost/Yovanny/login/login.php
   ```

3. ¡Listo! el proyecto PHP debería estar corriendo.


## Solución de Problemas

- **Apache/MySQL no inician:** Verifica que no haya otros servicios usando los puertos **80** (Apache) o **3306** (MySQL).
- **Error de conexión a la base de datos:** Asegúrate de que los parámetros en `conexion.php` sean correctos.
- **phpMyAdmin no carga:** Revisa que Apache y MySQL estén activos y visita [http://localhost/phpmyadmin](http://localhost/phpmyadmin).

## Autor

Creado por **Nathaly Victoriano Díaz**

---
¡Gracias por visitar este repositorio! Si tienes alguna pregunta o sugerencia, no dudes en abrir un **issue**.
