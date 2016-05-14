<?php

class PatientsTest extends TestCase
{   
    public function testCreatePatientDirectly()
    {
        $this->visit('/login')
            ->type('admin@admin.com', 'email')
            ->type('admin123', 'password')
            ->check('remember')
            ->press('Login')
            ->seePageIs('/reports')
            ->visit('/patients');
        $name = $this->faker->name;
        $email = $this->faker->email;
        $phone = '15417713450';
        $response = $this->call('POST', 'patients', ['name' => $name, 'email' => $email, 'phone' => $phone]);
        $this->assertRedirectedTo('/patients');
        $this->assertEquals(302, $response->status());
        $this->followRedirects();
        $this->seePageIs('/patients')
            ->seeElement('table.table')
            ->dontSee('Whoops! Something went wrong!');
        $this->assertSessionHas('flash');
        $this->seeInDatabase('users', ['email' => $email]);
    }
    
    public function testSubmitInvalidDataInPatientForm()
    {
        $this->visit('/login')
            ->type('admin@admin.com', 'email')
            ->type('admin123', 'password')
            ->check('remember')
            ->press('Login')
            ->seePageIs('/reports')
            ->visit('/patients')
            ->press('Add')
            ->see('Whoops! Something went wrong!')
            ->see('The name field is required.')
            ->see('The email field is required.')
            ->see('The phone field is required.')
            ->type($this->faker->name, 'name')
            ->press('Add')
            ->dontSee('The name field is required.')
            ->type($this->faker->email, 'email')
            ->press('Add')
            ->dontSee('The name field is required.')
            ->dontSee('The email field is required.');
    }
    
    public function testPatientFormValidation()
    {
        $this->visit('/login')
            ->type('admin@admin.com', 'email')
            ->type('admin123', 'password')
            ->check('remember')
            ->press('Login')
            ->seePageIs('/reports')
            ->visit('/patients')
            ->type($this->faker->name, 'name')
            ->type('test@test', 'email')
            ->type($this->faker->text(10), 'phone')
            ->press('Add')
            ->see('The email must be a valid email address.')
            ->see('The phone field contains an invalid number.');
    }
    
    public function testCreatingPatientViaForm()
    {
        $email = $this->faker->email;
        $this->visit('/login')
            ->type('admin@admin.com', 'email')
            ->type('admin123', 'password')
            ->check('remember')
            ->press('Login')
            ->visit('/patients')
            ->type($this->faker->name, 'name')
            ->type($email, 'email')
            ->type('15412891417', 'phone')
            ->press('Add')
            ->see('has been successfully created')
            ->dontSee('Whoops! Something went wrong!')
            ->seeInDatabase('users', ['email' => $email])
            ->assertSessionHas('flash');
    }
    
    public function testPatientDelete()
    {
        $user = App\User::create([
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
        ]);
        $user->assignRole('patient');
        $this->visit('/login')
            ->type('admin@admin.com', 'email')
            ->type('admin123', 'password')
            ->check('remember')
            ->press('Login')
            ->visit('/patients/' . $user->id . '/delete')
            ->seePageIs('/patients')
            ->see('Patient ' . $user->name . ' has been successfully removed.');
        $this->dontSeeInDatabase('users', ['email' => $user->email]);
    }
    
    public function testPatientView()
    {
        $user = App\User::create([
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
        ]);
        $user->assignRole('patient');
        $this->seeInDatabase('users', ['email' => $user->email]);
        $this->visit('/login')
            ->type('admin@admin.com', 'email')
            ->type('admin123', 'password')
            ->check('remember')
            ->press('Login')
            ->visit('/patients/' . $user->id . '/view')
            ->see($user->name)
            ->see($user->email);
    }
    
    public function testPatientEdit()
    {
        $user = App\User::create([
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'phone' => '15416787799',
        ]);
        $user->assignRole('patient');
        $this->seeInDatabase('users', ['email' => $user->email]);
        $newName = $this->faker->name;
        $newEmail = $this->faker->email;
        $this->visit('/login')
            ->type('admin@admin.com', 'email')
            ->type('admin123', 'password')
            ->check('remember')
            ->press('Login')
            ->visit('/patients/' . $user->id . '/edit')
            ->type($newName, 'name')
            ->type($newEmail, 'email')
            ->press('Save')
            ->followRedirects();
        $this->seePageIs('/patients')->see('Patient record has been successfully updated.');
        $user = App\User::find($user->id);
        $this->assertEquals($newEmail, $user->email);
        $this->assertEquals($newName, $user->name);
    }
    
    public function testPatientAutocomplete()
    {
        App\User::create([
            'name' => 'First',
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
        ])->assignRole('patient');
        App\User::create([
            'name' => 'Second',
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
        ])->assignRole('patient');
        App\User::create([
            'name' => 'Fourth',
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
        ])->assignRole('patient');
        App\User::create([
            'name' => 'Fifth',
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
        ])->assignRole('patient');
        
        $patients = App\User::role('patient')->get();
        $pattern = 'th';
        $result = [];
        foreach ($patients as $patient) {
            if (stristr($patient->name, $pattern)) {
                $result[] = ['value' => $patient->email, 'label' => $patient->name, 'desc' => $patient->id];
            }
        }
        
        $this->visit('/login')
            ->type('admin@admin.com', 'email')
            ->type('admin123', 'password')
            ->check('remember')
            ->press('Login')
            ->json('GET', '/patients/autocomplete', ['term' => $pattern])
            ->seeJsonEquals($result);
        
        $pattern = 'Fir';
        $result = [];
        foreach ($patients as $patient) {
            if (stristr($patient->name, $pattern)) {
                $result[] = ['value' => $patient->email, 'label' => $patient->name, 'desc' => $patient->id];
            }
        }
        $this->json('GET', '/patients/autocomplete', ['term' => $pattern])
            ->seeJsonEquals($result);
    }
}
