> # Pruebas de funcionalidad

### Pruebas para `crear_hilo.php`

| Prueba                                       | ¿Se acepta? | ¿Por qué?                                                                                     |
|----------------------------------------------|-------------|----------------------------------------------------------------------------------------------------------|
| Usuario autenticado intenta crear un hilo    | Sí          | Verifica que el sistema permita crear un hilo si el usuario está autenticado.                             |
| Usuario no autenticado intenta crear un hilo | No          | Asegura que se redirija al usuario a `login.php` si no ha iniciado sesión.                                |
| Creación de hilo con campos vacíos           | No          | Valida que los campos de `titulo` y `contenido` no pueden estar vacíos.                                   |
| Selección de categoría                       | Sí          | Verifica que el campo `categoria` debe contener un valor válido si está presente.                         |

---

### Pruebas para `editar_comentario.php`

| Prueba                                      | ¿Se acepta? | ¿Por qué?                                                                                           |
|---------------------------------------------|-------------|------------------------------------------------------------------------------------------------------------------|
| Usuario autenticado edita su comentario     | Sí          | Confirma que el usuario autenticado puede editar solo sus propios comentarios.                                  |
| Usuario no autenticado intenta editar       | No          | Valida que se le solicite iniciar sesión antes de poder editar.                                                 |
| Edición de comentario inexistente           | No          | Se asegura de que la edición falle si el comentario no existe o no es del usuario.                              |
| Cambios exitosos en el contenido            | Sí          | Verifica que se actualice correctamente el contenido tras la edición.                                           |

---

### Pruebas para `editar_hilo.php`

| Prueba                                | ¿Se acepta? | ¿Por qué?                                                                                            |
|---------------------------------------|-------------|-------------------------------------------------------------------------------------------------------------------|
| Usuario autenticado edita su hilo     | Sí          | Permite que el usuario modifique solo hilos que él mismo ha creado.                                              |
| Usuario no autenticado intenta editar | No          | Requiere que el usuario inicie sesión antes de editar.                                                           |
| Edición de hilo inexistente           | No          | Garantiza que no se pueda editar un hilo inexistente.                                                            |
| Actualización exitosa del contenido   | Sí          | Verifica que los cambios en el contenido del hilo se guarden correctamente.                                      |

---

### Pruebas para `eliminar_comentario.php`

| Prueba                                    | ¿Se acepta? | ¿Por qué?                                                                                            |
|-------------------------------------------|-------------|-------------------------------------------------------------------------------------------------------------------|
| Admin elimina comentario                  | Sí          | Permite que solo el administrador pueda borrar comentarios.                                                      |
| Usuario intenta eliminar comentario propio| No          | Confirma que los usuarios regulares no tienen permisos para eliminar sus comentarios.                            |
| Eliminación de comentario inexistente     | No          | Previene la eliminación si el comentario especificado no existe.                                                 |

---

### Pruebas para `actualizar_foto_perfil.php`

| Prueba                                          | ¿Se acepta? | ¿Por qué?                                                                                            |
|-------------------------------------------------|-------------|-------------------------------------------------------------------------------------------------------------------|
| Usuario autenticado actualiza su foto de perfil | Sí          | Permite que el usuario cambie solo su propia foto de perfil.                                                     |
| Usuario no autenticado intenta actualizar       | No          | Solicita inicio de sesión para actualizar la foto de perfil.                                                     |
| Actualización con archivo no permitido          | No          | Verifica que solo archivos válidos puedan ser cargados.                                                          |

---

### Pruebas para `admin.php`

| Prueba                           | ¿Se acepta? | ¿Por qué?                                                                                           |
|----------------------------------|-------------|------------------------------------------------------------------------------------------------------------------|
| Acceso de usuario sin permisos   | No          | Evita que usuarios sin privilegios accedan a funcionalidades administrativas.                                   |
| Admin visualiza objetos filtrados| Sí          | Verifica que el administrador pueda filtrar y ver datos específicos.                                            |
| Modificación de parámetros       | Sí          | Permite que el administrador cambie configuraciones según parámetros dados.                                     |

---

### Pruebas para `agregar_comentario.php`

