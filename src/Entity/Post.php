<?php


namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\Collection;


/**
 * @ORM\Entity()
 * @ApiResource()
 */
class Post
{
    public function __construct()
    {
        $this->createDate = new \DateTime();
        $this->likes = rand(0,999999);
        $this->comments = new ArrayCollection();
     }

    /**
     * @return mixed
     */

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Comment", mappedBy="post", orphanRemoval=true)
     */
    private $comments;
    /**
     * @ORM\Column(type="boolean")
     */
    private $isActive;

    /**
     * @ORM\Column(type="string")
     */
    private $header;

    /**
     *
     * @ORM\Column(type="string")
     */
    private $content;

    /**
     * @ORM\Column(type="string")
     */
    private $teaser;

    /**
     * @ORM\Column(type="integer")
     */
    private $likes;

    /**
     * @ORM\Column(type="string")
     */
    private $author;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createDate;

    /**
     * @ORM\Column(type="string")
     */
    private $imagePreview;

    /**
     * @return mixed
     */

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * @param mixed $header
     */
    public function setHeader($header): void
    {
        $this->header = $header;
    }

    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content): void
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getTeaser()
    {
        return $this->teaser;
    }

    /**
     * @param mixed $teaser
     */
    public function setTeaser($teaser): void
    {
        $this->teaser = $teaser;
    }
    public function getIsActive()
    {
        return $this->isActive;
    }
    public function setIsActive($isActive): void
    {
        $this->isActive = $isActive;
    }
    /**
     * @return mixed
     */
    public function getLikes()
    {
        return $this->likes;
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     */
    public function setAuthor($author): void
    {
        $this->author = $author;
    }

    /**
     * @return mixed
     */
    public function getCreateDate()
    {
        return $this->createDate;
    }

    /**
     * @return mixed
     */
    public function getImagePreview()
    {
        return $this->imagePreview;
    }


    public function setImagePreview($imagePreview)
    {
        $this->imagePreview = $imagePreview;
        return $this;
    }
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setPost($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->contains($comment)) {
            $this->comments->removeElement($comment);
            // set the owning side to null (unless already changed)
            if ($comment->getPost() === $this) {
                $comment->setPost(null);
            }
        }

        return $this;
    }

    public function generateUniqueFileName()
    {
        return md5(uniqid());
    }
}