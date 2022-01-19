<?php

namespace App\DataFixtures;

use App\Entity\Blog;
use App\Entity\Comment;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{

    private $passwordHasher;

    public function __construct(UserPasswordHasherInterface $passwordHasher)
    {
        $this->passwordHasher = $passwordHasher;
    }


    private $blogsData = [
        ['title' => 'Американские блины','tag' => 'Куриное яйцо, Соль, Сахар, Молоко, Пшеничная мука, Гашеная сода, Растительное масло', 'image' => '1.jpeg', 'author' => 'Ezharikov', 'blog' => 'Яйца взбить с сахаром и солью до появления пены.Добавить стакан молока, хорошо взбить венчиком, постепенно всыпать муку, постоянно разбивая комочки венчиком.Повторить предыдущий пункт, добавив оставшиеся стаканы молока и муки.Влить растительное масло (можно заменить топленым сливочным).Погасить соду, добавить в тесто и еще раз хорошо перемешать. Оставить постоять минут 5–10. За это время разогреть сковороду.Жарить на умеренном огне. Как только появятся и начнут лопаться пузырьки, перевернуть оладушек и жарить еще секунд 20.'],
        ['title' => 'Сырники из творога','tag' => 'Куриное яйцо, Творог, Сахар, Пшеничная мука, Подсолнечное масло', 'image' => '2.jpeg', 'author' => 'Ezharikov', 'blog' => 'Положите весь творог в кастрюльку и разомните его вилкой так, чтобы в нем не осталось крупных комков. Разбейте в него яйца, всыпьте сахар и тщательно все перемешайте. Лучше не использовать слишком сухой или слишком влажный творог, иначе сырники будут разваливаться в процессе приготовления.Всыпьте в творог 5 столовых ложек (с горкой) муки и тщательно перемешайте. Можно добавить немного больше муки, сырники получатся тогда более плотными. Или муки можно добавить чуть меньше, и тогда сырники будут нежнее. В итоге у вас должна получиться однородная масса, из которой можно будет лепить сырники.Поставьте сковороду на средний огонь и налейте в нее подсолнечное масло.Насыпьте на тарелку немного муки. Слепите несколько небольших шариков из получившейся творожной массы и положите их на тарелку. Лучше лепить разом 4–5 шариков — столько, сколько поместится одновременно на сковороду. Затем по очереди обкатывайте творожные шарики в муке, плющите их в небольшие лепешки (они не должны быть слишком тонкие) и выкладывайте на сковороду.Обжаривайте сырники 1–2 минуты до появления золотистой корочки. Затем переверните их на другую сторону и также обжарьте до золотистого состояния.Повторяйте, пока творог не закончится.'],
        ['title' => 'Классическая шарлотка','tag' => 'Куриное яйцо, Яблоко, Сахар, Молоко, Пшеничная мука, Сода, Растительное масло', 'image' => '3.jpeg', 'author' => 'Ezharikov', 'blog' => 'Разогреть духовку. Отделить белки от желтков. Белки взбить в крепкую пену, постепенно добавляя сахар.Продолжать взбивать, добавляя по одному желтки, затем гашеную соду и муку. Тесто по консистенции должно напоминать сметану.Смазать противень растительным маслом. Вылить половину теста на противень, разложить равномерно нарезанные дольками яблоки, залить второй половиной теста.Поместить противень в разогретую духовку. 3 минуты подержать при температуре 200 градусов, затем убавить до 180 и выпекать 20-25 минут.'],
        ['title' => 'Тонкие блины на молоке','tag' => 'Куриное яйцо, Соль, Сахар, Молоко, Пшеничная мука, Растительное масло', 'image' => '4.jpeg', 'author' => 'Ezharikov', 'blog' => 'Взбейте яйца с сахаром.Постепенно введите муку и соль, чередуя с молоком и аккуратно размешайте до однородной массы.Оставьте на 20 минут.Добавьте в тесто растительное масло и жарьте блины на сильно разогретой сковороде.'],
        ['title' => 'Пирог Зебра','tag' => 'Куриное яйцо, Сметана, Сахар, Какао-порошок, Пшеничная мука, Гашеная сода, Сливочное масло', 'image' => '5.jpeg', 'author' => 'Ezharikov', 'blog' => 'Яйца взбить с сахаром до белой пены. Добавить 2 стакана просеянной муки, соду, растопленное остывшее сливочное масло, сметану и тщательно перемешать (лучше миксером).Тесто разделить на две равные части. В одну часть добавить 2 столовые ложки муки, в другую 2 столовые ложки какао. Перемешать, чтобы не было комочков. Тесто должно быть консистенции негустой сметаны.Широкую форму (26–28 см), смазать маслом. Вливать в центр поочередно небольшие порции разного теста (по столовой ложке). Не перемешивать.Выпекать в предварительно разогретой духовке при температуре 200 градусов в течение получаса. Если верх пирога уже пропечется, а середина еще нет — следует накрыть пирог фольгой, уменьшить температуру до 180 градусов и выпекать до готовности.'],
        ['title' => 'Тонкое тесто для пиццы','tag' => 'Вода, Соль, Оливковое масло, Сухие дрожжи, Пшеничная мука', 'image' => '6.jpeg', 'author' => 'Ezharikov', 'blog' => 'Соединить муку, соль и дрожжи в кухонном комбайне. Соединить в кувшине масло и воду. Не выключая комбайн, влить жидкость и замесить однородное тесто. Переложить на стол, посыпанный мукой и месить тесто 2-3 мин.Переложить тесто в миску и смазать снаружи оливковым маслом. Накрыть миску пищевой пленкой и поставить в теплое место на 40 мин, пока тесто не увеличится в 2 раза.Снова месить тесто 1-2 мин. Раскатать тесто в круг 30 см и положить на противень. Сдавить 2 см от края, чтобы получилась корочка и наполнить начинкой на ваш выбор.'],

    ];

    private $commentData = [
        'Отличный рецепт',
        'Отвратительно',
        'Нормально',
        'Быстро и вкусно',
        'Слишком просто',
        'Слишком сложно',
    ];

    private $usersData = [
        ['login' => 'qwe', 'pwd' => '123','name' => 'Jack', 'surname' => 'Little', 'email' => '123@gmail.com','role' => ['ROLE_ADMIN'] ],
        ['login' => 'asd', 'pwd' => '111','name' => 'Bob', 'surname' => 'Smith', 'email' => 'smith@gmail.com','role' => ['ROLE_USER, ROLE_ADMIN']],
        ['login' => 'zxc', 'pwd' => '555555','name' => 'Anna', 'surname' => 'Karenina', 'email' => 'Ak@gmail.com','role' => ['ROLE_USER']],
        ['login' => 'llkv', 'pwd' => '555555','name' => 'Vanna', 'surname' => 'Букин', 'email' => 'Ak@gmail.com','role' => ['ROLE_USER']],
        ['login' => 'jlk', 'pwd' => '555555','name' => 'Иван', 'surname' => 'Лобанов', 'email' => 'Ak@gmail.com','role' => ['ROLE_USER']],
        ['login' => 'erg', 'pwd' => '555555','name' => 'Джим', 'surname' => 'Петров', 'email' => 'Ak@gmail.com','role' => ['ROLE_USER']],
    ];

    private function generateUsers(ObjectManager &$manager)
    {
        $users = [];
        foreach ($this->usersData as $data) {
            $user = new User();
            $user->setName($data['name']);
            $user->setLastname($data['surname']);
            $user->setEmail($data['email']);
            $user->setLogin($data['login']);
            $user->setHash($this->passwordHasher->hashPassword($user, $data['pwd']));
            $user->setRoles($data['role']);
            $manager->persist($user);
            $users[] = $user;
        }
        return $users;
    }

    private function generateBlogs(ObjectManager &$manager)
    {
        $users = $this->generateUsers($manager);
        $usersCount = count($users) - 1;
        $blogs = [];
        foreach ($this->blogsData as $data) {
            $blog = new Blog();
            $blog->setTitle($data['title']);
            $blog->setUser($users[rand(0, $usersCount)]);
            $blog->setBlog($data['blog']);
            $blog->setImage($data['image']);
            $blog->setAuthor($data['author']);
            $blog->setTags($data['tag']);
            $blog->setCreated(new \DateTime());
            $blog->setUpdated($blog->getCreated());
            $manager->persist($blog);
            $blogs[] = $blog;
        }
        return $blogs;
    }

    private function generateComments(ObjectManager &$manager){

        $blogs = $this->generateBlogs($manager);
        $blogsCount = count($blogs) - 1;
        $commentsCount = count($this->commentData) - 1;
        $users = $this->generateUsers($manager);
        $usersCount = count($users) - 1;
        for ($i = 0; $i < 30; $i++) {
            $comment = new Comment();
            $comment->setUser($users[rand(0, $usersCount)]);
            $comment->setComment($this->commentData[rand(0, $commentsCount)]);
            $comment->setBlog($blogs[rand(0,$blogsCount)]);
            $manager->persist($comment);
        }
    }


    public function load(ObjectManager $manager)
    {
//        $this->generateBlogs($manager);
//        $this->generateUsers($manager);
        $this->generateComments($manager);
        $manager->flush();



    }

}
