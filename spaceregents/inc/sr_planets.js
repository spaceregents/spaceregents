function clickOnPlanet(evt) {
  if (evt.target) {
    var planetId = new String(evt.target.parentNode.id.substr(1));
    var eventType = "clickOnPlanet";
    var i;
    var itemBoxInCache;
    var newPlanetMarker;
    var oldPlanet;
    var mouseButton = evt.button;
    var planetX = Number(evt.target.parentNode.getElementsByTagName("circle").item(0).getAttribute("cx"));
    var planetY = Number(evt.target.parentNode.getElementsByTagName("circle").item(0).getAttribute("cy"));

    // unterscheiden zwischen rechtem und linken mausclick
    switch (mouseButton)
    {
      case 0:
        // ItemBox oeffnen
        if (masta.itemBox) {
          if (masta.itemBox.oid == String(planetId) && masta.itemBox.caller == "planet") {
            // do nothing yet
          }
          else {
            itemBoxInCache = masta.cache.getObject("itemBox",planetId, "planet");
            if (itemBoxInCache)
            {
              masta.itemBox = itemBoxInCache;
              updateStatusText("Object Found");
              masta.itemBox.show();
            }
            else
            {
              createLoadingAnimation(0,0);
              getURL("map_getdata.php?act="+eventType+"&pid="+planetId, masta.itemBox = new ITEMBOX(eventType, planetId, "planet"));
            }
          }
        }
        else {
          createLoadingAnimation(0,0);
          getURL("map_getdata.php?act="+eventType+"&pid="+planetId, masta.itemBox = new ITEMBOX(eventType, planetId, "planet"));
        }

        // Planet markieren
        if (Number(planetId) != masta.getCurrentPlanet()) {
          // alten planeten marker entfernen
          if (masta.getCurrentPlanet()) {
            oldPlanet = pSvgDoc.getElementById("p"+masta.getCurrentPlanet());
            if (oldPlanet)
              oldPlanet.removeChild(oldPlanet.lastChild);
          }

          masta.setCurrentPlanet(planetId);
          newPlanetMarker = sr_create_use("sPlanetMarker", planetX, planetY);
          newPlanetMarker.setAttribute("pointer-events","none");
          evt.target.parentNode.appendChild(newPlanetMarker);
        }
      break;
      case 2:
        // stop animation
        if (masta.selectedUnits.length > 0) {
          sr_pause_animation();
          masta.generateCommands(evt.target.parentNode, evt.screenX, evt.screenY);
        }
      break;
    }
  }
}


function showPlanetInfo(evt, pid, w_name)
{
  if (evt.button == 0 && evt.detail == 1) {
    var w_width = 357;
    var w_height= 400;
    var pInfo;
    var exists = masta.findWindowByTag("planet_"+pid);
    var my_planet = masta.cache.getPlanet(pid);

    if (masta.windows[exists])
      masta.windows[exists].bringToFront();
    else {
      pInfo = new SR_CLASS_WINDOW(masta.windows.length, (window.innerWidth / 2) - (w_width / 2), (window.innerHeight / 2) - (w_height / 2), w_width, w_height, "Planet : "+w_name, false, true);
      pInfo.setTag("planet_"+pid);

      if (!my_planet) {
        createLoadingAnimation();
        getURL("map_getdata.php?act=clickOnGetPlanetInfo&pid="+pid, pInfo);
      }
      else {
        createLoadingAnimation();
        getURL("map_getdata.php?act=getPlanetInfoProduction&pid="+pid, pInfo);
      }
    }
  }
}


function createPlanet(requestXML) {
  var plaTag = requestXML.getElementsByTagName("SR_PLANET").item(0);
  var resTag = requestXML.getElementsByTagName("SR_RESOURCES").item(0);
  var useTag = requestXML.getElementsByTagName("SR_USER");
  var pbuTag = requestXML.getElementsByTagName("SR_P_BUILD");
  var obuTag = requestXML.getElementsByTagName("SR_O_BUILD");

  var pid    = Number(plaTag.getAttribute("pid"));
  var user, i;

  its_planet = new SR_CLASS_PLANET(pid);
  its_planet.setResources(resTag.getAttribute("m"),resTag.getAttribute("e"),resTag.getAttribute("o"),resTag.getAttribute("r"),resTag.getAttribute("g"),resTag.getAttribute("s"));
  its_planet.setClassMember("population", Number(plaTag.getAttribute("population")));
  its_planet.setClassMember("popgain", Number(resTag.getAttribute("popgain")));
  its_planet.setPType(plaTag.getAttribute("type"));

  if (useTag.length > 0) {
    useTag = useTag.item(0);

    user = new SR_CLASS_USER(Number(useTag.getAttribute("uid")),useTag.getAttribute("name"), useTag.getAttribute("empire"), useTag.getAttribute("relation"));

    if (useTag.getAttribute("alliance"))
      user.setAlliance(useTag.getAttribute("alliance"), useTag.getAttribute("allianceColor"), useTag.getAttribute("allianceSymbol"));

    its_planet.setUser(user);
  }

  // planetare gebaeude
  if (pbuTag.length > 0) {
    var pBuildings = new Array();
    for (i = 0; i  < pbuTag.length; i++)
      pBuildings[i] = pbuTag.item(i).getAttribute("prod_id");

    its_planet.setBuildings("P", pBuildings);
  }

  // orbital gebaeude
  if (obuTag.length > 0) {
    var oBuildings = new Array();
    for (i = 0; i  < obuTag.length; i++)
      oBuildings[i] = obuTag.item(i).getAttribute("prod_id");
    its_planet.setBuildings("O", oBuildings);
  }

  updatePlanetsProduction(its_planet, requestXML);

  return its_planet;
}

