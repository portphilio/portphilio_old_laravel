<?php

use Portphilio\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;

/**
 * Tests the functionality of the Portphilio\User class.
 */
class UserTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * Instance of Portphilio\User for testing.
     *
     * @var Portphilio\User
     */
    protected $creds;

    /**
     * Set up initial conditions for tests.
     */
    public function setUp()
    {
        parent::setUp();
        $this->creds = [
            'username' => 'jsmith',
            'first_name' => 'John',
            'last_name' => 'Smith',
            'email' => 'john.smith@portphil.io',
            'password' => 'I am number 1!',
        ];
    }

    /**
     * Test that the class exists.
     */
    public function testClassExists()
    {
        $this->assertTrue(class_exists('Portphilio\User'));
    }

    /**
     * Test slug generation.
     */
    public function testRegistration()
    {
        $user = new User($this->creds);
        $this->assertEquals($user->username, $user->slug);
    }
}
