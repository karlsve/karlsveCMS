<div class="panel">
    <div class="panel-heading">
        <h3 class="panel-title">OGame</h3>
    </div>
    <div class="panel-body">
        <?php if (!components\input\Input::hasGET('find_player')): ?>
            <p><?php echo components\language\Language::translate("find_player_info"); ?></p>
            <form class="input-group" target="">
                <input type="text" class="form-control" name="player" placeholder="<?php echo components\language\Language::translate("player_search_placeholder"); ?>" />
                <span class="input-group-btn">
                    <input type="submit" class="btn btn-default" name="find_player" value="<?php echo components\language\Language::translate("player_search_button"); ?>" />
                </span>
                <input type="hidden" name="page" value="ogame" />
            </form>
        <?php else: ?>
            <?php
            $player_name = components\input\Input::getGET('player');
            $universe_api = extensions\ogame\OGameAPI::getAPI('universes');
            ?>    
            <pre><?php echo \components\utilites\Prettify::dump($universe_api, true); ?></pre>
        <?php endif; ?>
    </div>
</div>