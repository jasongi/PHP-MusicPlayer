# PHP MusicPlayer - By Jason Giancono
PHP MusicPlayer is exactly what it sounds like. A music player - written in PHP! See it in action [here](http://jasongi.com/trash/musicplayer). (note: I got really old public domain music for the demo which doesn't have any artist data, hence why it doesn't show!)

## Requirements
You need to have a web server with PHP installed. On the client side, you need a web broswer that is HTML5 compatible so it can read the <audio> tags.

## What is this for?
Let's say you're in a band and your album is about to drop - but you have no way to stream your music. PHP MusicPlayer can be set up in seconds! Seriously though, I made this as an easy way to share tracks with people without having to use soundcloud or dropbox etc.

Seriously though - the use-cases for this are fairly limited, and I haven't exactly put too much effort into the look/interface of the script. I know styling is supposed to be done in the CSS file, etc etc, but the point of this project was to make something as simple as possible, and having multiple files makes setting it up more complicated.

## Installation Instructions
To install, simply copy the index.php into a directory on your web server that has music files in it (mp3, wav or ogg). Drop in your album art with the filename album.png to have it come up. It is that simple - no customisation or config file fiddling needed.

## How it works
PHP MusicPlayer is extremely simple and low-fi. It scans the directory for files, and then sees if those files have any ID3 tags. If they do it shows the general ID3 information (track, title, artist and album), if they don't it will just show the filename. It sorts by filename - which means the songs should be in album order for most namings as usually the track number is the first thing in the title - obviously not all music is like this, if you want it to be in album order then name your files that way. For each track, it provides a next and back button. Track names are passed via a GET parameter meaning you can link to any track. The music itself is played via HTML5 <audio> tags, super simple!