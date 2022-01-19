<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;
use App\Entity\Enquiry;
use App\Entity\Comment;
use App\Entity\Blog;


class AppExtension extends AbstractExtension{
    public function getFilters()
    {
        return array(
            new TwigFilter('created_ago', array($this, 'createdAgo')),
        );
    }

    public function createdAgo(\DateTime $dateTime)
    {
        $delta = time() - $dateTime->getTimestamp();
        if ($delta < 0)
            throw new \InvalidArgumentException("createdAgo is unable to handle dates in the future");

        $duration = "";
        if ($delta < 60)
        {
            // Seconds
            $time = $delta;
            $duration = $time . " секунд" /*. (($time > 1) ? "s" : "")*/ . " назад";
        }
        else if ($delta <= 3600)
        {
            // Mins
            $time = floor($delta / 60);
            $duration = $time . " минут" /*. (($time > 1) ? "s" : "")*/ . " назад";
        }
        else if ($delta <= 86400)
        {
            // Hours
            $time = floor($delta / 3600);
            $duration = $time . " часов" /*. (($time > 1) ? "s" : "")*/ . " назад";
        }
        else
        {
            // Days
            $time = floor($delta / 86400);
            $duration = $time . " день" /*. (($time > 1) ? "s" : "")*/ . " назад";
        }

        return $duration;
    }

    public function getName()
    {
        return 'AppExtension';
    }


}