function updatePlanetsProduction(its_planet, requestXML) {
  var pprTag = requestXML.getElementsByTagName("SR_P_PROD");
  var oprTag = requestXML.getElementsByTagName("SR_O_PROD");
  var sprTag = requestXML.getElementsByTagName("SR_S_PROD");
  var iprTag = requestXML.getElementsByTagName("SR_I_PROD");
  var i, prod;

  its_planet.resetProduction();


  // planetare Produktion
  if (pprTag.length > 0) {
    for (i = 0; i < pprTag.length; i++) {
      prod = new SR_CLASS_PRODUCTION(pprTag.item(i).getAttribute("prod_id"),pprTag.item(i).getAttribute("time"),pprTag.item(i).getAttribute("comtime"));
      its_planet.addProduction("P",prod);
    }
  }

  // orbitale Produktion
  if (oprTag.length > 0) {
    for (i = 0; i < oprTag.length; i++) {
      prod = new SR_CLASS_PRODUCTION(oprTag.item(i).getAttribute("prod_id"),oprTag.item(i).getAttribute("time"),oprTag.item(i).getAttribute("comtime"));
      its_planet.addProduction("O",prod);
    }
  }

  // schiff Produktion
  if (sprTag.length > 0) {
    for (i = 0; i < sprTag.length; i++) {
      prod = new SR_CLASS_PRODUCTION(sprTag.item(i).getAttribute("prod_id"),sprTag.item(i).getAttribute("time"),sprTag.item(i).getAttribute("comtime"));
      prod.setCount(Number(sprTag.item(i).getAttribute("count")));
      its_planet.addProduction("S",prod);
    }
  }

  // infantrie Produktion
  if (iprTag.length > 0) {
    for (i = 0; i < iprTag.length; i++) {
      prod = new SR_CLASS_PRODUCTION(iprTag.item(i).getAttribute("prod_id"),iprTag.item(i).getAttribute("time"),iprTag.item(i).getAttribute("comtime"));
      prod.setCount(Number(iprTag.item(i).getAttribute("count")));
      its_planet.addProduction("I",prod);
    }
  }
}


