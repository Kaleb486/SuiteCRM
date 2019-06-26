<?php

use Faker\Generator;

class ProductsCest
{
    /**
     * @var Generator $fakeData
     */
    protected $fakeData;

    /**
     * @var integer $fakeDataSeed
     */
    protected $fakeDataSeed;

    /**
     * @param AcceptanceTester $I
     */
    public function _before(AcceptanceTester $I)
    {
        if (!$this->fakeData) {
            $this->fakeData = Faker\Factory::create();
        }

        $this->fakeDataSeed = rand(0, 2048);
        $this->fakeData->seed($this->fakeDataSeed);
    }

    /**
     * @param \AcceptanceTester $I
     * @param \Step\Acceptance\ListView $listView
     * @param \Step\Acceptance\Products $products
     *
     * As an administrator I want to view the products module.
     */
    public function testScenarioViewProductsModule(
        \AcceptanceTester $I,
        \Step\Acceptance\ListView $listView,
        \Step\Acceptance\Products $products
    ) {
        $I->wantTo('View the products module for testing');

        // Navigate to products list-view
        $I->loginAsAdmin();
        $products->gotoProducts();
        $listView->waitForListViewVisible();

        $I->see('Products', '.module-title-text');
    }

    /**
     * @param \AcceptanceTester $I
     * @param \Step\Acceptance\DetailView $detailView
     * @param \Step\Acceptance\ListView $listView
     * @param \Step\Acceptance\Products $product
     *
     * As administrative user I want to create a product so that I can test
     * the standard fields.
     */
    public function testScenarioCreateAccount(
        \AcceptanceTester $I,
        \Step\Acceptance\DetailView $detailView,
        \Step\Acceptance\ListView $listView,
        \Step\Acceptance\Products $product
    ) {
        $I->wantTo('Create a product');

        // Navigate to products list-view
        $I->loginAsAdmin();
        $product->gotoProducts();
        $listView->waitForListViewVisible();

        // Create product
        $this->fakeData->seed($this->fakeDataSeed);
        $product->createProduct('Test_'. $this->fakeData->company());

        // Delete product
        $detailView->clickActionMenuItem('Delete');
        $detailView->acceptPopup();
        $listView->waitForListViewVisible();
    }
}
