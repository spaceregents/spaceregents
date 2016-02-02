/*********
*
*  key_functions(evt)
*
*********/
function key_functions(evt)
{
  switch(evt.getKeyCode())
  {
    case 37:
      masta.scroll(7);
    break;
    case 38:
      masta.scroll(1);
    break;
    case 39:
      masta.scroll(3);
    break;
    case 40:
      masta.scroll(5);
    break;
  }
}
