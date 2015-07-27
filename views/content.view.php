<div class="page container-fluid col-xs-12 col-md-8 col-md-offset-2">
    <?php
        $page = \components\input\Input::getGET('page', 'home');
        echo \extensions\pages\PageFactory::get($page);
    ?>
</div>