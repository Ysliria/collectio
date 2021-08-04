<?php

namespace App\DataFixtures;

use App\Entity\Collection;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CollectionFixtures extends Fixture
{
    public const COLLECTIONS = [
        ['75098','Assault on Hoth','2142'],
        ['75275','A-Wing Starfighter','1672'],
        ['10227','B-wing Starfighter','1487'],
        ['10123','Cloud City','707'],
        ['10018','Darth Maul','1868'],
        ['10188','Death Star','3809'],
        ['75159','Death Star','4024'],
        ['10143','Death Star II','3461'],
        ['10236','Ewok Village','1990'],
        ['10186','General Grievous','1085'],
        ['10174','Imperial AT-ST - UCS','1069'],
        ['10212','Imperial Shuttle','2503'],
        ['10030','Bedding (Blue)','2008','501','0'],
        ['75252','Imperial Star Destroyer','4784'],
        ['10179','Millennium Falcon - UCS','5196'],
        ['10178','Motorized Walking AT-AT','1137'],
        ['10026','Naboo Starfighter - UCS','188'],
        ['10215','Obi-Wan\'s Jedi Starfighter','676'],
        ['10225','R2-D2','2127'],
        ['10019','Rebel Blockade Runner - UCS','1748'],
        ['10129','Rebel Snowspeeder - UCS','1457'],
        ['10240','Red Five X-Wing Starfighter','1558'],
        ['10195','Republic Dropship with AT-OT','1758'],
        ['75309','Republic Gunship','3290'],
        ['10144','Sandcrawler','1681'],
        ['75059','Sandcrawler','3296'],
        ['75060','Slave I','1996'],
        ['75144','Snowspeeder','1703'],
        ['10221','Super Star Destroyer','3152'],
        ['10198','Tantive IV','1408'],
        ['75095','TIE Fighter','1685'],
        ['10131','TIE Fighter Collection','685'],
        ['7181','TIE Interceptor - UCS','703'],
        ['75192','UCS Millennium Falcon','7541'],
        ['10175','Vader\'s TIE Advanced - UCS','1212'],
        ['7191','X-wing Fighter - UCS','1304'],
        ['7194','Yoda','1076'],
        ['10134','Y-wing Attack Starfighter - UCS','1490'],
        ['75181','Y-Wing Starfighter','1967']
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::COLLECTIONS as $item) {
            $collection = new Collection();

            $collection
                ->setReferenceNumber($item[0])
                ->setName($item[1])
                ->setNumberPieces($item[2])
                ->setDepth(0)
                ->setHeight(0)
                ->setWidth(0)
                ->setAddedAt(new \DateTimeImmutable())
            ;

            $manager->persist($collection);
        }

        $manager->flush();
    }
}
