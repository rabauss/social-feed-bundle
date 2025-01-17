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

namespace Pdir\SocialFeedBundle\Tests;

use Pdir\SocialFeedBundle\PdirSocialFeedBundle;
use PHPUnit\Framework\TestCase;

class PdirSocialFeedBundleTest extends TestCase
{
    public function testCanBeInstantiated(): void
    {
        $bundle = new PdirSocialFeedBundle();

        $this->assertInstanceOf('Pdir\SocialFeedBundle\PdirSocialFeedBundle', $bundle);
    }
}
