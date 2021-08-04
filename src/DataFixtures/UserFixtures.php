<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

use function Symfony\Component\String\u;

class UserFixtures extends Fixture
{
    public const FAKE_USERS = [
        ['Mame','Catton','mcatton0@answers.com'],
        ['Ortensia','Martinets','omartinets1@typepad.com'],
        ['Valentine','Eads','veads2@freewebs.com'],
        ['Nye','Ivan','nivan3@amazon.co.jp'],
        ['Noe','Cluatt','ncluatt4@google.com.au'],
        ['Ariela','Tuffell','atuffell5@miitbeian.gov.cn'],
        ['Elsbeth','Powlett','epowlett6@macromedia.com'],
        ['Bethina','Sheehan','bsheehan7@mit.edu'],
        ['Dory','Aleksidze','daleksidze8@tinypic.com'],
        ['Raquela','Pitway','rpitway9@marketwatch.com'],
        ['Joice','Millson','jmillsona@com.com'],
        ['Nealon','Kubalek','nkubalekb@reverbnation.com'],
        ['Averil','Brignell','abrignellc@vk.com'],
        ['Erminia','Twiname','etwinamed@studiopress.com'],
        ['Harriette','Ellice','hellicee@marketwatch.com'],
        ['Lurleen','Collar','lcollarf@angelfire.com'],
        ['Hendrik','Burdon','hburdong@marriott.com'],
        ['Alejandro','Goodspeed','agoodspeedh@wordpress.org'],
        ['Alameda','Bowring','abowringi@who.int'],
        ['Brandea','Nicholls','bnichollsj@unesco.org'],
    ];

    private UserPasswordHasherInterface $userPasswordHasher;

    public function __construct(UserPasswordHasherInterface $userPasswordHasher)
    {
        $this->userPasswordHasher = $userPasswordHasher;
    }

    public function load(ObjectManager $manager)
    {
        foreach (self::FAKE_USERS as $fakeUser) {
            $user = new User();

            $user
                ->setFirstname($fakeUser[0])
                ->setLastname($fakeUser[1])
                ->setEmail($fakeUser[2])
                ->setIsVerified(true)
                ->setRoles([])
                ->setPassword(
                    $this->userPasswordHasher->hashPassword(
                        $user,
                        'Test1234*'
                    )
                )
            ;

            $manager->persist($user);
        }

        $manager->persist($this->createAdminUser());
        $manager->flush();
    }

    private function createAdminUser(): User
    {
        $admin = new User();

        $admin
            ->setFirstname('Andy')
            ->setLastname('CAPE')
            ->setEmail('admin@collectio.local')
            ->setIsVerified(true)
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword(
                $this->userPasswordHasher->hashPassword(
                    $admin,
                    'Test1234*'
                )
            )
        ;

        return $admin;
    }
}
