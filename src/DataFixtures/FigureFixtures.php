<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Figure;
use Doctrine\Common\Collections\ArrayCollection;
use App\Entity\User;
use App\DataFixtures\AppFixtures;


class FigureFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for($i=1; $i <=20; $i++){

            $figure = new Figure();
            $figure->setNom("name of the figure n$i");
            $figure->setDescription("<p>description of the figure n$i</p>");
            $figure->setGroupeFigure("Group of the figure n$i");
            $figure->setLienPhoto("http://placehold.it/350x150");

                $manager->persist($figure);
        }
        
        $manager->flush();
    }
}
