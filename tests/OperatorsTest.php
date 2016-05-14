<?php

class OperatorsTest extends TestCase
{    
    public function testCreatingOperatorViaForm()
    {
        $email = $this->faker->email;
        $password = $this->faker->password;
        $this->visit('/login')
            ->type('admin@admin.com', 'email')
            ->type('admin123', 'password')
            ->check('remember')
            ->press('Login')
            ->visit('/operators')
            ->press('Add')
            ->see('Whoops! Something went wrong!')
            ->see('The name field is required.')
            ->see('The email field is required.')
            ->see('The password field is required.')
            ->type($this->faker->name, 'name')
            ->press('Add')
            ->see('The email field is required.')
            ->see('The password field is required.')
            ->type($this->faker->name, 'name')
            ->type($email, 'email')
            ->press('Add')
            ->see('The password field is required.')
            ->type($this->faker->name, 'name')
            ->type($email, 'email')
            ->type($password, 'password')
            ->press('Add')
            ->see('The password confirmation does not match.')
            ->type($this->faker->name, 'name')
            ->type($email, 'email')
            ->type($password, 'password')
            ->type($password, 'password_confirmation')
            ->press('Add')
            ->see('New lab operator has been successfully created.')
            ->dontSee('Whoops! Something went wrong!')
            ->seeInDatabase('users', ['email' => $email])
            ->assertSessionHas('flash');
        
        $this->call('GET', '/logout');
        
        $this->visit('/login')
            ->type($email, 'email')
            ->type($password, 'password')
            ->check('remember')
            ->press('Login')
            ->seePageIs('/reports')
            ->see('Operators')
            ->see('Patients');
    }
    
    public function testOperatorDelete()
    {
        $password = $this->faker->password;
        $user = App\User::create([
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => $password,
        ]);
        $user->assignRole('operator');
        $this->visit('/login')
            ->type($user->email, 'email')
            ->type($password, 'password')
            ->check('remember')
            ->press('Login')
            ->visit('/operators/' . $user->id . '/delete')
            ->seePageIs('/operators')
            ->see('It is prohibited to delete main system admin or yourself.')
            ->visit('/logout')
            ->type('admin@admin.com', 'email')
            ->type('admin123', 'password')
            ->check('remember')
            ->press('Login')
            ->visit('/operators/' . $user->id . '/delete')
            ->see('Operator ' . $user->name . ' has been successfully removed.');
        $this->dontSeeInDatabase('users', ['email' => $user->email]);
    }
    
    public function testOperatorView()
    {
        $user = App\User::create([
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => $this->faker->password,
        ]);
        $user->assignRole('operator');
        $this->seeInDatabase('users', ['email' => $user->email]);
        $this->visit('/login')
            ->type('admin@admin.com', 'email')
            ->type('admin123', 'password')
            ->check('remember')
            ->press('Login')
            ->visit('/operators/' . $user->id . '/view')
            ->see($user->name)
            ->see($user->email);
    }
    
    public function testOperatorEdit()
    {
        $user = App\User::create([
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => $this->faker->password,
        ]);
        $user->assignRole('operator');
        $this->seeInDatabase('users', ['email' => $user->email]);
        $newName = $this->faker->name;
        $newEmail = $this->faker->email;
        $newPassword = $this->faker->password;
        $this->visit('/login')
            ->type('admin@admin.com', 'email')
            ->type('admin123', 'password')
            ->check('remember')
            ->press('Login')
            ->visit('/operators/' . $user->id . '/edit')
            ->type($newName, 'name')
            ->type($newEmail, 'email')
            ->type($newPassword, 'password')
            ->type($newPassword, 'password_confirmation')
            ->press('Save')
            ->followRedirects();
        $this->seePageIs('/operators')->see('Operator record has been successfully updated.');
        $user = App\User::find($user->id);
        $this->assertEquals($newEmail, $user->email);
        $this->assertEquals($newName, $user->name);
    }
    
    public function testAdminDelete()
    {
        $user = App\User::find(1);
        $this->visit('/login')
            ->type('admin@admin.com', 'email')
            ->type('admin123', 'password')
            ->check('remember')
            ->press('Login')
            ->visit('/operators/' . $user->id . '/delete')
            ->followRedirects()
            ->see('It is prohibited to delete main system admin or yourself.');
    }
}
