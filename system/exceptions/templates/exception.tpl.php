<style type="text/css">
  p, div, ol, ul {
    margin: 0;
    padding: 0;
    border: 0;
    vertical-align: baseline;
    background: transparent;
  }
  .exception {
    width: 700px;
    border: 1px solid #D6D6D6;
    background-color: #FAFAFA;
    font-family: arial, tahoma, verdana;
    font-size: 75%;
    padding: 10px;
    line-height: 140%;
  }
  .exception img {
    float: left;
    margin-right: 7px;
  }
  .exceptionTitle {
    padding-top: 2px;
    color: #AA0000;
    font-size: 120%;
    font-weight: bold;
  }
  .exceptionMessage {
    background-color: white;
    border: 1px solid #E1E1E1;
    padding: 5px;
    font-size: 110%;
    margin: 10px 0;
  }
  .exception a {
    cursor: pointer;
    padding: 1px;
    border-bottom: 1px dotted #555;
    color: #000;
  }
  .exceptionTraceContainer {
    font-size: 95%;
    line-height: 150%;
    font-family: verdana, tahoma, arial;
    margin: 10px 0;
  }
  .exceptionTraceContainer ol {
    padding-left: 25px;
  }
  .exceptionTraceContainer li {
    padding-top: 5px;
  }
  .exceptionSystemInfo {
    font-size: 90%;
    border-top: 1px solid #E1E1E1;
    padding: 10px 5px;
    color: #666;
  }
</style>
<!--[if IE]>
<style type="text/css">
img { display: none; }
</style>
<![endif]-->
<script type="text/javascript">
function _showAllTrace() {
    var trace = document.getElementById('exceptionTrace');
    trace.style.display = (trace.style.display == 'none') ? '' : 'none';
}
</script>
<div class="exception">
    <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABEAAAARCAYAAAA7bUf6AAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAALEgAACxIB0t1+/AAAABZ0RVh0Q3JlYXRpb24gVGltZQAxMi8wMi8wOOE6tm4AAAAYdEVYdFNvZnR3YXJlAEFkb2JlIEZpcmV3b3Jrc0+zH04AAAHsSURBVDiNlZDNahNhFIaf+clkkknSNNHUohSRYlyIyxYRXLhVL8B7qCIKigUR3IobewOC0EWgdyCIf4sstLSRlopasQhxmkyTSTIZJ/PjIiZlzJTEB87iO3w8vO8RHMcJiOBX+Qad6iu0E1eYWVyN+jJEjFoalfvYtTKZmUXsepnqu+v/J3Gam5g/SqSOXyCuFZiavchvcwujcm9yiVFZJqZOo6g5CDwkSSGVP09j9wVd/eV4idPcwDI+oGXnIfCGo6hZEuk59tdvj5cYlQfEEwUkSQlJCDy0qTP4PRNj8+7REs+uYtXXSWbnABdwyS+UyC+UABdBDEjlzmLureE0N6IlB5+WkZUUsqweJhjw9x1PTBNT0tQ+LkVLOvprkpmT4Rr/SPq1TuF0vtPZWw1LWl+fEfg94onMsEp/BhzuJDmGqhU42HkSljR3n6Nq+ZFjRiUh8EikjuF292lsPwJAaOvl4Ofba+QK5xCl2Mjlj6LbqWG1DU5f/Ybc2H6MomiIogCBG/qYv/QGgPr7yyOSRDJLt6XT2HqI8HmtEKSzsyhqauIUA2yrSdvUkQUxhu854RtMiO/3EMUYYq64RNvU6XbqBL7TrzRmfNfGatWw2nVyxZsIjuMErS9PMXZW8Fx74hSSrJIr3iI9f4c/ZwP51LVnSksAAAAASUVORK5CYII=" alt="exception" />
    <div class="exceptionTitle">Application was halted by an exception.</div>
    <?php
    if ($debug_mode) {
    ?>
        <p class="exceptionMessage">
           <strong><?php echo $exception->getName(); ?>:<br />
                <?php
                if ($exception->getCode() != 0) {
                    echo "[Code: " . $exception->getCode() . "] ";
                }
                ?>
                <?php echo htmlspecialchars($this->exception->getMessage()); ?>
            </strong><br />
            Thrown in <?php echo $exception->getFile(); ?> (Line: <?php echo $exception->getLine(); ?>)
        </p>
        <div class="exceptionTraceContainer">
        <?php
        if (($traces = $exception->getPrevTrace()) === null) {
            $traces = $exception->getTrace();
        }

        $count = $total = count($traces);
        if ($total > 3) {
                ?>
                <p><a onclick="javascript: _showAllTrace();"><strong>Toggle all trace</strong></a></p>
                <?php
        }
        ?>

        <?php
        foreach ($traces as $trace) {
            if (!isset($trace['file'])) {
                $trace['file'] = 'unknown';
            }
            if (!isset($trace['line'])) {
                $trace['line'] = 'unknown';
            }
            if ($total - $count == 3) {
                echo "\r\n<div style='color: #424242; display: none;' id='exceptionTrace'>";
            }

            $count--;
            echo $count . '. ';
            $args = '';
            if (!isset($trace['args'])) {
                $trace['args'] = $trace;
            }
            foreach ($trace['args'] as $arg) {
                $args .= $exception->convertArgToString($arg) . ', ';
            }
            $args = htmlspecialchars(substr($args, 0, strlen($args) - 2));

            echo 'At <strong>';
            if (isset($trace['class']) && isset($trace['type'])) {
                echo $trace['class'] . $trace['type'] . $trace['function'] . '(' . $args . ')';
            } else {
                echo $trace['function'] . '(' . $args . ')';
            }
            echo '</strong>; In: ' . $trace['file'] . ':' . $trace['line'] . '<br />';
            echo "\r\n";
        }
        if ($total > 3) {
            echo '</div>';
        }
        ?>
        </div>
        <p class="exceptionSystemInfo">
            SAPI: <strong><?php echo $system_info['sapi']; ?></strong>,
            Software: <strong><?php echo $system_info['software']; ?></strong>,
            PHP: <strong><?php echo $system_info['php']; ?></strong>,
            mzz: <strong><?php echo $system_info['mzz']; ?></strong>
        </p>
    <?php
    } else {
        echo '<p>Debug-mode is off.</p>';
    }
    ?>
</div>