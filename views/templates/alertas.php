<?php
    foreach($alertas as $key => $mensajes): // Llave para identificar y acceder a los mensajes
        foreach($mensajes as $mensaje):
?>
    <div class="alerta <?php echo $key; ?>">
        <?php echo $mensaje; ?>
    </div>
<?php
        endforeach;
    endforeach;
?>