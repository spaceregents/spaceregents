//---------------------------------------------------------------------------------------------------------------
//        LOADING ANIMATION
//---------------------------------------------------------------------------------------------------------------
/*********
 *  createLoadingAnimation()
 *********/
function createLoadingAnimation(x, y) {
    if (x == 0) x = 20;
    if (y == 0) y = 60;

    id = "loadingAnimation";

    if (animation = pSvgDoc.getElementById(id)) {
        animation.setAttribute("transform", "translate(" + x + "," + y + ")");
        animation.setAttribute("display", "inherit");
    }
    else {
        speed = "100ms";
        speed2 = "400ms";
        farbe1 = "black";     // Hintergrundfarbe
        farbe2 = "white";        // Highlightfarbe

        pathObj = new Array();
        animObj = new Array();
        animObj2 = new Array();

        path = new Array();
        path[0] = "M84.535,13.572C76.144,5.919,65.147,1.078,53.032,0.523v16.714c7.512,0.515,14.34,3.499,19.684,8.153L84.535,13.572z";
        path[1] = "M84.167,48.369h16.711c-0.559-12.114-5.397-23.11-13.05-31.5L76.011,28.685C80.665,34.031,83.65,40.859,84.167,48.369z";
        path[2] = "M76.013,72.718l11.816,11.818c7.653-8.392,12.491-19.39,13.05-31.503H84.167C83.65,60.544,80.665,67.373,76.013,72.718z";
        path[3] = "M53.032,84.167v16.711c12.115-0.553,23.112-5.393,31.503-13.046L72.716,76.015C67.372,80.665,60.544,83.651,53.032,84.167z";
        path[4] = "M16.865,87.832c8.392,7.653,19.387,12.493,31.505,13.046V84.167c-7.512-0.516-14.341-3.501-19.686-8.152L16.865,87.832z";
        path[5] = "M17.235,53.033H0.523C1.077,65.146,5.917,76.145,13.57,84.536l11.82-11.818C20.74,67.373,17.752,60.544,17.235,53.033z";
        path[6] = "M25.391,28.688L13.57,16.869c-7.654,8.39-12.493,19.387-13.047,31.5h16.712C17.752,40.861,20.74,34.031,25.391,28.688z";
        path[7] = "M28.685,25.391c5.345-4.651,12.174-7.639,19.686-8.153V0.525C36.252,1.078,25.257,5.919,16.865,13.572L28.685,25.391z";

        // Animations Gruppe
        newObj0 = pSvgDoc.createElement("g");
        newObj0.setAttribute("id", id);
        newObj0.setAttribute("style", "stroke:none;fill:" + farbe1 + ";");
        newObj0.setAttribute("transform", "translate(" + x + "," + y + ")");

        // erstes Bild
        newObj1 = sr_create_image("arts/loadingAnimationBackground.png", 1, 1, 100, 100);

        // zweites Bild
        newObj2 = sr_create_image("arts/loadingAnimationForeground.png", 3, 30, 96, 41);

        // Paths
        for (i = 0; i < path.length; i++) {
            pathObj[i] = pSvgDoc.createElement("path");
            pathObj[i].setAttribute("d", path[i]);
            animObj[i] = pSvgDoc.createElement("set");
            animObj[i].setAttribute("attributeType", "CSS");
            animObj[i].setAttribute("attributeName", "fill");
            animObj[i].setAttribute("to", farbe2);
            animObj[i].setAttribute("dur", speed);
            animObj[i].setAttribute("id", "anim_loading_" + i);
            animObj[i].setAttribute("restart", "whenNotActive");
            animObj[i].setAttribute("repeatCount", "0");

            if (i == 0)
                animObj[i].setAttribute("begin", "anim_loading_" + ((path.length) - 1) + ".end;0s");
            else
                animObj[i].setAttribute("begin", "anim_loading_" + (i - 1) + ".end");

            animObj2[i] = pSvgDoc.createElement("animateColor");
            animObj2[i].setAttribute("attributeType", "CSS");
            animObj2[i].setAttribute("attributeName", "fill");
            animObj2[i].setAttribute("from", farbe2);
            animObj2[i].setAttribute("to", farbe1);
            animObj2[i].setAttribute("dur", speed2);
            animObj2[i].setAttribute("restart", "whenNotActive");
            animObj2[i].setAttribute("repeatCount", "0");
            animObj2[i].setAttribute("begin", "anim_loading_" + (i) + ".end");
        }

        newObj0.appendChild(newObj1);
        for (i = 0; i < path.length; i++) {
            pathObj[i].appendChild(animObj[i])
            pathObj[i].appendChild(animObj2[i])
            newObj0.appendChild(pathObj[i]);
        }
        newObj0.appendChild(newObj2);
        pSvg.appendChild(newObj0);
    }
}

function destroyLoadingAnimation() {
    its_id = "loadingAnimation";

    if (animation = pSvgDoc.getElementById(its_id))
        animation.setAttribute("display", "none");
}

/*********
 *  createLoadingText(text, x, y)
 *********/