function createPlanetInfoDialog(window, planet) {
    var w_width = window.width;
    var w_height = window.height;
    var pChilds = new Array();
    var temp;
    var i = -1;
    var rX = 10;
    var rY = 245;
    var container = sr_create_element("g");
    var popgain;
    var z, u = 0;
    var p_switchPage = false;


    pChilds[++i] = sr_create_image(planet.getPic(), 10, 9, 80, 80);
    pChilds[++i] = sr_create_rect(5, 105, 90, 120, "mapGUIWindowTextBoxRect", 5, 5);

    if (planet.user) {
      // owner
      pChilds[++i] = sr_create_text("Owner:", 50, 120, "mapDialogTextSmall2");
      pChilds[++i] = sr_create_flow_text_region_def(4, 122, 95, 25, "window_"+window.windowNo+"_owner_region");
      pChilds[++i] = sr_create_flow_text(Array(planet.user.name), "window_"+window.windowNo+"_owner_region", "mapGUITopic");
      // empire
      pChilds[++i] = sr_create_text("Empire:", 50, 150, "mapDialogTextSmall2");
      pChilds[++i] = sr_create_flow_text_region_def(4, 152, 95, 25, "window_"+window.windowNo+"_empire_region");
      pChilds[++i] = sr_create_flow_text(Array(planet.user.empire), "window_"+window.windowNo+"_empire_region", "mapGUITopic");

      // alliance
      if (planet.user.aName) {
        pChilds[++i] = sr_create_text("Alliance:", 50, 190, "mapDialogTextSmall2");
        pChilds[++i] = sr_create_flow_text_region_def(4, 192, 95, 25, "window_"+window.windowNo+"_alliance_region");
        pChilds[++i] = sr_create_flow_text(Array(planet.user.aName), "window_"+window.windowNo+"_alliance_region", "mapGUITopic");

        pChilds[++i] = sr_create_circle(17, 80, 15);
        pChilds[i]   = sr_add_status_text(pChilds[i], planet.user.aName);
        pChilds[i].setAttribute("style","fill:black;stroke:"+planet.user.aColor+";stroke-width:2pt;");

        if (planet.user.aSymbol) {
          pChilds[++i] = sr_create_clippath(pChilds[i-1], "pSymb_"+planet.id);
          pChilds[++i] = sr_create_image(planet.user.aSymbol, 3, 66, 28, 28);
          pChilds[i].setAttribute("pointer-events","none");
          pChilds[i].setAttribute("clip-path","url(#pSymb_"+planet.id+")");
        }
      }
    }


    if (planet.resources) {
      pChilds[++i] = sr_create_rect(5, 230, 90, 115, "mapGUIWindowTextBoxRect", 5, 5);
      pChilds[++i] = sr_create_text("Resources:", 50, 240, "mapDialogTextSmall2");

      if (planet.resources.metal) {
        pChilds[++i] = sr_create_image("arts/metal.gif", rX, rY, 13, 20);
        pChilds[i]   = sr_add_status_text(pChilds[i],"Metal");
        pChilds[++i] = sr_create_text(planet.resources.metal, rX + 30, rY+15, "mapGUITopic");
        rY += 30;
      }

      if (planet.resources.energy) {
        pChilds[++i] = sr_create_image("arts/energy.gif", rX, rY, 13, 20);
        pChilds[i]   = sr_add_status_text(pChilds[i],"Energy");
        pChilds[++i] = sr_create_text(planet.resources.energy, rX + 30, rY+15, "mapGUITopic");
        rY += 30;
      }

      if (planet.resources.mopgas) {
        pChilds[++i] = sr_create_image("arts/mopgas.gif", rX, rY, 13, 20);
        pChilds[i]   = sr_add_status_text(pChilds[i],"Mopgas");
        pChilds[++i] = sr_create_text(planet.resources.mopgas, rX + 30, rY+15, "mapGUITopic");
        rY += 30;
      }

      if (planet.resources.erkunum) {
        pChilds[++i] = sr_create_image("arts/erkunum.gif", rX, rY, 15, 20);
        pChilds[i]   = sr_add_status_text(pChilds[i],"Erkunum");
        pChilds[++i] = sr_create_text(planet.resources.erkunum, rX + 30, rY+15, "mapGUITopic");
        rY += 30;
      }

      if (planet.resources.gortium) {
        pChilds[++i] = sr_create_image("arts/gortium.gif", rX, rY, 13, 20);
        pChilds[i]   = sr_add_status_text(pChilds[i],"Gortium");
        pChilds[++i] = sr_create_text(planet.resources.gortium, rX + 30, rY+15, "mapGUITopic");
        rY += 30;
      }

      if (planet.resources.susebloom) {
        pChilds[++i] = sr_create_image("arts/susebloom.gif", rX, rY, 18, 20);
        pChilds[i]   = sr_add_status_text(pChilds[i],"Susebloom");
        pChilds[++i] = sr_create_text(planet.resources.susebloom, rX + 30, rY+15, "mapGUITopic");
        rY += 30;
      }
    }


    pChilds[++i] = sr_create_rect(5, 350, 90, 45, "mapGUIWindowTextBoxRect", 5, 5);
    pChilds[++i] = sr_create_image("arts/colonists.png", rX, 355, 19, 19);
    pChilds[i]   = sr_add_status_text(pChilds[i],"Population");

    if (planet.popgain)
      pChilds[++i] = sr_create_text(planet.popgain, rX+30, 370, "mapGUITopic");

    if (planet.population)
      pChilds[++i] = sr_create_text(planet.getPopulation(), 50, 385, "mapGUITopic");
    else
      pChilds[++i] = sr_create_text("unknown", 50, w_height - 10, "mapGUITopic");


    if (!(planet.pBuildings || planet.oBuildings || planet.pProduction || planet.oProduction || planet.sProduction || planet.iProduction)) {
      if (planet.user.relation != "same" && planet.user.relation != "allie")
        pChilds[++i] = sr_create_image("arts/no_scan.svgz", 120, 100, 200, 200);
    }
    else {

      p_switchPage = new SR_CLASS_SWITCH_PAGE(window, 110, 10, window.width - 117, window.height - 45);
      p_switchPage.generate();


      // production and buildings

      // planetar production + buildings
      if (planet.pBuildings || planet.pProduction)
      {
        var planetars;

        if (planet.pProduction && planet.pBuildings)
          planetars = planet.pProduction.concat(planet.pBuildings);
        else
        {
          if (planet.pBuildings)
            planetars = planet.pBuildings;
          else
            planetars = planet.pProduction;
        }

        var page = createPlanetInfoPage(planet, "plInfo"+planet.id+"_planetar", 0, p_switchPage, 0, 43, window.width - 117, window.height - 45, planetars);
        p_switchPage.addPage("arts/planetar_production.svgz","Planetar construction", page);
      }

      // orbitale production + buildings
      if (planet.oBuildings || planet.oProduction)
      {
        var orbitals;

        if (planet.oProduction && planet.oBuildings)
          orbitals = planet.oProduction.concat(planet.oBuildings);
        else
        {
          if (planet.oBuildings)
            orbitals = planet.oBuildings;
          else
            orbitals = planet.oProduction;
        }

        var page = createPlanetInfoPage(planet, "plInfo"+planet.id+"_orbital", 1, p_switchPage, 0, 43, window.width - 117, window.height - 45, orbitals);
        p_switchPage.addPage("arts/orbital_production.svgz","Orbital construction", page);
      }

      // ship production
      if (planet.sProduction)
      {
        var page = createPlanetInfoPage(planet, "plInfo"+planet.id+"_ships", 2, p_switchPage, 0, 43, window.width - 117, window.height - 45, planet.sProduction);
        p_switchPage.addPage("button_face_ship","Ship Production", page);
      }

      // infanterie production
      if (planet.iProduction)
      {
        var page = createPlanetInfoPage(planet, "plInfo"+planet.id+"_inf", 3, p_switchPage, 0, 43, window.width - 117, window.height - 45, planet.iProduction);
        p_switchPage.addPage("button_face_infantry","Infantry Production", page);
      }

      p_switchPage.showPage(0);           // die erste page anzeigen
      p_switchPage.buttons[0].focus();    // der erste button sollte bereits ausgeweahlt sein
    }

    container = sr_append_child_nodes(container, pChilds);
    window.generate();
    window.addRawContent(sr_create_image("arts/planet_dialog_bg.svgz",0,0,357,400));
    window.addRawContent(container);
    window.updateTitle(window.title+" ("+planet.getPlanetType(true)+" Class)");

    if (p_switchPage)
      window.addComponent(p_switchPage, true);

    masta.addWindow(window);
}

