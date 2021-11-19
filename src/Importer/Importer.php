<?php

declare(strict_types=1);

/*
 * social feed bundle for Contao Open Source CMS
 *
 * Copyright (c) 2021 pdir / digital agentur // pdir GmbH
 *
 * @package    social-feed-bundle
 * @link       https://github.com/pdir/social-feed-bundle
 * @license    http://www.gnu.org/licences/lgpl-3.0.html LGPL
 * @author     Mathias Arzberger <develop@pdir.de>
 * @author     Philipp Seibt <develop@pdir.de>
 * @author     pdir GmbH <https://pdir.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pdir\SocialFeedBundle\Importer;

use Contao\Date;
use Contao\System;
use Pdir\SocialFeedBundle\Model\SocialFeedModel;

class Importer
{
    /**
     * @var InstagramClient
     */
    protected $client;

    /*
     * account image uuid
     */
    private $accountImage;

    /**
     * Collect data from the instagram api and return array.
     *
     * @throws \RuntimeException
     *
     * @return void|array
     */
    public function getInstagramPosts($accessToken, $socialFeedId, $numberPosts)
    {
        if ('' === $accessToken) {
            return 'no access token given';
        }

        $client = System::getContainer()->get(InstagramClient::class);
        $items = $client->getMediaData($accessToken, (int) $socialFeedId, (int) $numberPosts);

        return $items['data'];
    }

    public function getAccountImage()
    {
        return $this->accountImage;
    }

    /**
     * Collect data from the instagram api and return array.
     *
     * @return void|array
     */
    public function getInstagramAccount($accessToken, $socialFeedId)
    {
        $client = System::getContainer()->get(InstagramClient::class);

        return $client->getUserData($accessToken, (int) $socialFeedId);
    }

    /**
     * Collect data from the instagram api and return array.
     *
     * @return void|array
     */
    public function getInstagramAccountImage($accessToken, $socialFeedId)
    {
        $client = System::getContainer()->get(InstagramClient::class);

        return $client->getUserImage($accessToken, (int) $socialFeedId, false);
    }

    public function moderation($items)
    {
        $listItems = [];

        foreach ($items as $item) {
            $listItems[] = [
                'id' => $item['id'],
                'title' => $item['caption'],
                'time' => Date::parse($GLOBALS['TL_CONFIG']['datimFormat'], strtotime($item['timestamp'])),
                'image' => false !== strpos($item['media_url'], 'jpg') ? $item['media_url'] : $item['thumbnail_url'],
                'link' => $item['permalink'],
            ];
        }

        return $listItems;
    }

    public function getPostsByAccount($id, $numberPosts)
    {
        $objSocialFeed = SocialFeedModel::findBy('id', $id);

        if (null === $objSocialFeed) {
            return;
        }

        switch ($objSocialFeed->socialFeedType) {
            case 'Facebook':
                return 'Facebook is currently not supported.';
                break;

            case 'Instagram':
                return $this->getInstagramPosts($objSocialFeed->psf_instagramAccessToken, $objSocialFeed->id, $numberPosts);
                break;

            case 'Twitter':
                return 'Twitter is currently not supported.';
                break;
        }
    }
}
