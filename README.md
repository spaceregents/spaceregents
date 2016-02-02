# SPACEREGENTS

An online 4x strategy game.

## Disclaimer

**WARNING**

This was written in the early 2000s (somewhen 2000-2006 i think). We were young and had no real idea what we are doing but something was happening (woahhhh). It is a huge pile of security bugs. DO NOT PUT IT ON AN OPEN WEBSERVER.

It is intended for educational (how not to do it) use only :)

What it looked like:

http://www.onlinegamesinn.com/showgame/1823/Space%20Regents/

## Technology stack

This was written (I think!) using the first alphas/betas of mysql 4.1 and php 5. The map was using some crazy technology called SVG in a time when flash was non plus ultra. Back in the days browser had no SVG support built in (mozilla was working on it - webkit didn't even exist). So we used the Adobe SVG Viewer Preview 6 (!) browser plugin (IE only).

From what I remember SVG 1.1 was on its way and Adobe SVG Viewer had HUGE support for most features. It was totally awesome. What is now hip was already possible back then :) With slight adjustments it should be possible to display it in a modern browser now.

## Directory structure

- spaceregents (public_root / "main" web scripts)
- spaceregentsinc (includes)
- spaceregentsconf (config)
- spaceregentsbin (console scripts)
- spaceregentsportal (portal - optional this is the last thing we wrote I think)
- spaceregentssql (database files)

We had special permission to use some classes from my work back then. Nothing fancy. Just a db wrapper, session support stuff and some crud stuff in later versions. For obvious reasons they are not part of the source code. I don't even have them locally. They are lost. I have started to reimplement the first methods as hacky as I could but there is lots of work to do to make them work again.

## Setting it up

I have started to set it back up. You need

- php+mysql
- short_open_tags On (php.ini)
- create a database and load spacerents-master.dump
- point your webserver to use spaceregents as DOCROOT

Fire up your webbrowser. Fail at login. Start to reverse engineer :)

## Authors

### Programming
- Erik Oey
- Andreas Streichardt (@m0ppers)
- Janne Vehreschild

### Additional (the ones looking professional) Graphics
- t0xic
- lucius