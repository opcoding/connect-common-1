<?php

namespace Fei\Service\Connect\Common\Transformer;

use Fei\Service\Connect\Common\Entity\UserGroup;
use League\Fractal\TransformerAbstract;

/**
 * Class UserGroupMinimalTransformer
 *
 * @package Fei\Service\Connect\Transformer
 */
class UserGroupMinimalTransformer extends TransformerAbstract
{
    /**
     * @param UserGroup $userGroup
     * @return array
     */
    public function transform(UserGroup $userGroup)
    {
        return [
            'id' => $userGroup->getId(),
            'name' => $userGroup->getName(),
            'defaultRole' => $userGroup->getDefaultRole()
        ];
    }
}