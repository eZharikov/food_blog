<?php

namespace App\Entity;

use App\Repository\BlogRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Transliterator;

/**
 * @ORM\Entity(repositoryClass=BlogRepository::class)
 * @ORM\Table(name="blog")
 * @ORM\HasLifecycleCallbacks
 */
class Blog
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $title;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $author;

    /**
     * @ORM\Column(type="text")
     */
    private $blog;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $image;

    /**
     * @ORM\Column(type="text")
     */
    private $tags;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="blog")
     */
    private $comments = [];

    /**
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $slug;


    public function __construct()
    {
        $this->setCreated(new \DateTime());
        $this->setUpdated(new \DateTime());
        $this->comments = new ArrayCollection();
    }

    /**
     * @ORM\PreUpdate
     */
    public function setUpdatedValue()
    {
        $this->setUpdated(new \DateTime());
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;
        $this->setSlug($this->title);

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }


    public function getAuthor(): ?string
    {
        return $this->author;
    }

    public function setAuthor(string $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getBlog($length = null)
    {
        if (false === is_null($length) && $length > 0)
            return substr($this->blog, 0, $length);
        else
            return $this->blog;
    }

    public function setBlog(string $blog): self
    {
        $this->blog = $blog;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getTags(): ?string
    {
        return $this->tags;
    }

    public function setTags(string $tags): self
    {
        $this->tags = $tags;

        return $this;
    }


    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    public function getUpdated(): ?\DateTimeInterface
    {
        return $this->updated;
    }

    public function setUpdated(\DateTimeInterface $updated): self
    {
        $this->updated = $updated;

        return $this;
    }

    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function removeComments(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getBlog() === $this) {
                $comment->setBlog(null);
            }
        }

        return $this;
    }

    public function addComments(Comment $comment)
    {
        $this->comments[] = $comment;
    }


    public function setComments(string $comments): self
    {
        $this->comments = $comments;

        return $this;
    }

    public function __toString()
    {
        return $this->getTitle();
    }
//    public function __toString()
//    {
//        return $this->user;
//    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $this->slugify($slug);

        return $this;
    }

    public function slugify($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('#[^\\pL\d]+#u', '-', $text);

        // trim
        $text = trim($text, '-');

        // transliterate
        if (extension_loaded('intl')) {
            $translit = Transliterator::create('Any-Latin; Latin-ASCII');
            $text = $translit->transliterate($text);
        } else {
            $map = array(
                'а' => 'a',   'б' => 'b',   'в' => 'v',  'г' => 'g',  'д' => 'd',  'е' => 'e',  'ж' => 'zh', 'з' => 'z',
                'и' => 'i',   'й' => 'y',   'к' => 'k',  'л' => 'l',  'м' => 'm',  'н' => 'n',  'о' => 'o',  'п' => 'p',
                'р' => 'r',   'с' => 's',   'т' => 't',  'у' => 'u',  'ф' => 'f',  'х' => 'h',  'ц' => 'ts', 'ч' => 'ch',
                'ш' => 'sh',  'щ' => 'sht', 'ъ' => 'y',  'ы' => 'y',  'ь' => '\'', 'ю' => 'yu', 'я' => 'ya', 'А' => 'A',
                'Б' => 'B',   'В' => 'V',   'Г' => 'G',  'Д' => 'D',  'Е' => 'E',  'Ж' => 'Zh', 'З' => 'Z',  'И' => 'I',
                'Й' => 'Y',   'К' => 'K',   'Л' => 'L',  'М' => 'M',  'Н' => 'N',  'О' => 'O',  'П' => 'P',  'Р' => 'R',
                'С' => 'S',   'Т' => 'T',   'У' => 'U',  'Ф' => 'F',  'Х' => 'H',  'Ц' => 'Ts', 'Ч' => 'Ch', 'Ш' => 'Sh',
                'Щ' => 'Sht', 'Ъ' => 'Y',   'Ь' => '\'', 'Ю' => 'Yu', 'Я' => 'Ya'
            );
            $text = strtr($text, $map);
        }

        // lowercase
        $text = strtolower($text);

        // remove unwanted characters
        $text = preg_replace('#[^-\w]+#', '', $text);

        if (empty($text))
        {
            return 'n-a';
        }

        return $text;
    }
}
