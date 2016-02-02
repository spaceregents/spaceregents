SR_CLASS_KEY_EVENTS = function() {

  this.currentKeys  = new Array();

  this.addKeyEvent = SR_CLASS_KEY_EVENTS_addKeyEvent;

  function SR_CLASS_KEY_EVENTS_addKeyEvent(newKeyCode, type, correspondingElement) {
    this.currentKey.push(newKeyCode);
  }
}