<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a user';

    private String $userName, $email, $password, $passwordConfirmation;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->askData();

        $this->validateData();

        $this->createUser();

        $this->info('User created successfully!');
    }

    private function askData()
    {
        $this->userName = $this->ask('Introduce your name');

        $this->email = $this->ask('Introduce your email');

        $this->password = $this->secret('Introduce your password');

        $this->passwordConfirmation = $this->secret('Confirm your password');
    }

    private function validateData()
    {
        $validator = Validator::make([
            'name' => $this->userName,
            'email' => $this->email,
            'password' => $this->password,
            'password_confirmation' => $this->passwordConfirmation,
        ], [
            'name' => ['required'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        if ($validator->fails()) {
            $this->error('Whoops! An error occurred.');

            collect($validator->errors()->all())
                ->each(fn ($error) => $this->error($error));
            exit;
        }
    }

    private function createUser()
    {
        try {
            User::create([
                'nam' => $this->userName,
                'email' => $this->email,
                'password' => Hash::make($this->password),
            ]);
        } catch (\Exception $e) {
            $this->error("An error occurred: {$e->getMessage()}");
            exit;
        }
    }
}