| Prueba                                      | ¿Se acepta? | ¿Por qué?                                                                                            |
|---------------------------------------------|-------------|-------------------------------------------------------------------------------------------------------------------|
| Usuario autenticado agrega comentario       | Sí          | Permite añadir comentarios si el usuario está autenticado.                                                       |
| Usuario no autenticado intenta comentar     | No          | Impide agregar comentarios sin haber iniciado sesión.                                                            |
| Comentario vacío o con contenido inválido   | No          | Rechaza el comentario si el contenido está vacío o no es válido.                                                 |

---

### Pruebas para `categorias.php`

| Prueba                                 | ¿Se acepta? | ¿Por qué?                                                                                            |
|----------------------------------------|-------------|-------------------------------------------------------------------------------------------------------------------|
| Visualización de categorías            | Sí          | Permite cargar y mostrar las categorías existentes.                                                              |
| Error en la carga de categorías        | No          | Se asegura de manejar adecuadamente errores de base de datos.                                                    |
| Navegación por paginación              | Sí          | Permite la paginación correcta en la visualización de categorías.                                                |

---

### Pruebas para `comentario.php`

| Prueba                         | ¿Se acepta? | ¿Por qué?                                                                                            |
|--------------------------------|-------------|-------------------------------------------------------------------------------------------------------------------|
| Visualización de comentarios   | Sí          | Permite cargar y mostrar comentarios asociados al contenido.                                                     |
| Error en la carga de datos     | No          | Se asegura de que se gestionen correctamente errores de carga de datos.                                          |

---

### Pruebas para `conexion.php`

| Prueba                         | ¿Se acepta? | ¿Por qué?                                                                                            |
|--------------------------------|-------------|-------------------------------------------------------------------------------------------------------------------|
| Conexión exitosa               | Sí          | Permite la conexión a la base de datos usando credenciales correctas.                                            |
| Error en la conexión           | No          | Muestra un mensaje de error en caso de fallas en la conexión a la base de datos.                                 |

--- 

### Pruebas para `index.php`

| Prueba                                 | ¿Se acepta? | ¿Por qué?                                                                                            |
|----------------------------------------|-------------|-------------------------------------------------------------------------------------------------------------------|
| Paginación de hilos                    | Sí          | Asegura que se visualicen los hilos correctamente de acuerdo a la paginación definida.                           |
| Carga de hilos recientes               | Sí          | Permite ordenar los hilos según la actividad más reciente, incluidas las respuestas.                             |
| Error en la carga de hilos             | No          | Gestiona errores de consulta en caso de problemas de conexión o consulta de datos.                               |

---

### Pruebas para `login.php`

| Prueba                                      | ¿Se acepta? | ¿Por qué?                                                                                            |
|---------------------------------------------|-------------|-------------------------------------------------------------------------------------------------------------------|
| Inicio de sesión exitoso                    | Sí          | Permite el inicio de sesión cuando se ingresan credenciales válidas.                                             |
| Inicio de sesión fallido                    | No          | Muestra un mensaje de error si las credenciales son incorrectas.                                                 |
| Verificación de reCAPTCHA                   | Sí          | Garantiza la protección adicional mediante reCAPTCHA (si está activado).                                         |
| Sesión de usuario ya iniciada               | Sí          | Redirige al usuario a la página principal si ya ha iniciado sesión.                                              |

---

### Pruebas para `logout.php`

| Prueba                          | ¿Se acepta? | ¿Por qué?                                                                                            |
|---------------------------------|-------------|-------------------------------------------------------------------------------------------------------------------|
| Cierre de sesión                | Sí          | Asegura que el usuario cierre su sesión correctamente y sea redirigido a `index.php`.                            |

---

### Pruebas para `perfil.php`

| Prueba                                    | ¿Se acepta? | ¿Por qué?                                                                                            |
|-------------------------------------------|-------------|-------------------------------------------------------------------------------------------------------------------|
| Visualización del perfil de usuario       | Sí          | Permite ver el perfil del usuario solicitado si existe.                                                          |
| Perfil no especificado                    | No          | Redirige al usuario a la página principal si no se proporciona un perfil válido.                                 |
| Datos incorrectos o error en la carga     | No          | Muestra un mensaje de error si la consulta de perfil falla o no se encuentra el usuario.                         |

---

### Pruebas para `politica.php`

| Prueba                         | ¿Se acepta? | ¿Por qué?                                                                                            |
|--------------------------------|-------------|-------------------------------------------------------------------------------------------------------------------|
| Visualización de contenido     | Sí          | Muestra correctamente el contenido de la política de uso.                                                        |
| Error en la carga del contenido| No          | Asegura una respuesta adecuada en caso de que ocurra un problema de carga.                                       |

