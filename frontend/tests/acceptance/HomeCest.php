<?php
class FirstCest
{
    public function _before(AcceptanceTester $I)
    {
    }


    public function testSiteIndex(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->see('My Yii Application');
    }

    public function testSiteAbout(AcceptanceTester $I)
    {
        $I->amOnPage('/site/about');
        $I->see('About');
    }

    public function testSiteContact(AcceptanceTester $I)
    {
        $I->amOnPage('/site/contact');
        $I->see('Contact');
    }

    public function testSiteLogin(AcceptanceTester $I)
    {
        $I->amOnPage('/site/login');
        $I->fillField('LoginForm[username]', 'test');
        $I->fillField('LoginForm[password]', '123456');
        $I->click('.btn-primary');
        $I->see('test');
    }

    public function testSiteLogout(AcceptanceTester $I)
    {
        $I->amOnPage('/site/login');
        $I->fillField('LoginForm[username]', 'test');
        $I->fillField('LoginForm[password]', '123456');
        $I->click('Sign In');
        $I->see('test');
        $I->click('Logout');
        $I->see('Login');
    }

}
