<?php
#Pinging my Pc to check if its live(simple ping website designed to ping back)
$host = 'mrflutterspc.ddns.net';
$ch = curl_init($host);
curl_setopt($ch, CURLOPT_TIMEOUT, 5);
curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$data = curl_exec($ch);
$httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if($httpcode>=200 && $httpcode<300){
    $_SESSION['FluttersOnline'] = true;
}else{
    $_SESSION['FluttersOnline'] = false;
}
?>
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

        <meta content="Fluttershub" property="og:title">
        <meta content="Welcome to my website" property="og:description">
        <meta content="image" property="og:type">
        <meta content="http://www.fluttershub.xyz" property="og:url">
        <meta content="<?php echo $ProfilePic ?>" property="og:image">
        <meta content="184" property="og:image:width">
        <meta content="184" property="og:image:height">
        <meta content="en_GB" property="og:locale">
        <meta content="en_US" property="og:locale:alternate"> 
    </head>
    <body>
        <site>
            <header><img src="<?php echo $ProfilePic ?>" height="153" width="153"></header>
            <desc> Welcome to Fluttershub.xyz </desc>
            <status>
                <?php 
                if ($_SESSION['FluttersOnline'] == true) {
                    echo '<div> Flutters is currently <span style="color: #32CD32">Online<span></div>';
                }
                else{
                    echo '<div> Flutters is currently <span style="color: #DC143C">Offline<span></div>';
                }
                ?>
            </status>
            <links>
                <a href="http://steamcommunity.com/id/MrFlutters/" target="_blank"><img src="img/steam_icon.png" height="32" width="32"> Steam </a>
                <a><img src="img/discord_icon.png" height="32" width="32"> Flutters#5192 </a>
                <a href="https://twitter.com/MrFlutters" target="_blank"><img src="img/twitter_icon.png" height="32" width="32"> Twitter </a>
                <a href="https://www.reddit.com/user/MrFlutters/" target="_blank"><img src="img/reddit_icon.png" height="32" width="32"> Reddit </a>
                <a href="https://www.youtube.com/channel/UCCQ5PkU7kyD2yi6xEocKCRw" target="_blank"><img src="img/youtube_icon.png" height="32" width="32"> Youtube </a>
            </links>
        </site>
    </body>

    </html>