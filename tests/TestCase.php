<?php

class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';
    
    /**
     *
     * @var \Faker\Generator
     */
    protected $faker;

    protected function setUp() {
        parent::setUp();
        $this->artisan('migrate:refresh');
        $this->artisan('db:seed');
    }
    
    protected function tearDown() {
        $this->artisan('migrate:refresh');
        $this->artisan('db:seed');
        parent::tearDown();
    }
    
    public function __construct($name = null, array $data = array(), $dataName = '') {
        parent::__construct($name, $data, $dataName);
        $this->faker = Faker\Factory::create();
    }
    
    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }
}