function createLoadingText(text, x, y) {
    font = "verdana, arial";
    fontsize = "12pt";
    farbe = "white";
    id = "loadingText";
    letter_sp = "1pt";


    if (text != 0) {
        if (pSvgDoc.getElementById(id)) {
            animationText = pSvgDoc.getElementById(id).firstChild.firstChild;
            animationText.data = text;
        }
        else {
            newObj0 = pSvgDoc.createElement("g");
            newObj0.setAttribute("id", id);
            newObj0.setAttribute("style", "stroke:none;fill:" + farbe + ";font-family:" + font + ";font-size:" + farbe + ";letter-spacing:" + letter_sp);
            newObj0.setAttribute("transform", "translate(" + x + "," + y + ")");

            newObj1 = pSvgDoc.createElement("text");
            newObj1.setAttribute("text-anchor", "middle");
            newObj1.setAttribute("x", 0);
            newObj1.setAttribute("y", 0);

            newObj2 = pSvgDoc.createTextNode(text);

            newObj1.appendChild(newObj2);
            newObj0.appendChild(newObj1);
            pSvg.appendChild(newObj0);
        }
    }
}

function destroyLoadingText() {
    id = "loadingText";

    if (animationText = pSvgDoc.getElementById(id))
        removeObject(animationText);
}


//---------------------------------------------------------------------------------------------------------------
//        MENU
//---------------------------------------------------------------------------------------------------------------
/*********
 *  createMenuDialog(type, target)
 *********/
function createMenuDialog(type, target) {
    height = 30;        // Hoehe pro Zeile
    width = 400;       // Breite pro Zeile
    spacer = 10;
    rund = 2;

    title = new Array();
    child = new Array();
    tag = new Array();
    newObj = new Array();

    switch (type) {
        case "Menu":
            deleteMenuDialog();
            title[0] = "Menu";
            title[1] = "Options";
            title[2] = "Video";
            title[3] = "Resume";

            child[0] = "None";
            child[1] = "Options";
            child[2] = "Video";
            child[3] = "Resume";

            tag[0] = "None";
            tag[1] = "None";
            tag[2] = "None";
            tag[3] = "None";
            break;
        case "Options":
            deleteMenuDialog();
            title[0] = "Options";

            if (masta.autoUpdate)
                title[1] = "Automatic Update: ON";
            else
                title[1] = "Automatic Update: OFF";

            title[2] = "Back";

            child[0] = "None";
            child[1] = "Save";
            child[2] = "Menu";

            tag[0] = "None";
            tag[1] = "Automatic_Update";
            tag[2] = "None";
            break;
        case "Video":
            deleteMenuDialog();
            title[0] = "Video";
            title[1] = "800 x 600";
            title[2] = "1024 x 756";
            title[3] = "1152 x 864";
            title[4] = "1280 x 1024";
            title[5] = "back";

            child[0] = "None";
            child[1] = "Save";
            child[2] = "Save";
            child[3] = "Save";
            child[4] = "Save";
            child[5] = "Menu";


            tag[0] = "None";
            tag[1] = "r1 800x600";
            tag[2] = "r2 1024x756";
            tag[3] = "r3 1152x1024";
            tag[4] = "r4 1280x1024";
            tag[5] = "None";
            break;
        case "Resume":
            deleteMenuDialog();
            enable_screen(0);
            break;
        case "Save":
            if (target == "Automatic_Update") {
                type = "Blub";
                target = "Options";
                if (!masta.autoUpdate)
                    masta.autoUpdate = true;
                else
                    masta.autoUpdate = false;

                saveOptions("automatic_update", masta.autoUpdate);
            }
            else if (target.substring(0, 1) == "r") {
                reg_Ausdruck = /r(\d)\s(\d.+)x(\d.+)/;
                reg_Ausdruck.exec(target);
                newWidth = RegExp.$2;
                newHeight = RegExp.$3;
                //saveOptions("screenSize", RegExp.$1);
                resizeWindow(newWidth, newHeight);
                type = "Blub";
                target = "Video";
                showMessage("Sorry, ain't working correct atm. :(");
            }
            break;
    }


    if ((type != "Resume") && (type != "Blub")) {
        x = (window.innerWidth / 2) - (width / 2);
        y = window.innerHeight / 2 - (title.length / 2 * height);


        allMenuObj = fSvgDoc.createElement("g");
        allMenuObj.setAttribute("id", "popupMenu");

        for (i = 0; i < title.length; i++) {
            newObj[i] = pSvgDoc.createElement("g");
            newObj[i].setAttribute("class", "mapGUI");

            if (child[i] != "None") {
                newObj[i].setAttribute("onclick", "createMenuDialog('" + child[i] + "','" + tag[i] + "');");
            }

            tempRect = fSvgDoc.createElement("rect");
            tempRect.setAttribute("x", x);
            tempRect.setAttribute("y", y + (i * height) + (i * spacer));
            tempRect.setAttribute("width", width);
            tempRect.setAttribute("height", height);
            tempRect.setAttribute("rx", rund);
            tempRect.setAttribute("ry", rund);

            tempText = fSvgDoc.createElement("text");
            tempText.setAttribute("x", window.innerWidth / 2);
            tempText.setAttribute("y", (y + (i * height) + (i * spacer)) + (height * 0.66));
            tempText.setAttribute("text-anchor", "middle");
            tempText.setAttribute("class", "mapGUIText");

            tempTextData = fSvgDoc.createTextNode(title[i]);

            tempText.appendChild(tempTextData);
            newObj[i].appendChild(tempRect);
            newObj[i].appendChild(tempText);

            allMenuObj.appendChild(newObj[i]);
        }

        if (!check_screen())
            disable_screen();
        fSvg.appendChild(allMenuObj);
    }
    else if (type == "Blub") {
        type = target;
        target = "None";
        createMenuDialog(type, target);
    }
}

function deleteMenuDialog() {
    if (fSvg.getElementById("popupMenu"))
        fSvg.removeChild(pSvgDoc.getElementById("popupMenu"));
}