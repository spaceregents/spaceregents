<?
class graph_builder
{
  var $title;       // stores the title of the whole graph
  
  var $filename;    // stores the location of the generated svg graph
  
  var $curves = array();  // stores the curves
  
  var $colors = array();  // stores the colors
  
  var $titles = array();  // stores the titles
  
  var $svg;               // stores the entire svg document
  
  var $width;
  
  var $height;
  
  var $top;               // margin-top
  
  var $bottom;
  
  var $left;
  
  var $right;
  
  var $max_y;           // stores the maximum y of all curves
  
  var $max_x;           // stores the maximum x of all curves
  
  var $x_title;         // stores the title of the x-axis
  
  var $x_start;         // stores the number the x-axis should begin with at the origin

  var $x_end;           // stores the number the x-axis should end with
  
  var $x_intervall;     // stores the max number of x values
  
  var $y_title;         // stores the title of the y-axis
  
  var $bg_color;        // stores the background color
  
  var $grid_color;      // stores the color of the grid
  
  var $text_color;      // stores the text color

  function graph_builder($title, $filename)
  {
    $this->title    = $title;
    $this->filename = $filename;
    $this->max_y    = false;
    $this->max_x    = false;
  }
  
  
  function set_color($bg_color, $grid_color, $text_color)
  {
    $this->bg_color   = $bg_color;
    $this->grid_color = $grid_color;
    $this->text_color = $text_color;
  }
  
  
  function set_size($width, $height, $left, $right, $top, $bottom)
  {
    $this->width  = $width;
    $this->height = $height;
    $this->left   = $left;
    $this->right  = $right;
    $this->top    = $top;
    $this->bottom = $bottom;
  }
  
  
  function set_x_axis($x_title, $x_start, $x_increment, $x_end)
  {
    $this->x_title      = $x_title;
    $this->x_start      = $x_start;
    $this->x_increment  = $x_increment;
    $this->x_end        = $x_end;
  }
  
  function set_y_axis($y_title)
  {
    $this->y_title      = $y_title;
  }
  
  /**********
   * add_curve
   * - string $title
   * - string $color, SVG conform (e.g. :'black', '#FF00FF')
   * - array of curve values, where the key is X and the value is Y
   **********/
  function add_curve($title, $color, $value_array)
  {
    $this->colors[] = $color;
    $this->titles[] = $title;
    $this->curves[] = $value_array;
  }
  
  
  function get_max_values()
  {    
    if (is_array($this->curves))
    {
      $this->max_x = 0;
      $this->max_y = 0;
      foreach($this->curves as $curve_array)
      {
        if (sizeof($curve_array) > $this->max_x) $this->max_x = sizeof($curve_array);

        for ($i = 0; $i < sizeof($curve_array); $i++)
        {
          if ($this->max_y < $curve_array[$i]) $this->max_y = $curve_array[$i];
        }
      }
      return true;
    }
    else
      return false;
  }
  
  function set_max_x($max_x)
  {
    $this->max_x = $max_x;
  }
  

  function set_max_y($max_y)
  {
    $this->max_y = $max_y;
  }
  
