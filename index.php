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
<?php
#Setup OGP array for l8r
$ogp = "<meta property=\"og:image:secure_url\" content=\"";
    $ogp .= $ProfilePic;
    $ogp .= "\">\n<meta property=\"og:image\" content=\"";
    $ProfilePicNonHTTPS = str_replace("https://","http://",$ProfilePic);
    $ogp .= $ProfilePicNonHTTPS;
    $ogp .= "\">";
$ogp_type = "";

if(substr($ProfilePic, -4) == ".jpg"){
    $ogp_type = "image/jpeg";
}elseif(substr($ProfilePic, -4) == ".png"){
    $ogp_type = "image/png";
}

$ogp_desc = "Flutters is currently ";
if ($_SESSION['FluttersOnline'] == true){
    $ogp_desc .= "Online";
}else{
    $ogp_desc .= "Offline";
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
    <head>
        <meta charset="UTF-8">
        <title>Flutters Homepage</title>
        <?php #Extra files/Extensions ?>
        <link rel="stylesheet" href="css/site.css">
        <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
        <meta property="og:title" content="Fluttershub">
        <meta property="og:site_name" content="Fluttershub.xyz">
        <?php echo $ogp; ?>
        <meta property="og:image:type" content="<?php echo $ogp_type ?>">
        <meta property="og:image:width" content="184">
        <meta property="og:image:height" content="184">
        <meta property="og:description" content="<?php echo $ogp_desc ?>">
        <meta property="og:locale" content="en_GB">
        <meta property="og:locale:alternate" content="en_US"> 
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