<?php

namespace App\Service;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Сервис для работы с сущностью "Пользователь".
 */
class UserService
{
    /**
     * @var EntityManagerInterface Менеджер сущностей Doctrine.
     */
    private $entityManager;

    /**
     * @var UserRepository Репозиторий пользователей.
     */
    private $userRepository;

    /**
     * Конструктор класса.
     *
     * @param EntityManagerInterface $entityManager Менеджер сущностей Doctrine.
     * @param UserRepository $userRepository Репозиторий пользователей.
     */
    public function __construct(EntityManagerInterface $entityManager, UserRepository $userRepository)
    {
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
    }

    /**
     * Создает нового пользователя.
     *
     * @param array $userData Данные пользователя.
     * @return User Созданный пользователь.
     */
    public function createUser(array $userData): User
    {
        // Валидация и обработка данных $userData

        $user = new User();
        $user->setEmail($userData['email']);
        $user->setName($userData['name']);
        $user->setAge($userData['age']);
        $user->setSex($userData['sex']);
        $user->setBirthday(new \DateTime($userData['birthday']));
        $user->setPhone($userData['phone']);
        $user->setCreatedAt(new \DateTimeImmutable());
        $user->setUpdatedAt(new \DateTime());

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }

    /**
     * Обновляет данные пользователя.
     *
     * @param User $user Пользователь для обновления.
     * @param array $userData Новые данные пользователя.
     *
     * @return User Обновленный пользователь.
     */
    public function updateUser(User $user, array $userData): User
    {
        // Валидация и обработка данных $userData

        $user->setEmail($userData['email']);
        $user->setName($userData['name']);
        $user->setAge($userData['age']);
        $user->setSex($userData['sex']);
        $user->setBirthday(new \DateTime($userData['birthday']));
        $user->setPhone($userData['phone']);
        $user->setUpdatedAt(new \DateTime());

        $this->entityManager->flush();

        return $user;
    }

    /**
     * Удаляет пользователя.
     *
     * @param User $user Пользователь для удаления.
     */
    public function deleteUser(User $user): void
    {
        $this->entityManager->remove($user);
        $this->entityManager->flush();
    }

    /**
     * Получает пользователя по его идентификатору.
     *
     * @param int $userId Идентификатор пользователя.
     *
     * @return User|null Пользователь или null, если не найден.
     */
    public function getUserById(int $userId): ?User
    {
        return $this->userRepository->find($userId);
    }

    /**
     * Получает список всех пользователей.
     *
     * @return User[] Массив пользователей.
     */
    public function getAllUsers(): array
    {
        return $this->userRepository->findAll();
    }
}