---

### Pruebas para `registro.php`

| Prueba                                         | ¿Se acepta? | ¿Por qué?                                                                                            |
|------------------------------------------------|-------------|-------------------------------------------------------------------------------------------------------------------|
| Registro exitoso de usuario                    | Sí          | Permite el registro si se ingresan datos válidos y el dominio de correo está permitido.                          |
| Registro con datos faltantes o inválidos       | No          | Solicita los datos requeridos o muestra un mensaje de error si faltan campos o los datos no cumplen con el formato. |
| Confirmación de contraseña                     | No          | Asegura que las contraseñas coincidan antes de registrar al usuario.                                             |

---

### Pruebas para `eliminar_hilo.php`

| Prueba                                | ¿Se acepta? | ¿Por qué?                                                                                            |
|---------------------------------------|-------------|-------------------------------------------------------------------------------------------------------------------|
| Eliminación de hilo por administrador | Sí          | Permite solo al administrador eliminar un hilo.                                                                  |
| Usuario regular intenta eliminar      | No          | Evita que usuarios sin permisos eliminen hilos.                                                                  |
| Eliminación de hilo inexistente       | No          | Previene la eliminación si el hilo no existe o ya ha sido eliminado.                                             |

---

### Pruebas para `footer.php`

| Prueba                        | ¿Se acepta? | ¿Por qué?                                                                                            |
|-------------------------------|-------------|-------------------------------------------------------------------------------------------------------------------|
| Visualización correcta        | Sí          | Muestra el pie de página correctamente en todas las páginas donde se incluya.                                    |
| Error de estilo               | No          | Se asegura de que el estilo del pie de página cargue adecuadamente.                                              |

---

### Pruebas para `header.php`

| Prueba                           | ¿Se acepta? | ¿Por qué?                                                                                            |
|----------------------------------|-------------|-------------------------------------------------------------------------------------------------------------------|
| Carga de categorías              | Sí          | Muestra correctamente el menú de categorías en el encabezado.                                                    |
| Error en la carga de datos       | No          | Asegura la gestión de errores si fallan las consultas de categorías o radios.                                    |

---

### Pruebas para `hilo.php`

| Prueba                             | ¿Se acepta? | ¿Por qué?                                                                                            |
|------------------------------------|-------------|-------------------------------------------------------------------------------------------------------------------|
| Visualización de hilo y comentarios| Sí          | Permite ver el hilo seleccionado junto con sus comentarios asociados.                                            |
| Error al cargar hilo o comentarios | No          | Gestiona errores de consulta o de carga en caso de problemas de conexión o datos.                                |

---

### Pruebas para `reset_password.php`

| Prueba                                         | ¿Se acepta? | ¿Por qué?                                                                                            |
|------------------------------------------------|-------------|-------------------------------------------------------------------------------------------------------------------|
| Usuario autenticado cambia su contraseña       | Sí          | Permite que el usuario autenticado cambie su contraseña con los datos correctos.                                 |
| Usuario no autenticado intenta cambiar         | No          | Redirige al usuario a `login.php` si no ha iniciado sesión.                                                      |
| Contraseñas nuevas no coinciden                | No          | Asegura que las contraseñas coincidan antes de realizar el cambio.                                               |
| Contraseña actual incorrecta                   | No          | Valida que el cambio falle si la contraseña actual proporcionada es incorrecta.                                  |

---

### Pruebas para `ver_hilo.php`

| Prueba                                         | ¿Se acepta? | ¿Por qué?                                                                                            |
|------------------------------------------------|-------------|-------------------------------------------------------------------------------------------------------------------|
| Visualización de hilo existente                | Sí          | Permite visualizar un hilo y su información si existe y no está eliminado.                                       |
| Hilo no existente o eliminado                  | No          | Muestra un mensaje de error o redirige si el hilo especificado no existe.                                        |
| Carga de comentarios asociados al hilo         | Sí          | Asegura la visualización correcta de todos los comentarios relacionados con el hilo.                             |
| Error en la carga de datos                     | No          | Gestiona errores si falla la consulta del hilo o los comentarios.                                                |

---

### Pruebas para `reporte.php`

