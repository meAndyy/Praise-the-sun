<?php
namespace AppBundle\Entity;

 use Doctrine\ORM\Mapping as ORM;

    /**
     * @ORM\Entity
     * @ORM\Table(name="students")
     */
class Bibliographie
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;
    /**
     * @ORM\Column(type="integer")
     */
    private $publishDate;
    /**
     * @ORM\Column(type="string", length=100)
     */
    private $info;

   // public function __construct($id, $name){
          //  $this->id = $id;
           // $this->name = $name;
           // $this->date = $date;
            //$this->info = $info;
       // }


    /**
     * Set name
     *
     * @param string $name
     *
     * @return Bibliographie
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Set publishDate
     *
     * @param integer $publishDate
     *
     * @return Bibliographie
     */
    public function setPublishDate($publishDate)
    {
        $this->publishDate = $publishDate;

        return $this;
    }

    /**
     * Get publishDate
     *
     * @return integer
     */
    public function getPublishDate()
    {
        return $this->publishDate;
    }

    /**
     * Set info
     *
     * @param string $info
     *
     * @return Bibliographie
     */
    public function setInfo($info)
    {
        $this->info = $info;

        return $this;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get info
     *
     * @return string
     */
    public function getInfo()
    {
        return $this->info;
    }
}
