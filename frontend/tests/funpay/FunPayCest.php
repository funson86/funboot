<?php 

class FunPayCest
{
    public function _before(AcceptanceTester $I)
    {
    }

    // tests
    public function testPayIndex(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->see('FunPay');
    }

    public function testPayPay(AcceptanceTester $I)
    {
        $I->amOnPage('/pay/default/pay');
        $I->see('确认订单');

        $I->fillField('Payment[name]', 'funson');
        $I->fillField('Payment[email]', 'funson86@gmail.com');
        $I->fillField('Payment[money]', 10);
        $I->fillField('Payment[remark]', 'acceptance test');
        $I->fillField('Payment[email_exp]', '3375074@qq.com');
        $I->click('.btn-primary');
        $I->see('FunPay收银台');
    }


    // tests
    public function testPayList(AcceptanceTester $I)
    {
        $I->amOnPage('/pay/default/list');
        $I->see('捐赠名单');
    }

}
