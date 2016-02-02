function sr_play_audio(audioTrack, type) {
  var audioId = false;
  var newAudio;

  switch (audioTrack)
  {
    case "BUTTON_DOWN":
      audioId = "SR_AUDIO_BUTTON_DOWN";
    break;
    case "CONTROL_OPEN":
      audioId = "SR_AUDIO_CONTROL_OPEN";
    break;
    default:
      if (type == "REPORT" || type == "CONFIRM") {
        audioId = "SR_AUDIO_SPEECH_"+audioTrack;

        if (!pSvgDoc.getElementById(audioId)) {
          newAudio = pSvgDoc.createElementNS("http://www.adobe.com/svg10-extensions","a:audio");
          //newAudio = pSvgDoc.createElement("a:audio");
          newAudio.setAttribute("id",audioId);
          newAudio.setAttributeNS("http://www.w3.org/1999/xlink","xlink:href","sounds/"+audioTrack);
          pSvg.appendChild(newAudio);
        }
        updateStatusText(audioTrack);
      }
      else {
        audioId = audioTrack;
      }
    break;
  }

  if (audioId)
        pSvgDoc.getElementById(audioId).setAttribute("begin",pSvg.getCurrentTime());
}