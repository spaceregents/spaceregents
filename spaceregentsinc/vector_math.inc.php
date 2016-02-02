<?
/******************************
 *  vector_get_norm($x1,$y1,$x2,$y2)
 * 
 * return: int; betrag eines vektors
 *
 ******************************/
function vector_get_norm($x1,$y1,$x2,$y2)
{
  $nx = $x2 - $x1;
  $ny = $y2 - $y1;

  $betrag = sqrt(($nx * $nx) + ($ny * $ny));
  
  return $betrag;
}


/******************************
 *  vector_get_point_by_angle($angle)
 * 
 * return: float; [-2..-1][1..2] für x und y
 *
 ******************************/
function vector_get_point_by_angle($angle)
{
  //echo("ANGLE: ".$angle."\n");
  if ($angle >= 0 && $angle < 90)
  {
    $new_point["x"] = cos($angle) + 1;
    $new_point["y"] = sin($angle) + 1;
  }
  elseif ($angle >= 90 && $angle < 180)
  {
    $new_point["x"] = cos($angle - 180) * -1 - 1;
    $new_point["y"] = sin($angle) + 1;
  }
  elseif ($angle >= 180 && $angle < 270)
  {
    $new_point["x"] = cos($angle - 180) * -1 - 1;
    $new_point["y"] = sin($angle - 180) * -1 - 1;
  }
  else
  {
    $new_point["x"] = cos($angle) + 1;
    $new_point["y"] = sin($angle - 180) * -1 - 1;
  }
  
  return $new_point;
}
?>