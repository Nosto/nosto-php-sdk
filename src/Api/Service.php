<?php

/**
 * Created by PhpStorm.
 * User: mridangagarwalla
 * Date: 02/12/15
 * Time: 18:37
 */
/**
 * Interface for export collections.
 */
interface NostoAPIParams
{
    /**
     * Sets the module version which will be used as value for the X-Plugin-Version header
     *
     * @param string $version The module version
     */
    public function setModuleVersion(string $version);

    /**
     * Sets the module version which will be used as value for the X-Plugin-Version header
     *
     * @returns The module version
     */
    public function getModuleVersion();

    /**
     * Sets the platform version which will be used as value for the X-Plaform-Version header
     *
     * @param string $version The platform version
     */
    public function setPlatformVersion(String $version);

    /**
     * Sets the platform version which will be used as value for the X-Plaform-Version header
     *
     * @returns The platform version
     */
    public function getPlatformVersion();

    /**
     * Sets the plugin version which will be used as value for the X-Unique-Id header
     *
     * @param string $version The unique identifier
     */
    public function setUniqueId(String $id);

    /**
     * Sets the plugin version which will be used as value for the X-Unique-Id header
     *
     * @returns The unique identifier
     */
    public function getUniqueId();

    /**
     * Sets the plugin version which will be used as value for the X-Merchant-Id header
     *
     * @param string $version The merchant identifier
     */
    public function setMerchantId(String $id);

    /**
     * Sets the plugin version which will be used as value for the X-Merchant-Id header
     *
     * @returns The merchant identifier
     */
    public function getMerchantId();
}