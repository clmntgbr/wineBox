<?php

namespace App\Util;

use App\Entity\Wine\Box;
use Doctrine\ORM\EntityManagerInterface;

class BoxGenerator
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /** @var WineData */
    private $wineData;

    private $isNew = false;
    private $addBottles = true;
    private $isLocked = false;
    private $ids = [];

    public function __construct(EntityManagerInterface $entityManager, WineData $wineData)
    {
        $this->entityManager = $entityManager;
        $this->wineData = $wineData;
    }

    public function load(Box $box)
    {
        if ($this->isNew) {
            $this->isNew = "<div class='redips-drag redips-clone case bottle new'></div>";
        }

        $column = ['00'];

        for ($i = 0; $i < $box->getHorizontal(); $i++) {
            $column[] = $this->generateColumn($i);
        }

        $content = "<table><thead><tr>";

        for ($i = 0; $i < $box->getHorizontal(); $i++) {
            if ($i == 0) {
                $content .= sprintf("<th colspan='1' class='redips-mark redips-trash horizontal'>%s</th>", $this->isNew);
                continue;
            }
            $content .= sprintf("<th colspan='1' id='%s'  class='redips-mark redips-trash horizontal'>%s</th>", $column[$i], $column[$i]);
        }

        $content .= "</tr></thead><tbody>";

        for ($i = 0; $i < $box->getVertical(); $i++) {
            $content .= "<tr>";
            for ($j = 0; $j < $box->getHorizontal(); $j++) {
                if ($j == 0) {
                    $content .= sprintf("<th colspan='1' id='%s' class='redips-mark redips-trash vertical'>%s</th>", sprintf("%03d", $i+1), $i+1);
                    continue;
                }
                $content .= sprintf("<td colspan='1' id='%s%s'></td>", $column[$j], sprintf("%03d", $i+1));
            }
            $content .= "</tr>";
        }
        $content .= "</tbody></table>";

        if ($this->addBottles) {
            $content = $this->addBottles($content);
        }

        return $content;
    }

    private function generateColumn($i) {
        $temporary = "";
        while ($i >= 0) {
            $temporary = chr($i % 26 + 65) . $temporary;
            $i = floor($i / 26) - 1;
        }
        return $temporary;
    }

    private function addBottles(string $content)
    {
        $bottles = $this->wineData->getWineBottlesInBox();

        foreach ($bottles as $bottle) {
            if ($this->isLocked && false === in_array($bottle['id'], $this->ids)) {
                $replacement = sprintf(
                    "<td id='%s' class='redips-mark'><div id='%s' class='case bottle redips-mark' data-id='%s' data-color='%s' data-location='%s' style='background-color:%s;'></div></td>",
                    $bottle['location'], $bottle['id'], $bottle['id'], $bottle['color_slug'], $bottle['location'], $bottle['color_css']
                );
                $content = str_replace(sprintf("<td colspan='1' id='%s'></td>", $bottle['location']), $replacement, $content);
                continue;
            }

            $replacement = sprintf(
                "<td id='%s'><div id='%s' class='case bottle redips-drag marked' data-id='%s' data-color='%s' data-location='%s' style='background-color:%s;'></div></td>",
                $bottle['location'], $bottle['id'], $bottle['id'], $bottle['color_slug'], $bottle['location'], $bottle['color_css']
            );
            $content = str_replace(sprintf("<td colspan='1' id='%s'></td>", $bottle['location']), $replacement, $content);
        }

        return $content;
    }

    public function setIsLocked(bool $isLocked)
    {
        $this->isLocked = $isLocked;

        return $this;
    }

    public function setIds(array $ids)
    {
        $this->ids = $ids;

        return $this;
    }

    public function setIsNew(bool $isNew)
    {
        $this->isNew = $isNew;

        return $this;
    }

    public function setAddBottles(bool $addBottles)
    {
        $this->addBottles = $addBottles;

        return $this;
    }
}