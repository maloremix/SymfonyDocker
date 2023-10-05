<?php

namespace App\Controller;

use App\Entity\User;
use App\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * UserController отвечает за обработку API-запросов, связанных с пользователями.
 *
 * @Route("/user")
 */
class UserController extends AbstractController
{
    /**
     * @var UserService Сервис для работы с пользователями.
     */
    private UserService $userService;

    /**
     * @var SerializerInterface $serializer Сервис для сериализации и десериализации данных.
     */
    private SerializerInterface $serializer;

    /**
     * @var ValidatorInterface $validator Сервис для валидации данных.
     */
    private ValidatorInterface $validator;

    /**
     * Конструктор UserController.
     *
     * @param UserService         $userService Сервис для работы с пользователями.
     * @param SerializerInterface $serializer  Сервис для сериализации и десериализации данных.
     * @param ValidatorInterface  $validator   Сервис для валидации данных.
     */
    public function __construct(
        UserService $userService,
        SerializerInterface $serializer,
        ValidatorInterface $validator
    ) {
        $this->userService = $userService;
        $this->serializer = $serializer;
        $this->validator = $validator;
    }

    /**
     * Получает список всех пользователей.
     *
     * @Route("", name="user_index", methods={"GET"})
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $users = $this->userService->getAllUsers();

        // Сериализация массива пользователей в JSON
        $jsonData = $this->serializer->serialize($users, 'json', [
            'json_encode_options' => JSON_UNESCAPED_UNICODE,
        ]);

        return new JsonResponse($jsonData, 200, [], true);
    }

    /**
     * Создает нового пользователя.
     *
     * @Route("", name="user_create", methods={"POST"})
     *
     * @param Request $request HTTP-запрос.
     *
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        // Получаем данные JSON из запроса
        $data = json_decode($request->getContent(), true);

        try {
            // Десериализация данных в объект User
            $user = $this->serializer->deserialize($request->getContent(), User::class, 'json');

            // Валидация объекта User
            $errors = $this->validator->validate($user);

            $responseData = [
                'message' => 'Ошибка создания пользователя',
            ];

            if (count($errors) > 0) {
                $errorMessages = [];
                foreach ($errors as $error) {
                    $errorMessages[] = $error->getMessage();
                }

                $responseData['errors'] = $errorMessages;

                return new JsonResponse(json_encode($responseData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES), 400, [], true);
            }

            $createdUser = $this->userService->createUser($data);
            $responseData = ['message' => 'Пользователь создан', 'user' => $createdUser];

            return new JsonResponse(json_encode($responseData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES), 201, [], true);
        } catch (\Exception $e) {
            $responseData = ['message' => 'Ошибка создания пользователя', 'error' => $e->getMessage()];

            return new JsonResponse(json_encode($responseData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES), 400, [], true);
        }
    }

    /**
     * Получает информацию о конкретном пользователе по его ID.
     *
     * @Route("/{id}", name="user_show", methods={"GET"})
     *
     * @param User $user Пользователь.
     *
     * @return JsonResponse
     */
    public function show(User $user): JsonResponse
    {
        return $this->json(['user' => $user]);
    }

    /**
     * Обновляет информацию о пользователе.
     *
     * @Route("/{id}", name="user_edit", methods={"PUT"})
     *
     * @param Request $request HTTP-запрос.
     * @param User    $user    Пользователь.
     *
     * @return JsonResponse
     */
    public function edit(Request $request, User $user): JsonResponse
    {
        // Получаем данные JSON из запроса
        $data = json_decode($request->getContent(), true);

        try {
            // Десериализация данных в объект User
            $updatedUser = $this->serializer->deserialize($request->getContent(), User::class, 'json');

            // Валидация объекта User
            $errors = $this->validator->validate($updatedUser);

            $responseData = [
                'message' => 'Ошибка обновления пользователя',
            ];

            if (count($errors) > 0) {
                $errorMessages = [];
                foreach ($errors as $error) {
                    $errorMessages[] = $error->getMessage();
                }

                $responseData['errors'] = $errorMessages;

                return new JsonResponse(json_encode($responseData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES), 400, [], true);
            }

            $updatedUser = $this->userService->updateUser($user, $data);
            $responseData = ['message' => 'Пользователь обновлен', 'user' => $updatedUser];

            return new JsonResponse(json_encode($responseData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES), 200, [], true);
        } catch (\Exception $e) {
            $responseData = ['message' => 'Ошибка обновления пользователя', 'error' => $e->getMessage()];

            return new JsonResponse(json_encode($responseData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES), 400, [], true);
        }
    }

    /**
     * Удаляет пользователя.
     *
     * @Route("/{id}", name="user_delete", methods={"DELETE"})
     *
     * @param User $user Пользователь.
     *
     * @return JsonResponse
     */
    public function delete(User $user): JsonResponse
    {
        // Удаляем пользователя
        try {
            $this->userService->deleteUser($user);
            return new JsonResponse(['message' => 'Пользователь удален'], 200, [], true);
        } catch (\Exception $e) {
            $responseData = ['message' => 'Ошибка удаления пользователя', 'error' => $e->getMessage()];
            return new JsonResponse(json_encode($responseData, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES), 400, [], true);
        }
    }
}
