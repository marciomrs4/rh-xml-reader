<?php

namespace RH\XMLReaderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * FileFuncionario
 *
 * @ORM\Table(name="file_funcionario")
 * @ORM\Entity(repositoryClass="RH\XMLReaderBundle\Repository\FileFuncionarioRepository")
 */
class FileFuncionario
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="fileName", type="string", length=255)
     */
    private $fileName;

    /**
     * @var File
     * @Assert\File(mimeTypes={"application/xml"})
     */
    private $file;



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
     *
     */
    public function getFile()
    {

        return $this->file;

    }

    /**
     * @param File |\Symfony\Component\HttpFoundation\File\UploadedFile $file
     * @return $this
     */
    public function setFile(File $file)
    {

        return $this;
    }

    /**
     * Set fileName
     *
     * @param string $fileName
     *
     * @return FileFuncionario
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;

        return $this;
    }

    /**
     * Get fileName
     *
     * @return string
     */
    public function getFileName()
    {
        return $this->fileName;
    }
}
