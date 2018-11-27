<?php
/**
 * Created by PhpStorm.
 * User: Vladislav
 * Date: 27.11.2018
 * Time: 18:04
 */

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity()
 * @ApiResource()
 */
class Post
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $header;

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
     * @ORM\Column(type="date")
     */
    private $createDate;

    /**
     * @ORM\Column(type="blob")
     */
    private $imagePreview;

}