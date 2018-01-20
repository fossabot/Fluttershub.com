<?php
#Uses SteamAPI to retrieve profile picture currently on steam and set it on website
require_once("inc/config.php");
$json = file_get_contents("https://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=$STEAMAPIKEY&steamids=$STEAMID");
$parsed = json_decode($json);

foreach($parsed->response->players as $player){
    $ProfilePic = $player->avatarfull;
}
?>
    <?php #Caching is a bad idea for Pinging ?>
    <meta http-equiv="cache-control" content="max-age=0" />
    <meta http-equiv="cache-control" content="no-cache" />
    <meta http-equiv="expires" content="0" />
    <meta http-equiv="expires" content="Tue, 01 Jan 1980 1:00:00 GMT" />
    <meta http-equiv="pragma" content="no-cache" />

    <?php #Here's where the OGP magic begins ?>

    <!doctype html>
    <html>
    <head prefix="og: http://ogp.me/ns#">
        <meta charset="UTF-8">
        <title>Flutters Homepage</title>
        <?php #Extra files/Extensions ?>
        <link rel="stylesheet" href="css/site.css">
        <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet"> 

        <meta property="og:title" content="Welcome to Fluttershub.xyz">
        <meta property="og:type"content="website">
        <meta property="og:url" content="http://www.fluttershub.xyz/">
        <meta property="og:image" content="<?php echo $ProfilePic ?>">
        <meta property="og:image:type" content="image/jpg">
        <meta property="og:image:width" content="184">
        <meta property="og:image:height" content="184">
        <meta property="og:locale" content="en_GB">
        <meta property="og:locale:alternate" content="en_US"> 
        <meta property="og:site_name" content="www.fluttershub.xyz">
        <meta property="og:description" content="To view my current online status, Goto the website above!">
    </head>
    <body>
        <site>
            <header><img src="<?php echo $ProfilePic ?>" height="153" width="153"></header>
            <desc> Welcome to Fluttershub.xyz </desc>
            <links>
                <a href="http://steamcommunity.com/id/MrFlutters/" target="_blank"><img src="img/s_icon.png" height="32" width="32"> Steam </a>
                <a><img src="img/d_icon.png" height="32" width="32"> Flutters#5192 </a>
                <a href="https://twitter.com/MrFlutters" target="_blank"><img src="img/t_icon.png" height="32" width="32"> Twitter </a>
                <a href="https://www.reddit.com/user/MrFlutters/" target="_blank"><img src="img/r_icon.png" height="32" width="32"> Reddit </a>
                <a href="https://www.youtube.com/channel/UCCQ5PkU7kyD2yi6xEocKCRw" target="_blank"><img src="img/y_icon.png" height="32" width="32"> Youtube </a>
            </links>
        </site>
    </body>

    </html>