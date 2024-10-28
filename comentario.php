<?php if (count($comentarios_formateados) > 0): ?>
    <ul class="comments-list">
        <?php foreach ($comentarios_formateados as $comentario): ?>
            <div class="comment-item">
                <div class="comment-header">
                    <div class="row">
                        <div class="col">
                            <div class="comment-user">
                                <?php if (!empty($comentario['foto_perfil'])): ?>
                                    <img src="<?php echo 'uploads/perfil/' . htmlspecialchars($comentario['foto_perfil']); ?>"
                                        alt="Foto de perfil"
                                        style="max-height: 30px; width: auto; border-radius: 50%; vertical-align: middle;">
                                <?php else: ?>
                                    <img src="uploads/perfil/default.png" alt="Foto de perfil predeterminada"
                                        style="max-height: 30px; width: auto; border-radius: 50%; vertical-align: middle;">
                                <?php endif; ?>

                                <strong><?php echo htmlspecialchars($comentario['nombre_usuario']); ?></strong>, hace
                                <?php echo $comentario['tiempo_comentario']; ?>
                            </div>
                        </div>
                        <?php if ($comentario['tiempo_edicion']): ?>
                            <div class="col">
                                <p class="comment-date">Última edición: hace
                                    <strong><?php echo $comentario['tiempo_edicion']; ?>
                                </p></strong>
                            </div>
                        <?php endif; ?>
                        <?php if ($nombre_usuario_actual === $comentario['nombre_usuario'] && !$comentario['eliminado']): ?>
                            <div class="col-1">
                                <a href="editar_comentario.php?id=<?php echo htmlspecialchars($comentario['id_comentario']); ?>&hilo_id=<?php echo htmlspecialchars($id_hilo); ?>"
                                    class="button secondary"><img
                                        src="https://icongr.am/feather/edit.svg?size=16&color=currentColor" alt="icon"></a>
                            </div>
                        <?php endif; ?>


                        <div class="col-1">
                            <small>#<?php echo htmlspecialchars($comentario['id_comentario']); ?></small>
                        </div>
                    </div>
                    <div class="comment-content">
                        <div class="row">
                            <?php if (!empty($comentario['imagen_ruta']) && !$comentario['eliminado']): // Mostrar imagen solo si no está eliminado ?>
                                <div class="col-is-left">
                                    <div class="imagen-comentario">
                                        <img src="<?php echo htmlspecialchars($comentario['imagen_ruta']); ?>"
                                            alt="Imagen del comentario" style="max-height: 200px; width: auto;">
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="col">
                                <?php if ($comentario['eliminado']): // Mostrar mensaje si el comentario ha sido eliminado ?>
                                    <p><em>Este comentario fue eliminado por el administrador</em></p>
                                <?php else: ?>
                                    <p><?php echo $comentario['contenido']; ?></p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col"></div>
                            <div class="col-2">
                                <?php if (isset($_SESSION['nombre_usuario']) && $_SESSION['nombre_usuario'] === 'admin' && !$comentario['eliminado']): ?>
                                    <a href="eliminar_comentario.php?id_comentario=<?php echo $comentario['id_comentario']; ?>&id_hilo=<?php echo $id_hilo; ?>"
                                        onclick="return confirm('¿Estás seguro de que deseas eliminar este comentario?');">
                                        <img src="https://icongr.am/feather/trash-2.svg?size=16&color=currentColor" alt="Eliminar">
                                        Eliminar comentario
                                    </a>
                                <?php endif; ?>


                                <?php if (!$comentario['eliminado']): ?>
                                    <a href="reporte.php?tipo=comentario&id=<?php echo htmlspecialchars($comentario['id_comentario']); ?>"
                                        class=""><img src="https://icongr.am/feather/alert-triangle.svg?size=16&color=currentColor"
                                            alt="Reportar"> Reportar</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </ul>
<?php else: ?>
    <p class="center-text">No hay comentarios para este hilo.</p>
<?php endif; ?>