<?php

class ReportsTest extends TestCase
{    
    public function testCreatingReportViaForm()
    {
        $password = $this->faker->password;
        $user = App\User::create([
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
            'password' => $password
        ]);
        $user->assignRole('patient');
        
        $this->visit('/login')
            ->type('admin@admin.com', 'email')
            ->type('admin123', 'password')
            ->check('remember')
            ->press('Login')
            ->press('Add')
            ->see('Whoops! Something went wrong!')
            ->see('The user id field is required.')
            ->see('The procedure field is required.')
            ->see('The statement field is required.')
            ->see('The findings field is required.')
            ->see('The impression field is required.')
            ->see('The conclusion field is required.')
            ->type($user->id, 'user_id')
            ->type($user->name, 'report_user')
            ->type(implode(' ', $this->faker->words(3)), 'procedure')
            ->type(implode(' ', $this->faker->words(5)), 'statement')
            ->type(implode(' ', $this->faker->words(5)), 'findings')
            ->type(implode(' ', $this->faker->words(5)), 'impression')
            ->type(implode(' ', $this->faker->words(20)), 'conclusion')
            ->press('Add')
            ->see('Report has been successfully created.')
            ->see($user->name)
            ->dontSee('Whoops! Something went wrong!')
            ->assertSessionHas('flash');
        $this->visit('/logout');
        $report = App\Report::first();
        $this->type($user->email, 'email')
            ->type($password, 'password')
            ->check('remember')
            ->press('Login')
            ->seePageIs('/reports')
            ->see($report->procedure)
            ->see($user->name);
    }
    
    public function testReportDeleteUnauthorized()
    {
        $password = $this->faker->password;
        $user = App\User::create([
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
            'password' => $password,
        ]);
        $user->assignRole('patient');
        $report = App\Report::create([
            'user_id' => $user->id,
            'procedure' => implode(' ', $this->faker->words()),
            'statement' => implode(' ', $this->faker->words(5)),
            'findings' => implode(' ', $this->faker->words(5)),
            'impression' => implode(' ', $this->faker->words(5)),
            'conclusion' => implode(' ', $this->faker->words(20)),
        ]);
        try
        {
        $this->visit('/login')
            ->type($user->email, 'email')
            ->type($password, 'password')
            ->check('remember')
            ->press('Login')
            ->visit('/reports/' . $report->id . '/delete');
        } catch(\Exception $e) {
            $this->seeInDatabase('reports', ['id' => $report->id]);
        }
        $this->visit('/logout')
            ->type('admin@admin.com', 'email')
            ->type('admin123', 'password')
            ->check('remember')
            ->press('Login')
            ->seePageIs('/reports')
            ->visit('/reports/' . $report->id . '/delete')
            ->see('Report with MRN #' . $report->id . ' has been successfully removed.');
        $this->dontSeeInDatabase('reports', ['id' => $report->id]);
    }
    
    public function testReportView()
    {
        $password = $this->faker->password;
        $user = App\User::create([
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
            'password' => $password,
        ]);
        $user->assignRole('patient');
        $report = App\Report::create([
            'user_id' => $user->id,
            'procedure' => implode(' ', $this->faker->words()),
            'statement' => implode(' ', $this->faker->words(5)),
            'findings' => implode(' ', $this->faker->words(5)),
            'impression' => implode(' ', $this->faker->words(5)),
            'conclusion' => implode(' ', $this->faker->words(20)),
        ]);
        $this->visit('/login')
            ->type('admin@admin.com', 'email')
            ->type('admin123', 'password')
            ->check('remember')
            ->press('Login')
            ->visit('/reports/' . $report->id . '/view')
            ->see($user->name)
            ->see($report->procedure)
            ->see($report->statement)
            ->see($report->findings)
            ->see($report->impression)
            ->see($report->conclusion)
            ->visit('/logout')
            ->type($user->email, 'email')
            ->type($password, 'password')
            ->check('remember')
            ->press('Login')
            ->visit('/reports/' . $report->id . '/view')
            ->see($user->name)
            ->see($report->procedure)
            ->see($report->statement)
            ->see($report->findings)
            ->see($report->impression)
            ->see($report->conclusion);
    }
    
    public function testReportEdit()
    {
        $password = $this->faker->password;
        $user = App\User::create([
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'phone' => $this->faker->phoneNumber,
            'password' => $password,
        ]);
        $user->assignRole('patient');
        $report = App\Report::create([
            'user_id' => $user->id,
            'procedure' => implode(' ', $this->faker->words()),
            'statement' => implode(' ', $this->faker->words(5)),
            'findings' => implode(' ', $this->faker->words(5)),
            'impression' => implode(' ', $this->faker->words(5)),
            'conclusion' => implode(' ', $this->faker->words(20)),
        ]);
        $text = implode(' ', $this->faker->words(3));
        $this->visit('/login')
            ->type('admin@admin.com', 'email')
            ->type('admin123', 'password')
            ->check('remember')
            ->press('Login')
            ->visit('/reports/' . $report->id . '/edit')
            ->type($user->id, 'user_id')
            ->type($user->name, 'report_user')
            ->type($text, 'procedure')
            ->type($text, 'statement')
            ->type($text, 'findings')
            ->type($text, 'impression')
            ->type($text, 'conclusion')
            ->press('Save')
            ->followRedirects();
        $this->seePageIs('/reports')->see('Report with MRN #' . $report->id . ' has been successfully updated.');
        $report = App\Report::find($report->id);
        $this->assertEquals($text, $report->procedure);
        $this->assertEquals($text, $report->statement);
        $this->assertEquals($text, $report->findings);
        $this->assertEquals($text, $report->impression);
        $this->assertEquals($text, $report->conclusion);
    }
}
