<?php

namespace App\Library\Data;


class Iconsdata
{
    public static function get()
    {
        $icons = [];
        // dd(base_path() . '/database/');
        foreach (glob(base_path() . '/database/data/Icons/*.*') as $file) {

            $icons[substr(basename($file), 0, 1)] = FetchJsonFile::open('icons/' . basename($file));
        }

        return $icons;
    }
}
