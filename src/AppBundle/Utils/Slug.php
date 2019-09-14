<?php

namespace AppBundle\Utils;

class Slug
{
    static public function slugCreator(string $slug): string
    {
        $slug = preg_replace('~[^\\pL\d]+~u', '-', $slug);
        $slug = trim($slug, '-');
        $slug = preg_replace('~[^-\w]+~', '', $slug);
        $slug = iconv('UTF-8', 'us-ascii//TRANSLIT', $slug);
        $slug = strtolower($slug);

        if (empty($slug)) {
            return NULL;
        }
        return $slug;
    }
}