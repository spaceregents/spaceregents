function sr_executeCommand(evt, command) {
  var fleetFunction;
  var i;

  switch (command) {
    case "FLEET_MOVE":
    case "FLEET_DEFEND":
    case "FLEET_ATTACK":
      fleetFunction = "move('"+getTargetType()+"')";
    break;
    case "FLEET_INVADE":
      fleetFunction = "invade('"+getTargetType()+"')";
    break;
    case "FLEET_BOMB":
      fleetFunction = "bomb('"+getTargetType()+"')";
    break;
    case "FLEET_COLONIZE":
      fleetFunction = "colonize('"+getTargetType()+"')";
    break;
  }
  sr_finalize_fleets(fleetFunction);
}
//---------------------------------------------------------------------------------

function sr_change_tactic(evt,tactic_flag)
{
  if (masta.selectedUnits[0].itemClass.fleet.tactic & tactic_flag)
    operation="masta.selectedUnits[i].itemClass.fleet.tactic&=(masta.selectedUnits[i].itemClass.fleet.tactic^tactic_flag)";
  else
    operation="masta.selectedUnits[i].itemClass.fleet.tactic|=tactic_flag";
  for (i = 0; i < masta.selectedUnits.length; i++)
  {
    eval(operation);
  }

  sr_finalize_fleets("change_tactic(\"masta.updateTacticPanel()\")");
}

function sr_finalize_fleets(fleetFunction)
{
  for (i = 0; i < masta.selectedUnits.length; i++) {
    eval("masta.selectedUnits["+i+"].itemClass.fleet."+fleetFunction);
  }

  masta.selectedUnits[0].itemClass.fleet.say("CONFIRM");
  masta.removeSelected("all");
  sr_resume_animation();
  masta.freeCommands();
}


function getTargetType() {
  var targetType = false;

  try {
    switch (masta.currentTarget.getAttribute("id").substring(0,1)) {
      case "p":
        targetType = "planet";
        break;
      case "s":
        targetType = "system";
        break;
    }
  }
  catch (e) {
    alert("Coud not find target type :(");
  }

  return targetType;
}
//---------------------------------------------------------------------------------


function is_valid_command(targetNode, command){
  var relation = targetNode.getAttribute("relation");
  var pType = targetNode.getAttribute("type");

  var mode;
  var i;

  switch (relation) {
    case "own":
    case "allied":
      mode = "defensive";
    break;
    case "friend":
    case "neutral":
      mode = "neutral";
    break;
    case "enemy":
      mode = "aggressive";
    break;
    case "none":
      mode = "none";
    break;
  }

  switch (command) {
    case "FLEET_MOVE":
      if (mode == "defensive")
        command = "FLEET_DEFEND";
      else {
        if (mode == "aggressive")
          command = "FLEET_ATTACK";
      }
    break;

    case "FLEET_COLONIZE":
      mode == "none" ? ((pType != "H" && pType != "G") ? command="FLEET_COLONIZE" : command=false) : command=false;
    break;

    case "FLEET_BOMB":
      command = false;
      if (mode == "aggressive") {
        for (i in masta.selectedUnits) {
          if (masta.selectedUnits[i].itemClass.fleet.canBomb()) {
            command = "FLEET_BOMB";
            break;
          }
        }
      }
    break;

    case "FLEET_INVADE":
      mode == "aggressive" ? command="FLEET_INVADE" : command = false;
    break;
  }

  return command;
}
//---------------------------------------------------------------------------------