function createPlanetInfoListElement(pos, flowDefId, its_image, its_name, availWidth, progress, time, com_time) {
  var listElement = new Array();

  listElement[0] = pos;
  listElement[1] = sr_create_image(its_image,1,1,50,50);
  listElement[2] = sr_create_flow_text_region_def(55, 1, availWidth - 5, 32, flowDefId);
  listElement[3] = sr_create_flow_text(Array(its_name),flowDefId, "mapDialogText2")

  if (typeof(progress) != "boolean") {
    listElement[4] = sr_create_text(time+"/"+com_time+masta.zeitEinheit+" left",55,35,"mapDialogText2")
    listElement[5] = sr_create_static_progress_bar(55,40,availWidth - 5,progress, (progress*100).toFixed(2)+"% completed");
  }

  return listElement;
}

function createPlanetInfoPage(planet, cElementId, pageNo, switchPage, x, y, width, height, dataArray)
{
  var listElementArray = new Array();
  var page, list;
  var i = 0;
  var j = 0;
  var flowDefId, image, topic, progress, time, com_time;

  page = new SR_CLASS_PAGE(pageNo, switchPage, cElementId, x, y, width, height);
  page.generate();

  masta.addContainer(cElementId, page);

  for (i in dataArray) {
    flowDefId = cElementId+"_"+j;

    // bild
    if (dataArray[i].prod_id) {
      image = __prodInfo[dataArray[i].prod_id].getImage();
      topic = __prodInfo[dataArray[i].prod_id].name;
      progress  = dataArray[i].getPercent();
      time      = dataArray[i].time;
      com_time  = dataArray[i].com_time;

      if (dataArray[i].count)
        topic += " #"+dataArray[i].count;
    }
    else {
      image = __prodInfo[dataArray[i]].getImage();
      topic = __prodInfo[dataArray[i]].name;
      progress = time = com_time = false;
    }

    listElementArray[j] = createPlanetInfoListElement(j, flowDefId, image, topic, width - 90, progress, time, com_time);
    j++;
  }

  list = new SR_CLASS_LIST(page, planet, 3, 3, width - 30, height - 5, listElementArray);
  list.setClassMember("itemHeight", 60);
  list.generate();

  page.addList(list);
  page.updateScrollbar();

  return page;
}
