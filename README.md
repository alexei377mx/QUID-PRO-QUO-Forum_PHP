> # Documentación del Foro

Este repositorio contiene los archivos PHP principales que implementan un foro en línea llamado QUID PRO QUO Forum, con funcionalidades para la gestión de usuarios, hilos, comentarios, reportes y administración general. A continuación, se proporciona una guía completa de cada archivo, describiendo su propósito, funcionamiento, y manejo de errores.

---

## Tabla de Contenido
 - [crear_hilo.php](#1-crear_hilophp)
 - [editar_comentario.php](#2-editar_comentariophp)
 - [editar_hilo.php](#3-editar_hilophp)
 - [eliminar_comentario.php](#4-eliminar_comentariophp)
 - [actualizar_foto_perfil.php](#5-actualizar_foto_perfilphp)
 - [admin.php](#6-adminphp)
 - [agregar_comentario.php](#7-agregar_comentariophp)
 - [categorias.php](#8-categoriasphp)
 - [comentario.php](#9-comentariophp)
 - [conexion.php](#10-conexionphp)
 - [logout.php](#11-logoutphp)
 - [perfil.php](#12-perfilphp)
 - [politica.php](#13-politicaphp)
 - [eliminar_hilo.php](#14-eliminar_hilophp)
 - [footer.php](#15-footerphp)
 - [foro1.sql](#16-foro1sql)
 - [header.php](#17-headerphp)
 - [hilo.php](#18-hilophp)
 - [index.php](#19-indexphp)
 - [login.php](#20-loginphp)
 - [reporte.php](#21-reportephp)
 - [reset_password.php](#22-reset_passwordphp)
 - [ver_hilo.php](#23-ver_hilophp)
 - [registro.php](#24-registrophp)

---

### 1. `crear_hilo.php`
**Descripción:**  
Permite a los usuarios crear un nuevo hilo en el foro.

**Funcionamiento:**
- **Entradas:** Recibe datos del formulario (`título`, `contenido`, `categoría`, `imagen`).
- **Proceso:** Valida que los campos no estén vacíos, sube imágenes si están presentes, inserta los datos en la base de datos.
- **Errores manejados:** Muestra alertas si faltan datos o la subida de imagen falla.

---

### 2. `editar_comentario.php`
**Descripción:**  
Permite a los usuarios editar comentarios existentes.

**Funcionamiento:**
- **Entradas:** `id_comentario`, `nuevo_contenido`.
- **Proceso:** Verifica permisos, sanitiza, y actualiza el contenido en la base de datos.
- **Errores manejados:** Alerta si faltan datos o no se tiene permiso de edición.

---

### 3. `editar_hilo.php`
**Descripción:**  
Permite a los usuarios editar un hilo existente.

**Funcionamiento:**
- **Entradas:** `id_hilo`, `nuevo_título`, `nuevo_contenido`, `nueva_imagen`.
- **Proceso:** Verifica permisos, actualiza los datos, y reemplaza la imagen si es necesario.
- **Errores manejados:** Notificación si el usuario no tiene permisos o hay error con la imagen.

---

### 4. `eliminar_comentario.php`
**Descripción:**  
Permite a los administradores eliminar un comentario específico.

**Funcionamiento:**
- **Entradas:** `id_comentario`.
- **Proceso:** Verifica que el usuario sea administrador y elimina el comentario de la base de datos.
- **Errores manejados:** Mensaje de confirmación para evitar eliminaciones accidentales.

---

### 5. `actualizar_foto_perfil.php`
**Descripción:**  
Permite a los usuarios actualizar su foto de perfil.

**Funcionamiento:**
- **Entradas:** `foto_perfil`.
- **Proceso:** Verifica el tipo de archivo y sube la imagen al servidor.
- **Errores manejados:** Muestra alertas si el formato no es compatible o si hay error en la subida.

---

### 6. `admin.php`
**Descripción:**  
Permite la administración general del foro.

**Funcionamiento:**
- **Entradas:** `filtros`, `nombre_radio`, `url_radio`.
- **Proceso:** Permite filtrar reportes y gestionar radios.
- **Errores manejados:** Alerta si falla la consulta SQL o hay errores en la base de datos.

---

### 7. `agregar_comentario.php`
**Descripción:**  
Permite a los usuarios añadir comentarios a los hilos.

**Funcionamiento:**
- **Entradas:** `id_hilo`, `contenido`, `imagen`.
- **Proceso:** Inserta el comentario en la base de datos y permite adjuntar imágenes.
- **Errores manejados:** Alerta si el contenido está vacío o la subida de imagen falla.

---

### 8. `categorias.php`
**Descripción:**  
Muestra hilos organizados por categorías.

**Funcionamiento:**
- **Entradas:** `id_categoria`, `page`.
- **Proceso:** Filtra y muestra los hilos por categorías, implementando paginación.
- **Errores manejados:** Alertas si falla la consulta SQL o la categoría no existe.

---

### 9. `comentario.php`
**Descripción:**  
Plantilla para mostrar comentarios de un hilo.

**Funcionamiento:**
- **Entradas:** Variables globales como `id_hilo`, `id_comentario`.
- **Proceso:** Muestra contenido del comentario, fecha y opciones de edición o reporte.
- **Errores manejados:** Muestra un mensaje si el comentario ha sido eliminado.

---

### 10. `conexion.php`
**Descripción:**  
Configura la conexión con la base de datos.

**Funcionamiento:**
- **Configuración:** Define credenciales y conjunto de caracteres (`utf8mb4`).
- **Errores manejados:** Si falla la conexión, muestra un mensaje de error.

---

### 11. `logout.php`
**Descripción:**  
Cierra la sesión del usuario actual.

**Funcionamiento:**
- **Proceso:** Elimina variables de sesión y redirige al usuario.
- **Errores manejados:** No requiere manejo de errores.

---

### 12. `perfil.php`
**Descripción:**  
Muestra la información del perfil del usuario.

**Funcionamiento:**
- **Entradas:** Datos del usuario como `nombre_usuario`, `correo`, `foto_perfil`.
- **Proceso:** Muestra y permite editar algunos datos personales.
- **Errores manejados:** Alerta si el tipo de archivo no es compatible o si falla la actualización.

---

### 13. `politica.php`
**Descripción:**  
Muestra las políticas de uso del foro.

**Funcionamiento:**
- **Proceso:** Presenta el texto de la política de privacidad.
- **Errores manejados:** No se requieren.

---

### 14. `eliminar_hilo.php`
**Descripción:**  
Permite a los administradores eliminar un hilo.

**Funcionamiento:**
- **Entradas:** `id_hilo`.
- **Proceso:** Verifica permisos y elimina el hilo.
- **Errores manejados:** Mensaje de confirmación para evitar eliminaciones accidentales.

---

### 15. `footer.php`
**Descripción:**  
Plantilla para el pie de página del foro.

---

### 16. `foro1.sql`
**Descripción:**  
Define la estructura de la base de datos y algunos datos iniciales.

---

### 17. `header.php`
**Descripción:**  
Plantilla para el encabezado y navegación principal del foro.

---

### 18. `hilo.php`
**Descripción:**  
Muestra una vista previa de los hilos.

**Funcionamiento:**
- **Entradas:** `id_hilo`, `titulo`, `fecha_creacion`.
- **Errores manejados:** No se muestran errores en esta plantilla.

---

### 19. `index.php`
**Descripción:**  
Página de inicio que muestra los hilos recientes.

**Funcionamiento:**
- **Proceso:** Muestra los hilos con opciones de navegación.
- **Errores manejados:** Alerta si no hay hilos disponibles.

---

### 20. `login.php`
**Descripción:**  
Permite a los usuarios iniciar sesión.

**Funcionamiento:**
- **Entradas:** `nombre_usuario`, `contrasena`.
- **Errores manejados:** Mensaje si las credenciales son incorrectas.

---

### 21. `reporte.php`
**Descripción:**  
Permite a los usuarios reportar hilos o comentarios.

**Funcionamiento:**
- **Entradas:** `tipo`, `id`.
- **Errores manejados:** Alerta si el usuario intenta reportar sin estar autenticado.

---

### 22. `reset_password.php`
**Descripción:**  
Permite cambiar la contraseña en caso de olvido.

**Funcionamiento:**
- **Entradas:** `nueva_contrasena`, `confirmar_contrasena`.
- **Errores manejados:** Alerta si las contraseñas no coinciden.

---

### 23. `ver_hilo.php`
**Descripción:**  
Muestra el contenido completo de un hilo y sus comentarios.

**Funcionamiento:**
- **Entradas:** `id_hilo`.
- **Errores manejados:** Redirige al inicio si el hilo no se encuentra.

---

### 24. `registro.php`
**Descripción:**  
Permite a los usuarios registrarse en el foro.

**Funcionamiento:**
- **Entradas:** `nombre_usuario`, `email`, `contrasena`.
- **Errores manejados:** Alerta si el nombre de usuario o el email ya están en uso.

---

> Este documento proporciona una guía completa y detallada sobre la funcionalidad de cada archivo, para facilitar la administración y el desarrollo del foro en línea.
