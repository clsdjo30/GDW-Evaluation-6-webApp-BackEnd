<?php

namespace App\DataFixtures;

use App\Entity\Agent;
use App\Entity\Contact;
use App\Entity\Country;
use App\Entity\Hideout;
use App\Entity\Mission;
use App\Entity\Skill;
use App\Entity\Statute;
use App\Entity\Target;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;


class AppFixtures extends Fixture
{
    /**
     * Encodeur de mot de passe
     *
     * @var UserPasswordHasherInterface
     */
    private UserPasswordHasherInterface $encoder;

    public function __construct(UserPasswordHasherInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create('fr_FR');

        $countries = [];
        $consultant = [];
        $statuts = [];
        $skills = [];


        $admin = new User();
        $admin->setEmail('cedric@kgb.com');
        $admin->setRoles(['ROLE_ADMIN']);
        $admin->setPassword($this->encoder->hashPassword($admin, 'password'));


        $manager->persist($admin);

        /*
                for ($i = 0; $i  < 10; $i++)
                {
                    $consultant = new User();

                    $consultant->setEmail($faker->email());
                    $consultant->setRoles(['ROLE_CONSULTANT']);
                    $consultant->setPassword($this->encoder->hashPassword($consultant, 'password'));


                    $manager->persist($consultant);
                    $consultant[] = $consultant;
                }
        */      //On génère les status de mission et on les stock dans un tableau
        $statuteValues = array("En Préparation", "En Cours", "Terminée", "Echouée");

        foreach ($statuteValues as $statuteValue) {
            $statute = new Statute();
            $statute->setName($statuteValue);
            $manager->persist($statute);
            $statuts[] = $statute;
        }

        // On génère des Skills et on les stocks dans un tableau
        $skillValues = array("Assassinat", "Filature", "Mise sur écoute", "Infiltration", "Exfiltration", "Protection");

        foreach ($skillValues as $skillValue) {
            $skill = new Skill();
            $skill->setName($skillValue);
            $manager->persist($skill);
            $skills[] = $skill;
        }


        // On génère une liste de pays et leurs nationalités
        $countryValues = array(
            ["USA", "américaine"],
            ["Allemagne", "allemande"],
            ["Russie", "russe"],
            ["Chine", "chinoise"],
            ["Angleterre", "anglaise"],
            ["France", "française"],
            ["Belgique", "belge"],
            ["Japon", "Japonaise"],
            ["Argentine", "argentin"],
        );


        foreach ($countryValues as [$countryName, $countryNationality]) {
            $country = new Country();
            $country->setName($countryName)
                ->setNationality($countryNationality);
            $manager->persist($country);
            $countries[] = $country;
        }


        for ($i = 0; $i < 30; $i++) {
            $mission = new Mission();

            $mission->setTitle($faker->realTextBetween(15, 25))
                ->setCodeName($faker->sentence(3))
                ->setCountry($faker->randomElement($countries))
                ->setStatus($faker->randomElement($statuts))
                ->setType($faker->randomElement($skills))
                ->setDescription($faker->realTextBetween(160, 350))
                ->setStartAt($faker->dateTime())
                ->setEndAt($faker->dateTime());

            // On génère une liste d'agents

            $agent = new Agent();
            $agent->setFirstname($faker->firstName())
                ->setLastname($faker->firstName())
                ->setCodeName($faker->realTextBetween(6, 16))
                ->setBirthday($faker->dateTime())
                ->addSkill($faker->randomElement($skills))
                ->setCountry($faker->randomElement($countries))
                ->setMission($mission);
            $manager->persist($agent);


            // On génère une liste de planques

            $hideout = new Hideout();
            $hideout->setCode($faker->realText(10))
                ->setAddress($faker->streetAddress())
                ->setCountry($faker->randomElement($countries))
                ->setMission($mission);
            $manager->persist($hideout);


            // On génère une liste de cibles

            $target = new Target();
            $target->setFirstname($faker->firstName())
                ->setLastname($faker->lastName())
                ->setCodeName($faker->sentence(3))
                ->setBirthday($faker->dateTime())
                ->setCountry($faker->randomElement($countries))
                ->setMissionId($mission);

            $manager->persist($target);


            // On génère une liste de contacts

            $contact = new Contact();
            $contact->setFirstname($faker->firstName())
                ->setLastname($faker->lastName())
                ->setCodeName($faker->sentence(3))
                ->setBirthday($faker->dateTime())
                ->setCountry($faker->randomElement($countries))
                ->addMission($mission);

            $manager->persist($contact);


            /*
            if (!$mission->missionIsValid())
            {
                echo 'Certain élément de la mission ne sont pas valide !  < /br>';

            } else {
                $manager->persist($mission);
            }
            */
            $manager->persist($mission);
        }
        $manager->flush();

    }


}
