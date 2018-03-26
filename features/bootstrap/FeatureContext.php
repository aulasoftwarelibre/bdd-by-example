<?php

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

/**
 * Defines application features from the specific context.
 */
class FeatureContext implements Context
{
    private $menus;
    private $bill;

    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
        $this->menus = [];
        $this->bill = new \Restaurant\Bill();
    }

    /**
     * @Given los siguientes menús:
     */
    public function losSiguientesMenus(TableNode $table)
    {
        foreach ($table->getHash() as $menu) {
            $this->menus[$menu['número']] = new \Restaurant\Menu($menu['número'], $menu['precio'] * 100);
        }
    }

    /**
     * @Given que he comprado :arg1 menús del número :arg2
     * @Given que he comprado :arg1 menú del número :arg2
     */
    public function queHeCompradoMenusDelNumero($count, $menuNumber)
    {
        $menu = $this->menus[$menuNumber];

        for($i = 0; $i < $count; $i++) {
            $this->bill->addItem($menu);
        }
    }

    /**
     * @When pido la cuenta recibo una factura de :arg1 euros
     */
    public function pidoLaCuentaReciboUnaFacturaDeEuros($total)
    {
        \PHPUnit\Framework\Assert::assertEquals($total * 100, $this->bill->getTotal());
    }

    /**
     * @When pago en efectivo con :arg1 euros
     */
    public function pagoEnEfectivoConEuros($amount)
    {
        $this->bill->payWithMoney($amount * 100);
    }

    /**
     * @Then la factura está pagada
     */
    public function laFacturaEstaPagada()
    {
        \PHPUnit\Framework\Assert::assertEquals(0, $this->bill->restToPay());
    }

    /**
     * @Then he obtenido :arg1 puntos
     */
    public function heObtenidoPuntos($points)
    {
        \PHPUnit\Framework\Assert::assertEquals($points, $this->bill->getPoints());
    }

    /**
     * @When pago con :points puntos y :money euros
     */
    public function pagoConPuntosYEuros($points, $money)
    {
        $this->bill->payWithMoney($money * 100);
        $this->bill->payWithPoints($points);
    }

    /**
     * @Then quedan :amount euros por pagar
     */
    public function quedanEurosPorPagar($amount)
    {
        \PHPUnit\Framework\Assert::assertEquals($amount * 100, $this->bill->restToPay());
    }#
}
