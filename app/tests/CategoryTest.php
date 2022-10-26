<?php

use App\AdminModule\Model\CategoryManager;
use Nette\DI\Container;
use Tester\Assert;

$container = require __DIR__ . '/bootstrap.php';


class CategoryTest extends Tester\TestCase
{
    public function __construct
    (private Container $container, )
    {}


    public function testGetCategories(): void
    {
        $presenterFactory = $this->container->getByType('Nette\Application\IPresenterFactory');
        $presenter = $presenterFactory->createPresenter('Admin:Category');
        $presenter->autoCanonicalize = false;

        $request = new Nette\Application\Request('Admin:Category', 'GET', array('action' => 'default'));
        $response = $presenter->run($request);

        Assert::same(200, $presenter->getHttpResponse()->getCode());

        Assert::type('Nette\Application\Responses\TextResponse', $response);
        Assert::type('Nette\Bridges\ApplicationLatte\Template', $response->getSource());
    }


    public function testAdd(): void
    {
        $presenterFactory = $this->container->getByType('Nette\Application\IPresenterFactory');
        $presenter = $presenterFactory->createPresenter('Admin:Category');
        $presenter->autoCanonicalize = false;

        $request = new Nette\Application\Request('Admin:Category', 'GET', array('action' => 'add'));
        $response = $presenter->run($request);

        Assert::same(200, $presenter->getHttpResponse()->getCode());

        Assert::type('Nette\Application\Responses\TextResponse', $response);
        Assert::type('Nette\Bridges\ApplicationLatte\Template', $response->getSource());

        $html = (string) $response->getSource();

        $dom = Tester\DomQuery::fromHtml($html);

        Assert::true( $dom->has('input[name="name"]') );
    }

    public function testEdit(): void
    {
        $presenterFactory = $this->container->getByType('Nette\Application\IPresenterFactory');
        $presenter = $presenterFactory->createPresenter('Admin:Category');
        $presenter->autoCanonicalize = false;

        $request = new Nette\Application\Request('Admin:Category', 'GET', array('action' => 'edit', 'id' => 1));
        $response = $presenter->run($request);

        Assert::same(200, $presenter->getHttpResponse()->getCode());

        Assert::type('Nette\Application\Responses\TextResponse', $response);
        Assert::type('Nette\Bridges\ApplicationLatte\Template', $response->getSource());

        $html = (string) $response->getSource();

        $dom = Tester\DomQuery::fromHtml($html);

        Assert::true( $dom->has('input[name="name"]') );
    }

    public function testEditCategoryNotFound(): void
    {
        $presenterFactory = $this->container->getByType('Nette\Application\IPresenterFactory');
        $presenter = $presenterFactory->createPresenter('Admin:Category');
        $request = new Nette\Application\Request('Admin:Category', 'GET', array('action' => 'edit', 'id' => 999999));

        Assert::exception(function () use ($presenter, $request) {
            $presenter->run($request);
        }, 'Nette\Application\BadRequestException', 'Category not found');
    }


    public function testError(): void
    {
        $presenterFactory = $this->container->getByType('Nette\Application\IPresenterFactory');
        $presenter = $presenterFactory->createPresenter('Admin:Category');
        $presenter->autoCanonicalize = false;

        $request = new Nette\Application\Request('Admin:Category', 'GET', array('action' => 'error'));

        Assert::exception(function () use ($presenter, $request) {
            $presenter->run($request);
        }, 'Nette\Application\BadRequestException');
    }

    public function testCategoryManagerGetCategoris(): void
    {
        $categoryManager = $this->container->getByType(CategoryManager::class);
        $categories = $categoryManager->getCategories();

        $cat = [];
        foreach ($categories as $category) {
            $cat[] = $category->name;
        }

       Assert::contains( 'category 1', $cat);
    }

    public function testCategoryManagerGetCategory(): void
    {
        $categoryManager = $this->container->getByType(CategoryManager::class);
        $category = $categoryManager->getCategory(1);

        Assert::same('category 1', $category->name);
    }

    public function testCategoryManagerGetCategoriesForSelect(): void
    {
        $categoryManager = $this->container->getByType(CategoryManager::class);
        $category = $categoryManager->getCategoriesForSelect();

        Assert::same( [1 => 'category 1', 2 => 'category 2'], array_slice($category, 0, 2, true));
    }

}

$test = new CategoryTest($container);
$test->run();