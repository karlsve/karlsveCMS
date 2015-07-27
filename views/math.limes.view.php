<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo \components\language\Language::translate('math_calculation_header'); ?></h3>
    </div>
    <div class="panel-body">
        <?php if (!components\input\Input::hasGET('calculate')): ?>
            <form method="GET" action="">
                <input type="hidden" name="page" value="math" />
                <div class="input-group">
                    <input type="text" name="formula" class="form-control" placeholder="<?php echo \components\language\Language::translate('math_formula'); ?>" />
                    <span class="input-group-btn">
                        <input class="btn btn-default" type="submit" name="calculate" value="<?php echo \components\language\Language::translate('math_calculate'); ?>" />
                    </span>
                </div>
            </form>
        <?php else: ?>
        <?php
            $formula_string = str_replace(' ', '',components\input\Input::getGET('formula'));
            $formula = new components\math\Formula($formula_string);
        ?>
        <pre><?php echo $formula->getText(); ?> = <?php echo $formula->getSolution(); ?></pre>
        <pre><?php var_dump($formula); ?></pre>
        <?php endif; ?>
    </div>
</div>