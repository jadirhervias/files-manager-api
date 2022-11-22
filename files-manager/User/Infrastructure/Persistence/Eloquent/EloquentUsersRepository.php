<?php

namespace FilesManager\User\Infrastructure\Persistence\Eloquent;

use App\Models\User as UserEloquentModel;
use FilesManager\User\Domain\User;
use FilesManager\User\Domain\UsersRepository;
use FilesManager\Shared\Domain\AggregateRoot;
use FilesManager\Shared\Infrastructure\Persistence\Eloquent\EloquentRepository;

class EloquentUsersRepository extends EloquentRepository implements UsersRepository
{
    function serializer($attributes): AggregateRoot
    {
        return new User(
            $attributes['id'],
            $attributes['name'],
            $attributes['email'],
            $attributes['password'],
            $attributes['created_at'],
            $attributes['updated_at'],
        );
    }

    function modelClass(): string
    {
        return UserEloquentModel::class;
    }

    public function save(User $user): void
    {
        $model = $this->model()->fill(array_merge(
            $user->toPrimitives(),
            ['password' => $user->password()]
        ));

        $this->model()::query()->updateOrCreate(
            [$model->getKeyName() => $model->getKey()],
            $model->makeVisible('password')->toArray()
        );
    }

    public function findByEmail(string $email): ?User
    {
        /** @var UserEloquentModel|null $user */
        $user = $this->builder()->firstWhere('email', $email);

        return $user ? $this->serializer($user->toArray()) : null;
    }
}
