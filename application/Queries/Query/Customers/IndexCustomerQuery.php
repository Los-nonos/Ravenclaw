<?php


namespace Application\Queries\Query\Customers;


use Infrastructure\QueryBus\Query\QueryInterface;

class IndexCustomerQuery implements QueryInterface
{
    /**
     * @var int
     */
    private int $page;
    /**
     * @var int
     */
    private int $size;
    /**
     * @var string|null
     */
    private ?string $name;
    /**
     * @var string|null
     */
    private ?string $surname;
    /**
     * @var string|null
     */
    private ?string $username;
    /**
     * @var string|null
     */
    private ?string $email;
    /**
     * @var string|null
     */
    private ?string $organizationName;
    /**
     * @var string|null
     */
    private ?string $domain;

    public function __construct($page, $size, $name, $surname, $username, $email, $organizationName, $domain)
    {
        $this->page = $page ? $page : 1;
        $this->size = $size ? $size : env('PAGINATED_SIZE', 10);
        $this->name = $name;
        $this->surname = $surname;
        $this->username = $username;
        $this->email = $email;
        $this->domain = $domain;
        $this->organizationName = $organizationName;
    }

    public function getPage(): ?int
    {
        return $this->page;
    }

    public function getSize(): ?int
    {
        return $this->size;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function getSurname(): ?string
    {
        return $this->surname;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getDomain(): ?string
    {
        return $this->domain;
    }

    public function getOrganizationName(): ?string
    {
        return $this->organizationName;
    }
}
