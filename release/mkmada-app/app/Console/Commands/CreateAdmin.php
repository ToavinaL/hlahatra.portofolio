<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateAdmin extends Command
{
    protected $signature = 'portfolio:create-admin {email? : Adresse e-mail de l\'administrateur}';

    protected $description = 'Crée le compte administrateur du portfolio';

    public function handle(): int
    {
        $email = $this->argument('email') ?? $this->ask('Adresse e-mail');
        $name = $this->ask('Nom', 'Administrateur');
        $password = $this->secret('Mot de passe (12 caractères minimum)');

        $validator = Validator::make(
            ['email' => $email, 'name' => $name, 'password' => $password],
            [
                'email' => ['required', 'email', 'unique:users,email'],
                'name' => ['required', 'string', 'max:255'],
                'password' => ['required', 'string', 'min:12'],
            ],
        );

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            return self::FAILURE;
        }

        $user = new User(['name' => $name, 'email' => $email]);
        $user->password = Hash::make($password);
        $user->forceFill(['is_admin' => true, 'email_verified_at' => now()])->save();

        $this->info("Compte administrateur créé pour {$email}.");

        return self::SUCCESS;
    }
}
