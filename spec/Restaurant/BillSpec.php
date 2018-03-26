<?php

namespace spec\Restaurant;

use Restaurant\Bill;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Restaurant\Priced;

class BillSpec extends ObjectBehavior
{
    function let(Priced $item)
    {
        $item->price()->willReturn(1000);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Bill::class);
    }

    function it_has_no_items_by_default()
    {
        $this->getTotal()->shouldBe(0);
    }

    function it_adds_an_item(Priced $item)
    {
        $this->addItem($item);
        $this->getTotal()->shouldBe(1100);
    }

    function it_adds_multiple_items(Priced $item, Priced $anotherItem)
    {
        $anotherItem->price()->willReturn(2000);
        $this->addItem($item);
        $this->addItem($anotherItem);
        $this->getTotal()->shouldBe(3300);
    }

    function it_can_be_paid_with_money(Priced $item)
    {
        $this->addItem($item);
        $this->payWithMoney(1100);
        $this->restToPay()->shouldBe(0);
    }

    function it_can_give_points_when_is_payed_with_money(Priced $item)
    {
        $this->addItem($item);
        $this->payWithMoney(1100);
        $this->getPoints()->shouldBe(10);
    }

    function it_can_not_give_points_when_total_is_not_enough(Priced $anotherItem)
    {
        $anotherItem->price()->willReturn(99);

        $this->addItem($anotherItem);
        $this->payWithMoney(109);
        $this->getPoints()->shouldBe(0);
    }

    function it_can_be_paith_with_money_and_points_and_get_no_points(Priced $item)
    {
        $this->addItem($item);
        $this->payWithMoney(1000);
        $this->payWithPoints(10);
        $this->restToPay()->shouldBe(0);
        $this->getPoints()->shouldBe(0);
    }

    function it_can_not_pay_VAT_with_points(Priced $item)
    {
        $this->addItem($item);
        $this->payWithPoints(110);
        $this->restToPay()->shouldBe(100);
    }
}
