<?php
namespace Kerox\Messenger\Test\TestCase\Model\ProfileSettings;

use Kerox\Messenger\Model\Common\Button\Nested;
use Kerox\Messenger\Model\Common\Button\PhoneNumber;
use Kerox\Messenger\Model\Common\Button\Postback;
use Kerox\Messenger\Model\Common\Button\WebUrl;
use Kerox\Messenger\Model\ProfileSettings\PersistentMenu;
use Kerox\Messenger\Test\TestCase\AbstractTestCase;

class PersistentMenuTest extends AbstractTestCase
{

    public function testInvalidButton()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Array can only contain instance of AbstractButton.');

        $persistentMenu = (new PersistentMenu())->setComposerInputDisabled(true)->addButtons([
            'Phone Number' => [
                'payload' => 'PHONE_NUMBER_PAYLOAD'
            ],
        ]);
    }

    public function testInvalidButtonType()
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Buttons can only be an instance of web_url, postback, nested');

        $persistentMenu = (new PersistentMenu())->setComposerInputDisabled(true)->addButtons([
            (new PhoneNumber('Phone number', 'PHONE_NUMBER_PAYLOAD')),
            (new Nested('My Account', [
                new Postback('Pay Bill', 'PAYBILL_PAYLOAD'),
                new Postback('History', 'HISTORY_PAYLOAD'),
                new Postback('Contact Info', 'CONTACT_INFO_PAYLOAD'),
            ])),
            (new WebUrl('Latest News', 'http://petershats.parseapp.com/hat-news'))->setWebviewHeightRatio('full')
        ]);
    }
}