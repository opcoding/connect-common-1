<?php

namespace Fei\Service\Connect\Common\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Fei\Entity\AbstractEntity;

/**
 * Class AbstractTarget
 *
 * @Entity
 * @InheritanceType("JOINED")
 *
 * @package Fei\Service\Connect\Common\Entity
 */
abstract class AbstractTarget extends AbstractEntity
{
    /**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue(strategy="AUTO")
     *
     * @var int
     */
    protected $id;

    /**
     * @OneToMany(targetEntity="Attribution", mappedBy="target", cascade={"all"})
     *
     * @var Collection|Attribution[];
     */
    protected $attributions;

    /**
     * User constructor.
     *
     * @param array $data
     */
    public function __construct($data = null)
    {
        $this->setAttributions(new ArrayCollection());

        parent::__construct($data);
    }

    /**
     * Get Id
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set Id
     *
     * @param mixed $id
     *
     * @return $this
     */
    public function setId(int $id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set Attributions
     *
     * @param Collection $attributions
     *
     * @return $this
     */
    public function setAttributions(Collection $attributions)
    {
        if (!isset($this->attributions)) {
            $this->attributions = new ArrayCollection();
        }

        $this->getAttributions()->clear();

        /**
         * @var Attribution $attr
         */
        foreach ($attributions as $attr) {
            $attr->setTarget($this);
            $this->getAttributions()->add($attr);
        }

        return $this;
    }

    /**
     * Get Attributions
     *
     * @return Collection|Attribution[]
     */
    public function getAttributions()
    {
        return $this->attributions;
    }

    /**
     * Add application groups
     *
     * @param Attribution[] $attributions
     *
     * @return $this
     */
    public function addAttributions(Attribution ...$attributions)
    {
        foreach ($attributions as $attribution) {
            $this->getAttributions()->add($attribution);
        }

        return $this;
    }

    /**
     * @inheritdoc
     */
    public function hydrate($data)
    {
        $attributions = new ArrayCollection();

        if (!empty($data['attributions'])) {
            foreach ($data['attributions'] as $attribution) {
                $attributions->add(
                    (new Attribution($attribution))
                        ->setTarget($this)
                );
            }
        }

        $data['attributions'] = $attributions;

        return parent::hydrate($data);
    }
}
