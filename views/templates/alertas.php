<?php
foreach ($alerts as $key => $value) {
    foreach ($value as $message) {
?>
    <div class="alerta <?php echo  $key ?>">
        <?php echo $message; ?>
    </div>
<?php
    }
}
?>