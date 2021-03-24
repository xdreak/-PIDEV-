<?php

namespace App\DataFixtures;
use App\Entity\User;
use App\Entity\Articlelike;
use App\Entity\Artiles;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
class AppFixtures extends Fixture
{
    /**
     * Encodeur de mot de passe
     *
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        $users = [];

        $user = new User();
        $user->setEmail('user@symfony.com')
            ->setPassword($this->encoder->encodePassword($user, 'password'));

        $manager->persist($user);

        $users[] = $user;

        for ($i = 0; $i < 30; $i++) {
            $user = new User();
            $user->setEmail($faker->email)
                ->setPassword($this->encoder->encodePassword($user, 'password'));

            $manager->persist($user);
            $users[] = $user;
        }

        for ($i = 0; $i < 20; $i++) {
            $post = new Artiles();
            $post->setTitre($faker->sentence(6))
                ->setResume($faker->paragraph())
                ->setContenu('<p>' . join(',', $faker->paragraphs()) . '</p>')
                ->setImage("http://placehold.it/200x200")
                ->setPubliele(new \DateTime());

            $manager->persist($post);

            for ($j = 0; $j < mt_rand(0, 10); $j++) {
                $like = new Articlelike();
                $like->setArticle($post)
                    ->setUser($faker->randomElement($users));

                $manager->persist($like);
            }
        }

        $manager->flush();
    }
}
