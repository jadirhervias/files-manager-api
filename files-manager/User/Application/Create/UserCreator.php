<?php

namespace FilesManager\User\Application\Create;

use FilesManager\Shared\Domain\Uuid;
use FilesManager\User\Domain\User;
use FilesManager\User\Domain\UserAlreadyExists;
use FilesManager\User\Domain\UsersRepository;

class UserCreator
{
    public function __construct(
        private readonly UsersRepository $repository,
    )
    {
    }

    public function __invoke(CreateUserRequest $request): User
    {
        $foundUser = $this->repository->findByEmail($request->email());

        if (!is_null($foundUser)) {
            throw new UserAlreadyExists($request->email());
        }

        $user = User::create(
            Uuid::random()->value(),
            $request->name(),
            $request->email(),
            $request->hashedPassword()
        );

        $this->repository->save($user);

        return $user;
    }
}
