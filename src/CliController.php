<?php

namespace RalfScraper;

use SunnyFlail\Console\Console;

class CliController
{
   
    public function run(array $queries)
    {
        $query = implode("[ ]?", $queries);
        $finder = new Finder();
        $regex = "/".$query."/ui";
        $currentPage = 119;

        $results = [];

        while (null !== ($result = $finder->findOnPage($regex, $currentPage))) {
            array_push($results, ...$result);
            //$results += $result;
            $currentPage ++;
        }

        $count = count($results);

        if (!($count > 0)) {
            die(Console::apply("<g_r>No entries found!<_>"));
        }

        $time = date("Y-m-d h-i-s");
        $fileName = sprintf("%s[%s]%s.json", DIR_RESULTS, $time, implode(" ", $queries));
        printf(Console::apply('Found <g>%2$s<_> entries!%1$sSaved to file: <bl>%3$s<_>%1$s'),PHP_EOL, $count, $fileName);
        $results = json_encode($results);
        file_put_contents($fileName, $results);
    }

}