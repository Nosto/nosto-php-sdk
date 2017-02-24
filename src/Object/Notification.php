<?php
/**
 * Copyright (c) 2017, Nosto Solutions Ltd
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without modification,
 * are permitted provided that the following conditions are met:
 *
 * 1. Redistributions of source code must retain the above copyright notice,
 * this list of conditions and the following disclaimer.
 *
 * 2. Redistributions in binary form must reproduce the above copyright notice,
 * this list of conditions and the following disclaimer in the documentation
 * and/or other materials provided with the distribution.
 *
 * 3. Neither the name of the copyright holder nor the names of its contributors
 * may be used to endorse or promote products derived from this software without
 * specific prior written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
 * ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
 * WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
 * DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDER OR CONTRIBUTORS BE LIABLE FOR
 * ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
 * (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
 * LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON
 * ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
 * SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * @author Nosto Solutions Ltd <contact@nosto.com>
 * @copyright 2017 Nosto Solutions Ltd
 * @license http://opensource.org/licenses/BSD-3-Clause BSD 3-Clause
 *
 */

namespace Nosto\Object;

use Nosto\Exception\NostoException;
use Nosto\Types\NotificationInterface;

/**
 * Implementation for NotificationInterface
 * @codeCoverageIgnore
 */
class Notification extends AbstractObject implements NotificationInterface
{
    /**
     * @var int|string unique id of the store
     */
    private $storeId;

    /**
     * @var string the name of the store
     */
    private $storeName;

    /**
     * @var int|string unique id of language
     */
    private $languageId;

    /**
     * @var string the name of the language
     */
    private $languageName;

    /**
     * @var string notification message
     */
    private $message;

    /**
     * @var int type of the notification
     * @see NotificationInterface::TYPE_* constants
     */
    private $notificationType;

    /**
     * @var int severity of the notification
     * @see NotificationInterface::SEVERITY_* constants
     */
    private $notificationSeverity;

    /**
     * @var array of attributes required by the message
     */
    private $messageAttributes;

    /**
     * @inheritdoc
     */
    public function getStoreId()
    {
        return $this->storeId;
    }

    /**
     * Setter for store id
     *
     * @param int|string $storeId
     */
    public function setStoreId($storeId)
    {
        $this->storeId = $storeId;
    }

    /**
     * @inheritdoc
     */
    public function getStoreName()
    {
        return $this->storeName;
    }

    /**
     * Setter for store name
     *
     * @param string $storeName
     */
    public function setStoreName($storeName)
    {
        $this->storeName = $storeName;
    }

    /**
     * @inheritdoc
     */
    public function getLanguageId()
    {
        return $this->languageId;
    }

    /**
     * Setter for language id
     *
     * @param int /string $languageId
     */
    public function setLanguageId($languageId)
    {
        $this->languageId = $languageId;
    }

    /**
     * @inheritdoc
     */
    public function getLanguageName()
    {
        return $this->languageName;
    }

    /**
     * Setter for language name
     * @param string $languageName
     */
    public function setLanguageName($languageName)
    {
        $this->languageName = $languageName;
    }

    /**
     * @inheritdoc
     */
    public function getNotificationType()
    {
        return $this->notificationType;
    }

    /**
     * Setter for notification type
     *
     * @see NotificationInterface::TYPE_*
     * @param int $notificationType
     */
    public function setNotificationType($notificationType)
    {
        $this->notificationType = $notificationType;
    }

    /**
     * @inheritdoc
     */
    public function getNotificationSeverity()
    {
        return $this->notificationSeverity;
    }

    /**
     * Setter for notification severity
     *
     * @see NotificationInterface::SEVERITY_*
     * @param mixed $notificationSeverity
     */
    public function setNotificationSeverity($notificationSeverity)
    {
        $this->notificationSeverity = $notificationSeverity;
    }

    /**
     * Adds a message attribute
     *
     * @param int|string $messageAttribute
     * @throws NostoException
     */
    public function addMessageAttribute($messageAttribute)
    {
        if (!is_scalar($messageAttribute)) {
            throw new NostoException('Message attribute must be a scalar value');
        }
        $this->messageAttributes[] = $messageAttribute;
    }

    /**
     * Returns formatted message
     *
     * @return string
     */
    public function formatMessage()
    {
        return vsprintf(
            $this->getMessage(),
            $this->getMessageAttributes()
        );
    }

    /**
     * @inheritdoc
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Setter for message
     *
     * @param mixed $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @inheritdoc
     */
    public function getMessageAttributes()
    {
        return $this->messageAttributes;
    }

    /**
     * Sets all message attributes
     *
     * @param array $messageAttributes
     */
    public function setMessageAttributes(array $messageAttributes)
    {
        $this->messageAttributes = $messageAttributes;
    }
}
