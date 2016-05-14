<?php

class LoginTest extends TestCase
{   
    public function testBasicContent()
    {
        $this->visit('/')
            ->see('Pathology Lab Reporting')
            ->see('Login')
            ->seePageIs('/login');
    }
    
    public function testLoginAttempt()
    {
        $this->visit('/login')
            ->type('admin@admin.com', 'email')
            ->type('admin123', 'password')
            ->check('remember')
            ->press('Login')
            ->seePageIs('/reports')
            ->see('Operators')
            ->see('Patients')
            ->see('Reports');
    }
    
    public function testUnsuccessfulLoginAttempt()
    {
        $this->visit('/login')
            ->press('Login')
            ->seeElement('div.has-error')
            ->see('The email field is required')
            ->see('The password field is required')
            ->type('admin@admin.com', 'email')
            ->press('Login')
            ->seeElement('div.has-error')
            ->dontSee('The email field is required')
            ->see('The password field is required')
            ->type('', 'email')
            ->type('admin123', 'password')
            ->press('Login')
            ->see('The email field is required')
            ->dontSee('The password field is required');
    }
}
