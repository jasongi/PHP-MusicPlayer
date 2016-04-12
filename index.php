<!DOCTYPE html>
<?php
//debug
//ini_set('display_errors', 'On');
//error_reporting(E_ALL | E_STRICT);
?>
<?php
/* PHP MusicPlayer
/* By Jason Giancono
/* jasongi.com
/*  
    Copyright (C) 2016 Jason Giancono (jasongiancono@gmail.com)
    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.
    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.
*/

function getID3($filename)
{
    if (substr(file_get_contents($filename), -128,3) == 'TAG')
    {
        return unpack('a3TAG/a30title/a30artist/a30album/a4year/a28comment/c1genreid/c1track', substr(file_get_contents($filename), -128));
    } else {
        return false;
        
    }
}

$filelist = scandir(".");
foreach ($filelist as $key => $file) {
    if (!(strtolower(substr($file, -4)) == '.mp3' || strtolower(substr($file, -4)) == '.ogg' || strtolower(substr($file, -4)) == '.wav' || strtolower(substr($file, -5)) == '.wave')) {
        unset($filelist[$key]);
    }
}
$songs      = array();
$songs_info = array();
foreach ($filelist as $key => $file) {
    $songinf = getID3($file);
    if ( $songinf and array_key_exists('title', $songinf)) {
        $songs[str_replace("\0", "", $songinf['title'])]      = $file;
        $songs_info[str_replace("\0", "", $songinf['title'])] = $songinf;
    } else {
        $songs[$file] = $file;
    }
}

if (array_key_exists('track', $_GET)) {
    $song = urldecode($_GET["track"]);
} else {
    $song = '';
}
if (!array_key_exists($song, $songs)) {
    reset($songs);
    $song = key($songs);
}

reset($songs);
/*$backsong = key($songs);
$nextsong = key($songs);*/
$dont_exit = true;

while ((!(is_null(key($songs)))) and $dont_exit) {
    if (key($songs) == $song) {
        if (next($songs)) {
            $nextsong = key($songs);
            prev($songs);
        } else {
            reset($songs);
            $nextsong = key($songs);
            end($songs);
        }
        
        if (prev($songs)) {
            $backsong = key($songs);
        } else {
            end($songs);
            $backsong = key($songs);
        }
        reset($songs);
        $dont_exit = false;
    } else {
        next($songs);
    }
}


?>
<html align="center">
<head>
<title>
MusicPlayer - <?php
if (array_key_exists($song, $songs_info)) {
    echo $songs_info[$song]['title'] . ' - ' . $songs_info[$song]['album'] . ' - ' . $songs_info[$song]['artist'];
} else {
    echo $song;
}
?>
</Title>
<style type="text/css" scoped>
img.GeneratedImage {
width:90%; max-width:90%;height:65%; max-height:65%; margin-top:20px; width:auto;border-width:6px;border-color:#000000;border-style:solid;
}

html {
  height: 100vh;
  width: 100vw; 
  max-height: 100vh;
  max-width: 100vw;   
  margin:auto;
}
body {
  height: 100%;
  width: 100%;
  margin:auto;
}
.main {
height:100%; max-height:100%; max-width:100%; margin:auto;
}
audio{
    width:90%;
}
a
{
    font-size: 40px;
}
</style>
</head>
<body algin="center">
<?php
//debug
//print_r( array_values($songs))
//print_r( array_values($songs_info))
?>

<div align="center" class="main">
<img src="album.png" alt="Album Cover" class="GeneratedImage">
<br />


<h2><?php
if (array_key_exists($song, $songs_info)) {
    echo "Track: " . $songs_info[$song]['track'] . '<br/>Album: ' . $songs_info[$song]['album'] . '<br/>Title: ' . $songs_info[$song]['title'] . '<br/>Artist: ' . $songs_info[$song]['artist'];
} else {
    echo $song;
}
?> </h2>
<audio id="player" autoplay="autoplay" controls="controls">
<source src="<?php
echo $songs[$song];
?>" >
Your browser does not support the audio element.
</audio>
<div style="width:80%; padding-top:15px;">
<span style="text-align: right; padding-right:25%">
<a href="?track=<?php
echo urlencode($backsong);
?>">
Back
</a>
</span>

<span style="text-align: left;padding-left:25%;">
<a href="?track=<?php
echo urlencode($nextsong);
?>">
Next </a>
</span>
</div>
</div>
<script type="text/javascript">

    document.getElementById("player").onended = function(){
        // done playing
        window.location.href = 'index.php?track=<?php
echo urlencode($nextsong);
?>';
    };

</script>
</body>
</html>