  function build()
  {
    if (!$this->max_x || !$this->max_y)
    {
      if (!$this->get_max_values())
      {
        echo("ERROR:: NO CURVES");
        return false;
      }
    }
    
    if ($this->max_x < ($this->x_end - $this->x_begin))
    {
      $intervall      = $this->x_start + $this->max_x;
      $this->x_start  = $this->x_end - $this->max_x;
      $this->x_end    = $intervall;
    }        
    
    if ($this->max_x == 0) $this->max_x = 1;
    if ($this->max_y == 0) $this->max_y = 1;
    
    //keep 25% margin to top, right, etc..
    $x_step = ($this->width - $this->left - $this->right) / ($this->max_x * 1.25);
    $y_step = ($this->height - $this->top - $this->bottom) / ($this->max_y * 1.25);
  
    // SVG HEADER
    $this->svg = "<".chr(63)."xml version=\"1.0\"".chr(63).">\n";
    $this->svg .= "<!DOCTYPE svg PUBLIC \"-//W3C//DTD SVG 1.0//EN\"    \"http://www.w3.org/TR/2001/REC-SVG-20010904/DTD/svg10.dtd\" [\n";
    $this->svg .= "<!ENTITY bg \"fill:".$this->bg_color.";\">\n";
    $this->svg .= "<!ENTITY grid \"stroke:".$this->grid_color.";fill:none;\">\n";
    $this->svg .= "<!ENTITY fgrid \"stroke:".$this->grid_color.";fill:".$this->grid_color.";\">\n";
    $this->svg .= "<!ENTITY topic \"fill:".$this->text_color.";stroke:none;text-anchor:middle;font-size:10pt;letter-spacing:2pt;\">\n";
    $this->svg .= "<!ENTITY text \"fill:".$this->text_color.";stroke:none;text-anchor:middle;font-size:8pt;font-weight:thin;\">\n";
    $this->svg .= "<!ENTITY ltext \"fill:".$this->text_color.";stroke:none;text-anchor:begin;font-size:8pt;font-weight:thin;\">\n";
    $this->svg .= "]>\n";
    $this->svg .= "<svg width=\"".$this->width."\" height=\"".$this->height."\">\n";
    
    // DEFS
    $this->svg .="<defs>\n<marker id=\"Triangle\" viewBox=\"0 0 30 30\" refX=\"0\" refY=\"15\" markerUnits=\"strokeWidth\" markerWidth=\"12\" markerHeight=\"9\" orient=\"auto\">\n<path style=\"&fgrid;\" d=\"M 0 0 L 30 15 L 0 30 z\" />\n</marker>\n</defs>";
    
    // BACKGROUND
    $this->svg .= "<rect x=\"0\" y=\"0\" width=\"".$this->width."\" height=\"".$this->height."\" style=\"&bg;\"/>";

    // TITLE
    $this->svg  .= "<text x=\"".($this->width / 2)."\" y=\"10\" style=\"&topic;\">".$this->title."</text>";    
    
    // GRID
    // X-Axis
      $this->svg .= "<line x1=\"".$this->left."\" y1=\"".($this->height - $this->bottom)."\" x2=\"".($this->width - $this->right)."\" y2=\"".($this->height - $this->bottom)."\" style=\"&grid;\" marker-end=\"url(#Triangle)\"/>\n";
      $this->svg  .= "<text x=\"".($this->width - $this->right)."\" y=\"".($this->height - $this->bottom + 15)."\" style=\"&text;\">".($this->x_title)."</text>";
      
      $x_pos = $this->left;
      $k     = 0;
      while ($k < $this->max_x)
      {
        $this->svg  .= "<line x1=\"".$x_pos."\" y1=\"".($this->height - $this->bottom)."\" x2=\"".$x_pos."\" y2=\"".($this->height - $this->bottom + 5)."\" style=\"&grid;\"/>\n";
        $this->svg  .= "<text x=\"".$x_pos."\" y=\"".($this->height - $this->bottom + 20)."\" style=\"&text;\">".($this->x_start + ($k * $this->x_increment))."</text>";
        $k          += 5;
        $x_pos      = $this->left + $k * $x_step;
      }


    // Y-Axis
      $this->svg .= "<line x1=\"".$this->left."\" y1=\"".($this->height - $this->bottom)."\" x2=\"".$this->left."\" y2=\"".$this->top."\" style=\"&grid;\" marker-end=\"url(#Triangle)\"/>\n";
      $this->svg  .= "<text x=\"5\" y=\"".($this->top - 15)."\" style=\"&ltext;\">".($this->y_title)."</text>";
      
      $y_pos = $this->height - $this->bottom;
      $k = 0;
      while ($k <= floor($this->max_y * 1.25))
      {
        $this->svg  .= "<line x1=\"".($this->left - 5)."\" y1=\"".$y_pos."\" x2=\"".$this->left."\" y2=\"".$y_pos."\" style=\"&grid;\"/>\n";
        $this->svg  .= "<text x=\"".($this->left - 15)."\" y=\"".($y_pos+5)."\" style=\"&text;\">".$k."</text>";
        $k += 10;
        $y_pos      = $this->height - $this->bottom-($k * $y_step);
      }

    // LEGEND
      foreach ($this->titles as $index => $title)
      {
        $this->svg .= "<circle style=\"fill:".$this->colors[$index].";stroke:black;\" cx=\"".($this->width - $this->right)."\" cy=\"".($this->top + ($index * 15))."\" r=\"5\"/>\n";
        $this->svg .= "<text style=\"&ltext;\" x=\"".($this->width - $this->right + 7)."\" y=\"".($this->top + ($index * 15) + 2.5)."\">".$title."</text>\n";
      }
    
    // CURVES
      foreach($this->curves as $i => $data)
      {
        $this->svg .= "<g style=\"fill:none;stroke:".$this->colors[$i].";\">\n";
        $this->svg .= "<path d=\"M";
        foreach($data as $j => $value)
        {
          if ($j > 0)
            $this->svg .= " ";
            
          $this->svg .= ($this->left + ($j * $x_step)).",".($this->height - $this->bottom - ($value * $y_step));
        }
        $this->svg .= "\"/>\n</g>\n";
      }


      $this->svg .= "</svg>";

      // Save data      
      $file = fopen($this->filename, "w");
      fputs($file, $this->svg);
      fclose($file);
  }
}
?>