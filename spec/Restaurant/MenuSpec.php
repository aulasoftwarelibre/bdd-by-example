<?php

namespace spec\Restaurant;

use Restaurant\Menu;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MenuSpec extends ObjectBehavior
{
    const NUMBER = 10;
    const PRICE = 2500;

    function let()
    {
        $this->beConstructedWith(self::NUMBER, self::PRICE);
    }

    function it_implements_price_interface()
    {
        $this->shouldImplement(\Restaurant\Priced::class);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(Menu::class);
    }

    function it_has_a_menu_number()
    {
        $this->number()->shouldBe(self::NUMBER);
    }

    function it_has_a_price()
    {
        $this->price()->shouldBe(self::PRICE);
    }
}
