<?php
namespace AppBundle\Entity;
class BibliographieRepository
{
    private $bibliographies = [];
    public function __construct()
    {
        $b1 = new Bibliographie(1, 'matt',2012,'testtesttest');
        $b2 = new Bibliographie(2, 'joelle',1999,'testtesttest');
        $b3 = new Bibliographie(3, 'jim',2005,'testtesttest');
        $this->bibliographies[] = $b1;
        $this->bibliographies[] = $b2;
        $this->bibliographies[] = $b3;
    }
    public function getAll()
    {
        return $this->bibliographies;
    }
}