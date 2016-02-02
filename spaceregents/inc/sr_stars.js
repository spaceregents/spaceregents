function clickOnStar(evt)
{
  var its_star, new_x, new_y;
  if (evt.target)
  {
    its_star    = evt.target.correspondingUseElement;

    switch (evt.button)
    {
      // if left click, load planets
      case 0:        
        if (its_star.getAttribute("tagView") == "1") {
          if (evt.detail > 1)
            getPlanets(evt, 1);
          else
            getPlanets(evt, 0);
        }
      break;
      // if middle click, center screen on star
      case 1:
        new_x = Number(its_star.getAttribute("tagX"));
        new_y = Number(its_star.getAttribute("tagY"));
        masta.map_focus_to(new_x, new_y);
      break;
      // if right click, show commands
      case 2:
        if (masta.selectedUnits.length > 0) {
          sr_pause_animation();
          masta.generateCommands(its_star, evt.screenX, evt.screenY, "star");
        }

      break;
    }

  }
}

function mouseoverStar(evt) {
  var sid, star, sx, sy;
  if (masta.keysPressed[82]) {
    star = evt.target.getCorrespondingUseElement;
    sx = star.getAttribute("x");
    sy = star.getAttribute("y");
    showWarpRange(star.parentNode, sx, sy);
  }
}

function mouseoutStar(evt) {
  hideWarpRange();
}