| Prueba                                         | ¿Se acepta? | ¿Por qué?                                                                                            |
|------------------------------------------------|-------------|-------------------------------------------------------------------------------------------------------------------|
| Usuario autenticado envía reporte              | Sí          | Permite a un usuario autenticado reportar un hilo o comentario.                                                  |
| Usuario no autenticado intenta reportar        | No          | Solicita inicio de sesión antes de poder enviar un reporte.                                                      |
| Datos de reporte incompletos                   | No          | Asegura que el formulario de reporte no se envíe si faltan datos requeridos.                                     |
| Reporte de objeto inexistente                  | No          | Previene reportes si el hilo o comentario especificado no existe.                                                |

---
## Resumen Acumulativo

1. **Autenticación y Permisos de Usuario**:
   - **Inicio de sesión** (`login.php`): El sistema debe permitir el acceso a usuarios con credenciales válidas y redirigir a `index.php` en caso de éxito. Implementar reCAPTCHA para seguridad adicional.
   - **Registro de usuario** (`registro.php`): El sistema debe validar todos los campos y verificar que el dominio del correo esté permitido antes de completar el registro.
   - **Cerrar sesión** (`logout.php`): Cierra correctamente la sesión del usuario y redirige a `index.php`.
   - **Control de acceso** en múltiples archivos (`crear_hilo.php`, `editar_comentario.php`, `editar_hilo.php`, `eliminar_comentario.php`, `admin.php`, `reset_password.php`, `reporte.php`): Solo los usuarios autenticados o con roles específicos pueden realizar acciones críticas (crear, editar, eliminar, y reportar).

2. **Gestión de Contenidos**:
   - **Creación de hilos y comentarios** (`crear_hilo.php`, `agregar_comentario.php`): Los usuarios autenticados pueden crear hilos y comentarios con contenido válido. Los campos vacíos o inválidos deben ser rechazados.
   - **Edición de hilos y comentarios** (`editar_hilo.php`, `editar_comentario.php`): Los usuarios pueden modificar sus propios contenidos, mientras que el sistema valida que el contenido existe y que pertenece al usuario.
   - **Eliminación de hilos y comentarios** (`eliminar_hilo.php`, `eliminar_comentario.php`): Solo los administradores pueden eliminar hilos o comentarios, asegurando que existan antes de la acción.
   - **Visualización de hilos y comentarios** (`ver_hilo.php`, `hilo.php`, `comentario.php`): El sistema carga hilos y sus comentarios asociados, gestionando adecuadamente cualquier error de consulta.

3. **Perfil de Usuario**:
   - **Actualización de foto de perfil** (`actualizar_foto_perfil.php`): El usuario puede cargar una foto de perfil válida, y el sistema verifica permisos y formato de archivo.
   - **Cambio de contraseña** (`reset_password.php`): Los usuarios autenticados pueden cambiar su contraseña, siempre que coincidan y la contraseña actual sea correcta.
   - **Visualización del perfil** (`perfil.php`): Permite a los usuarios ver su perfil o el de otros, siempre que el usuario exista.

4. **Administración** (`admin.php`):
   - Los administradores pueden acceder a una interfaz de control para gestionar configuraciones, visualizaciones y acciones exclusivas. Se asegura que solo usuarios autorizados accedan a esta sección.

5. **Navegación y Visualización de Contenidos**:
   - **Paginación de hilos** (`index.php`, `categorias.php`): Implementa la paginación para cargar hilos por página, incluyendo filtrado por actividad reciente.
   - **Carga de categorías** (`header.php` y `categorias.php`): Se muestran categorías válidas en el encabezado y en la navegación, gestionando cualquier fallo de consulta.

6. **Reportes de Contenidos** (`reporte.php`):
   - Los usuarios autenticados pueden enviar reportes de hilos o comentarios específicos, con validación de datos completos antes del envío.

7. **Contenido Informativo**:
   - **Política de uso justo** (`politica.php`): Muestra la página de políticas de uso con contenido estático.
   - **Footer y Header** (`footer.php`, `header.php`): Implementan elementos de navegación y pie de página visibles en todas las páginas.

8. **Conexión a Base de Datos** (`conexion.php`):
   - Establece la conexión a la base de datos y configura el juego de caracteres. Gestiona errores de conexión y finaliza la ejecución en caso de fallo.


> Este resumen cubre todos los archivos y funcionalidades, proporcionando una visión general de los requisitos de autenticación, permisos, gestión de contenido, navegación y seguridad para un sistema de foro web básico.