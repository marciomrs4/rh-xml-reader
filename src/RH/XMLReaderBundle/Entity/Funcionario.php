<?php

namespace RH\XMLReaderBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Funcionario
 *
 * @ORM\Table(name="funcionario")
 * @ORM\Entity(repositoryClass="RH\XMLReaderBundle\Repository\FuncionarioRepository")
 * @UniqueEntity(fields={"cpf"},ignoreNull=true,message="Já Existe este CPF cadastrado")
 * @Gedmo\Loggable()
 */
class Funcionario
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
     * @ORM\Column(name="nome", type="string", length=255)
     * @Gedmo\Versioned()
     */
    private $nome;

    /**
     * @var string
     *
     * @ORM\Column(name="cpf", type="string", length=255, unique=true)
     * @Assert\NotBlank(message="O campo CPF é Obrigatório!")
     * @Gedmo\Versioned()
     */
    private $cpf;

    /**
     * @var string
     *
     * @ORM\Column(name="drt", type="string", length=255, unique=true)
     * @Gedmo\Versioned()
     */
    private $drt;

    /**
     * @var string
     *
     * @ORM\Column(name="pis", type="string", length=255, unique=true)
     * @Gedmo\Versioned()
     */
    private $pis;

    /**
     * @var boolean
     *
     * @ORM\Column(name="status", type="boolean")
     * @Gedmo\Versioned()
     */
    private $status;




    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set nome
     *
     * @param string $nome
     *
     * @return Funcionario
     */
    public function setNome($nome)
    {
        $this->nome = $nome;

        return $this;
    }

    /**
     * Get nome
     *
     * @return string
     */
    public function getNome()
    {
        return $this->nome;
    }

    /**
     * Set cpf
     *
     * @param string $cpf
     *
     * @return Funcionario
     */
    public function setCpf($cpf)
    {
        $this->cpf = $cpf;

        return $this;
    }

    /**
     * Get cpf
     *
     * @return string
     */
    public function getCpf()
    {
        return $this->cpf;
    }

    /**
     * Set drt
     *
     * @param string $drt
     *
     * @return Funcionario
     */
    public function setDrt($drt)
    {
        $this->drt = $drt;

        return $this;
    }

    /**
     * Get drt
     *
     * @return string
     */
    public function getDrt()
    {
        return $this->drt;
    }

    /**
     * Set pis
     *
     * @param string $pis
     *
     * @return Funcionario
     */
    public function setPis($pis)
    {
        $this->pis = $pis;

        return $this;
    }

    /**
     * Get pis
     *
     * @return string
     */
    public function getPis()
    {
        return $this->pis;
    }

    /**
     * Set status
     *
     * @param boolean $status
     *
     * @return Funcionario
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean
     */
    public function getStatus()
    {
        return $this->status;
    }
}
