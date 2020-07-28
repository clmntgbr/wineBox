<?php

namespace App\Util;

use App\Entity\Wine\Cellar;

class Generator
{
    public function load(Cellar $cellar)
    {
        $column = ['00'];

        for ($i = 0; $i < $cellar->getHorizontal(); $i++) {
            $column[] = $this->generateColumn($i);
        }

        $content = "<table><thead><tr>";

        for ($i = 0; $i < $cellar->getHorizontal(); $i++) {
            if ($i == 0) {
                $content .= "<th colspan='1' id='trash'></th>";
                continue;
            }
            $content .= sprintf("<th colspan='1' id='%s'>%s</th>", $column[$i], $column[$i]);
        }

        $content .= "</tr></thead><tbody>";

        for ($i = 0; $i < $cellar->getVertical(); $i++) {
            $content .= "<tr>";
            for ($j = 0; $j < $cellar->getHorizontal(); $j++) {
                if ($j == 0) {
                    $content .= sprintf("<th colspan='1' id='%s'>%s</th>", sprintf("%03d", $i+1), $i+1);
                    continue;
                }
                $content .= sprintf("<td colspan='1' id='%s%s'>%s%s</td>", $column[$j], sprintf("%03d", $i+1), $column[$j], sprintf("%03d", $i+1));
            }
            $content .= "</tr>";
        }

        $content .= "</tbody></table>";

        return $content;
    }

    function generateColumn($i) {
        $temporary = "";
        while ($i >= 0) {
            $temporary = chr($i % 26 + 65) . $temporary;
            $i = floor($i / 26) - 1;
        }
        return $temporary;
    }
}