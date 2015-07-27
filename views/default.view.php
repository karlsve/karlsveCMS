<!DOCTYPE html>
<?php components\debug\init_error_handling(); ?>
<html>
<?php echo components\view\ViewFactory::get('head.view.php'); ?>
    <body>
    <?php echo components\view\ViewFactory::get('nav.view.php'); ?>
        <?php echo components\view\ViewFactory::get('content.view.php'); ?>
        <?php echo components\view\ViewFactory::get('debug.view.php'); ?>
        <?php echo components\view\ViewFactory::get('footer.view.php'); ?>
        <?php echo components\view\ViewFactory::get('js.view.php'); ?>
    </body>
</html>