<?php
if (\components\input\Input::hasGET('summoner')):
    $api_key = \components\configuration\ConfigurationFactory::getInstance()->get('riot_api_key');
    $summoner_name = \components\input\Input::getGET('summoner');
    $summoner_name_plain = strtolower(str_replace(' ', '', $summoner_name));
    $region = \components\input\Input::getGET('region');
    $summoner_url = "https://{$region}.api.pvp.net/api/lol/{$region}/v1.4/summoner/by-name/{$summoner_name_plain}?api_key={$api_key}";
    $summoner_json_string = \components\utilites\CURL::url_get_contents($summoner_url);
    $summoner_json = components\utilites\JSON::create($summoner_json_string);
    $summoner_id = $summoner_json->{$summoner_name_plain}->{'id'};
    $summaries_url = "https://{$region}.api.pvp.net/api/lol/{$region}/v1.3/stats/by-summoner/{$summoner_id}/summary?season=SEASON2015&api_key={$api_key}";
    $summaries_json_string = \components\utilites\CURL::url_get_contents($summaries_url);
    $summaries_json = components\utilites\JSON::create($summaries_json_string);
    $recent_games_url = "https://{$region}.api.pvp.net/api/lol/{$region}/v1.3/game/by-summoner/{$summoner_id}/recent?api_key={$api_key}";
    $recent_games_json_string = \components\utilites\CURL::url_get_contents($recent_games_url);
    $recent_games_json = components\utilites\JSON::create($recent_games_json_string);
    ?>
    <div class="page-header">
        <h3><?php echo $summoner_name; ?></h3>
    </div>
    <div class="panel-group" id="summoner" role="tablist" aria-multiselectable="false">
        <div class="panel panel-default" id="summoner_data">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#summoner" href="#stats" aria-expanded="true" aria-controls="stats">
                        <?php echo components\language\Language::translate('summonerstats'); ?>
                    </a>
                </h3>
            </div>
            <div id="stats" class="panel-collapse collapse in" role="tabpanel">
                <?php
                foreach ($summaries_json->{'playerStatSummaries'} as $summary):
                    ?>
                    <a class="block" href="#<?php echo $summary->{'playerStatSummaryType'}; ?>" aria-expanded="false" aria-controls="<?php echo $summary->{'playerStatSummaryType'}; ?>" role="button"  data-toggle="collapse" data-parent="#parent_<?php echo $summary->{'playerStatSummaryType'}; ?>">
                        <?php echo components\language\Language::translate($summary->{'playerStatSummaryType'}); ?>
                    </a>
                    <div  id="<?php echo $summary->{'playerStatSummaryType'}; ?>" class="collapse">
                        <table class="table table-bordered table-condensed table-league-data">
                            <thead>
                                <tr>
                                    <th><?php echo \components\language\Language::translate('table_key'); ?></th>
                                    <th><?php echo \components\language\Language::translate('table_value'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($summary->{'aggregatedStats'} as $key => $value):
                                    ?>
                                    <tr>
                                        <td><?php echo components\language\Language::translate($key); ?></td>
                                        <td><?php echo $value; ?></td>
                                    </tr>
                                    <?php
                                endforeach;
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <?php
                endforeach;
                ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#summoner" href="#recent" aria-expanded="false" aria-controls="recent" id="recent_heading">
                        <?php echo components\language\Language::translate('recent_games'); ?>
                    </a>
                </h3>
            </div>
            <div id="recent" class="panel-collapse collapse" role="tabpanel" aria-labelledby="recent_heading">
                <?php foreach ($recent_games_json->{'games'} as $game): ?>
                    <table class="table table-bordered table-condensed table-league-data" id="<?php echo $game->{'gameId'}; ?>">
                        <caption><?php echo $game->{'gameMode'}; ?></caption>
                        <thead>
                            <tr>
                                <th><?php echo \components\language\Language::translate('table_key'); ?></th>
                                <th><?php echo \components\language\Language::translate('table_value'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($game as $key => $value): ?>
                                <?php if (is_string($value)): ?>
                                    <tr>
                                        <td><?php echo components\language\Language::translate($key); ?></td>
                                        <td><?php echo $value; ?></td>
                                    </tr>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php
else:
    ?>
    <div class="page-header">
        <h3>League of Legends</h3>
    </div>
    <form method="GET" action="?page=league">
        <div class="input-group input-group-league">
            <span class="input-group-btn">
                <select class="btn btn-default" name="region">
                    <option value="euw" selected>EUW</option>
                    <option value="na">NA</option>
                </select>
            </span>
            <input type="text" class="form-control" name="summoner" placeholder="Summoner name">
            <span class="input-group-btn">
                <input class="btn btn-default" type="submit" value="Go!" />
            </span>
        </div>
        <input type="hidden" name="page" value="league" />
    </form>
<?php
endif;
?>
<div class="panel panel-default" >
    <div class="panel-heading">
        <h3 class="panel-title"><?php echo components\language\Language::translate('disclaimer_title'); ?></h3>
    </div>
    <div class="panel-body">
        <?php echo components\language\Language::translate('disclaimer_text'); ?>
    </div>
</div>