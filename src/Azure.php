<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace chunlaw\authclient;

use yii\authclient\OAuth2;

/**
 * Azure allows authentication via Microsoft Azure OAuth.
 *
 * In order to use Microsoft Azure OAuth you must register your application at <https://portal.azure.com/>
 *
 * Example application configuration:
 *
 * ```php
 * 'components' => [
 *     'authClientCollection' => [
 *         'class' => 'yii\authclient\Collection',
 *         'clients' => [
 *             'live' => [
 *                 'class' => 'yii\authclient\clients\Azure',
 *                 'clientId' => 'azure_client_id',
 *                 'clientSecret' => 'azure_client_secret',
 *             ],
 *         ],
 *     ]
 *     // ...
 * ]
 * ```
 *
 * @see https://docs.microsoft.com/en-us/azure/active-directory/develop/
 * @see https://docs.microsoft.com/en-us/azure/active-directory/develop/v2-oauth2-auth-code-flow
 *
 * @author Law Wai Chun <chun10161991@gmail.com>
 * @since 2.0
 */
class Azure extends OAuth2
{
    /**
     * {@inheritdoc}
     */
    //public $authUrl = 'https://login.microsoftonline.com/037b8405-eda8-45ed-b013-9b72af6c9c80/oauth2/v2.0/authorize';
    /**
     * {@inheritdoc}
     */
    //public $tokenUrl = 'https://login.microsoftonline.com/037b8405-eda8-45ed-b013-9b72af6c9c80/oauth2/v2.0/token';
    /**
     * {@inheritdoc}
     */
    public $apiBaseUrl = 'https://graph.microsoft.com/v1.0';

    public $scope = /*'https://graph.microsoft.com/.default offline_access'; */'https://outlook.office.com/IMAP.AccessAsUser.All offline_access';


    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();
        if ($this->scope === null) {
            $this->scope = 'user.read';
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function initUserAttributes()
    {
        return $this->api('me', 'GET');
    }

    public function applyAccessTokenToRequest($request, $accessToken)
    {
        $request->addHeaders(['Authorization' => 'Bearer '. $accessToken->getToken()]);
    }

    /**
     * {@inheritdoc}
     */
    protected function defaultName()
    {
        return 'live'; // to use the Microsoft icon provided by yiisoft/yii2-authclient'
    }

    /**
     * {@inheritdoc}
     */
    protected function defaultTitle()
    {
        return 'Azure';
    }
}
