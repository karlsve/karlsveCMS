<?php
if (\components\debug\Debug::hasErrors()):
    ?>
    <div class="container-fluid col-xs-12 col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3>Debug</h3>
            </div>
            <table class="table table-bordered table-condensed">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>String</th>
                        <th>File</th>
                        <th>Line</th>
                    </tr>
                </thead>
                <?php
                foreach (\components\debug\Debug::getErrors() as $error):
                    ?>
                    <tr>
                        <td><?php echo $error->getNumber(); ?></td>
                        <td><?php echo $error->getString(); ?></td>
                        <td><?php echo $error->getFile(); ?></td>
                        <td><?php echo $error->getLine(); ?></td>
                    </tr>
                    <?php
                endforeach;
                ?>
            </table>
        </div>
    </div>
    <?php
endif;
?>