<?php

namespace Fei\Service\Connect\Common\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Fei\Entity\AbstractEntity;
use Fei\Service\Connect\Common\Transformer\UserGroupMinimalTransformer;
use Fei\Service\Connect\Common\Transformer\UserMinimalTransformer;

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
     * @Column(type="boolean")
     *
     * @var bool
     */
    protected $allowProfileAssociation = false;

    /**
     * @OneToMany(targetEntity="Attribution", mappedBy="target", cascade={"all"})
     *
     * @var ArrayCollection|Attribution[];
     */
    protected $attributions;

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
     * Get AllowProfileAssociation
     *
     * @return bool
     */
    public function getAllowProfileAssociation()
    {
        return $this->allowProfileAssociation;
    }

    /**
     * Set AllowProfileAssociation
     *
     * @param bool $allowProfileAssociation
     *
     * @return $this
     */
    public function setAllowProfileAssociation($allowProfileAssociation)
    {
        $this->allowProfileAssociation = $allowProfileAssociation;

        return $this;
    }

    /**
     * @return ArrayCollection|Attribution[]
     */
    public function getAttributions()
    {
        return $this->attributions;
    }

    /**
     * @param ArrayCollection|Attribution[] $attributions
     * @return $this
     */
    public function setAttributions($attributions)
    {
        $this->attributions = $attributions;
        return $this;
    }

    public function toArray($mapped = false)
    {
        $array = parent::toArray($mapped);

        $users = [];
        $userGroups = [];
        if (!is_null($this->getAttributions()) && !$this->getAttributions()->isEmpty()) {
            $userMinimalTransformer = new UserMinimalTransformer();
            $applicationGroupTransformer = new UserGroupMinimalTransformer();
            foreach ($this->getAttributions() as $attrib) {
                $source = $attrib->getSource();
                $idrole = $attrib->getRole()->getId();
                if ($source instanceof User) {
                    $user = $userMinimalTransformer->transform($source);
                    $user['idrole'] = $idrole;
                    $users[] = $user;
                } elseif ($source instanceof UserGroup) {
                    $userGroup = $applicationGroupTransformer->transform($source);
                    $userGroup['idrole'] = $idrole;
                    $userGroups[] = $userGroup;
                }
            }
        }

        $array['users'] = $users;
        $array['userGroups'] = $userGroups;

        return $array;
    }
}
