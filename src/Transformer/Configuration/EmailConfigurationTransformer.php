<?php

namespace Fei\Service\Connect\Common\Transformer\Configuration;

use Fei\Service\Connect\Common\Entity\Configuration\Configuration;
use Fei\Service\Connect\Common\Entity\Configuration\ConfigurationInterface;
use Fei\Service\Connect\Common\Entity\Configuration\EmailConfiguration;

/**
 * Class EmailConfigurationTransformer
 *
 * @package Fei\Service\Connect\Common\Transformer\Configuration
 */
class EmailConfigurationTransformer implements ConfigurationTransformerInterface
{
    const EMAIL_SENDER         = 'email_sender';
    const EMAIL_SUBJECT_PREFIX = 'email_subject_prefix';
    const EMAIL_BODY_SIGNATURE = 'email_body_signature';

    /**
     * @inheritdoc
     *
     * @param EmailConfiguration $config
     */
    public function transform(ConfigurationInterface $config)
    {
        return [
            self::EMAIL_SENDER         => $config->getEmailSender(),
            self::EMAIL_SUBJECT_PREFIX => $config->getEmailSubjectPrefix(),
            self::EMAIL_BODY_SIGNATURE => $config->getEmailBodySignature()
        ];
    }

    /**
     * @inheritdoc
     *
     * @return EmailConfiguration
     */
    public function extract(Configuration ...$configurations)
    {
        $emailConfiguration = new EmailConfiguration();

        foreach ($configurations as $configuration) {
            switch($configuration->getKey()) {
                case self::EMAIL_SENDER:
                    $emailConfiguration->setEmailSender($configuration->getValue());
                    break;
                case self::EMAIL_SUBJECT_PREFIX:
                    $emailConfiguration->setEmailSubjectPrefix($configuration->getValue());
                    break;
                case self::EMAIL_BODY_SIGNATURE:
                    $emailConfiguration->setEmailBodySignature($configuration->getValue());
                    break;
            }
        }

        return $emailConfiguration;
    }
}