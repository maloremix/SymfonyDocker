<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Класс представляет сущность "Пользователь".
 *
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name="`user`")
 */
class User
{
    /**
     * Уникальный идентификатор пользователя.
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * Электронная почта пользователя.
     *
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Email не должен быть пустым.")
     * @Assert\Email(message="Email '{{ value }}' не является допустимым email адресом.")
     */
    private $email;

    /**
     * Имя пользователя.
     *
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Имя не должно быть пустым.")
     * @Assert\Length(max=255, maxMessage="Имя пользователя не должно превышать 255 символов.")
     */
    private $name;

    /**
     * Возраст пользователя.
     *
     * @ORM\Column(type="integer")
     * @Assert\NotBlank(message="Возраст не должен быть пустым.")
     * @Assert\Type(type="integer", message="Возраст должен быть числом.")
     * @Assert\Range(min=0, max=150, notInRangeMessage="Возраст должен быть от {{ min }} до {{ max }} лет.")
     */
    private $age;

    /**
     * Пол пользователя.
     *
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Пол не должен быть пустым.")
     * @Assert\Choice(choices={"male", "female"}, message="Пол должен быть 'male' или 'female'.")
     */
    private $sex;

    /**
     * Дата рождения пользователя.
     *
     * @ORM\Column(type="date")
     * @Assert\NotBlank(message="Дата рождения не должна быть пустой.")
     * @Assert\Type("\DateTimeInterface")
     */
    private $birthday;

    /**
     * Номер телефона пользователя.
     *
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Номер телефона не должен быть пустым.")
     * @Assert\Regex(pattern="/^\+\d{1,3} \(\d{3}\) \d{3}-\d{4}$/", message="Неправильный формат номера телефона.")
     */
    private $phone;

    /**
     * Дата и время создания записи о пользователе.
     *
     * @ORM\Column(type="datetime_immutable")
     */
    private $created_at;

    /**
     * Дата и время последнего обновления записи о пользователе.
     *
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    /**
     * Возвращает уникальный идентификатор пользователя.
     *
     * @return int|null Уникальный идентификатор пользователя.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Устанавливает уникальный идентификатор пользователя.
     *
     * @param int $id Уникальный идентификатор пользователя.
     * @return $this
     */
    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Возвращает адрес электронной почты пользователя.
     *
     * @return string|null Адрес электронной почты пользователя.
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Устанавливает адрес электронной почты пользователя.
     *
     * @param string $email Адрес электронной почты пользователя.
     * @return $this
     */
    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Возвращает имя пользователя.
     *
     * @return string|null Имя пользователя.
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * Устанавливает имя пользователя.
     *
     * @param string $name Имя пользователя.
     * @return $this
     */
    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Возвращает возраст пользователя.
     *
     * @return int|null Возраст пользователя.
     */
    public function getAge(): ?int
    {
        return $this->age;
    }

    /**
     * Устанавливает возраст пользователя.
     *
     * @param int $age Возраст пользователя.
     * @return $this
     */
    public function setAge(int $age): static
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Возвращает пол пользователя.
     *
     * @return string|null Пол пользователя.
     */
    public function getSex(): ?string
    {
        return $this->sex;
    }

    /**
     * Устанавливает пол пользователя.
     *
     * @param string $sex Пол пользователя.
     * @return $this
     */
    public function setSex(string $sex): static
    {
        $this->sex = $sex;

        return $this;
    }

    /**
     * Возвращает дату рождения пользователя.
     *
     * @return \DateTimeInterface|null Дата рождения пользователя.
     */
    public function getBirthday(): ?\DateTimeInterface
    {
        return $this->birthday;
    }

    /**
     * Устанавливает дату рождения пользователя.
     *
     * @param \DateTimeInterface $birthday Дата рождения пользователя.
     * @return $this
     */
    public function setBirthday(\DateTimeInterface $birthday): static
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * Возвращает номер телефона пользователя.
     *
     * @return string|null Номер телефона пользователя.
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * Устанавливает номер телефона пользователя.
     *
     * @param string $phone Номер телефона пользователя.
     * @return $this
     */
    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Возвращает дату и время создания записи о пользователе.
     *
     * @return \DateTimeImmutable|null Дата и время создания записи о пользователе.
     */
    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    /**
     * Устанавливает дату и время создания записи о пользователе.
     *
     * @param \DateTimeImmutable $created_at Дата и время создания записи о пользователе.
     * @return $this
     */
    public function setCreatedAt(\DateTimeImmutable $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    /**
     * Возвращает дату и время последнего обновления записи о пользователе.
     *
     * @return \DateTimeInterface|null Дата и время последнего обновления записи о пользователе.
     */
    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    /**
     * Устанавливает дату и время последнего обновления записи о пользователе.
     *
     * @param \DateTimeInterface $updated_at Дата и время последнего обновления записи о пользователе.
     * @return $this
     */
    public function setUpdatedAt(\DateTimeInterface $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }
}
