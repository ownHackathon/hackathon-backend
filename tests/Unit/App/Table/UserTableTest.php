<?php declare(strict_types=1);

namespace Test\Unit\App\Table;

use App\Entity\User;
use App\Enum\UserRole;
use App\Exception\DuplicateEntryException;
use App\Table\UserTable;
use DateTime;
use InvalidArgumentException;
use Ramsey\Uuid\Rfc4122\UuidV7;
use Test\Unit\Mock\Database\MockQueryForCanNot;
use Test\Unit\Mock\TestConstants;

/**
 * @property UserTable $table
 */
class UserTableTest extends AbstractTable
{
    private array $defaulUserValue;

    protected function setUp(): void
    {
        parent::setUp();

        $this->defaulUserValue = [
            'id' => TestConstants::USER_ID,
            'uuid' => UuidV7::fromString(TestConstants::USER_UUID),
            'role' => UserRole::USER,
            'name' => TestConstants::USER_NAME,
            'password' => TestConstants::USER_PASSWORD,
            'email' => TestConstants::USER_EMAIL,
            'registrationAt' => new DateTime(TestConstants::TIME),
            'lastActionAt' => new DateTime(TestConstants::TIME),
        ];
    }

    public function testCanGetTableName(): void
    {
        self::assertSame('User', $this->table->getTableName());
    }

    public function testCanInsertUser(): void
    {
        $user = new User(...$this->defaulUserValue);
        $user = $user->with(name: TestConstants::USER_CREATE_NAME);

        $affectedRowCount = $this->table->insert($user);

        self::assertSame(1, $affectedRowCount);
    }

    public function testCanNotInsertUser(): void
    {
        $user = new User(...$this->defaulUserValue);
        $user = $user->with(name: TestConstants::USER_NAME);

        self::expectException(DuplicateEntryException::class);

        $this->table->insert($user);
    }

    public function testCanUpdateUser(): void
    {
        $user = new User(...$this->defaulUserValue);
        $user = $user->with(
            id: TestConstants::USER_ID,
            registrationAt: new DateTime(),
            lastActionAt: new DateTime(),
        );

        $updateUser = $this->table->update($user);

        self::assertSame(1, $updateUser);
    }

    public function testUpdateUserThrowException(): void
    {
        $user = new User(...$this->defaulUserValue);
        $user = $user->with(
            id: TestConstants::USER_ID_THROW_EXCEPTION,
            lastActionAt: new DateTime(),
        );

        $table = new UserTable(new MockQueryForCanNot());

        self::expectException(InvalidArgumentException::class);

        $table->update($user);
    }

    public function testCanUpdateLastUserActionTime(): void
    {
        $updateUser = $this->table->updateLastUserActionTime(TestConstants::USER_ID, new DateTime());

        self::assertInstanceOf(UserTable::class, $updateUser);
    }

    public function testUpdateLastUserActionTimeThrowException(): void
    {
        self::expectException(InvalidArgumentException::class);

        $this->table->updateLastUserActionTime(TestConstants::USER_ID_THROW_EXCEPTION, new DateTime());
    }

    public function testCanFindById(): void
    {
        $user = $this->table->findById(TestConstants::USER_ID);

        self::assertSame($this->fetchResult, $user);
    }

    public function testFindByIdHasEmptyResult(): void
    {
        $user = $this->table->findById(TestConstants::USER_ID_UNUSED);

        self::assertSame([], $user);
    }

    public function testCanFindByUuid(): void
    {
        $user = $this->table->findByUuid(TestConstants::USER_UUID);

        self::assertSame($this->fetchResult, $user);
    }

    public function testFindByUuidHasEmptyResult(): void
    {
        $user = $this->table->findByUuid(TestConstants::USER_UUID_UNUSED);

        self::assertSame([], $user);
    }

    public function testCanFindAll(): void
    {
        $users = $this->table->findAll();

        self::assertSame($this->fetchAllResult, $users);
    }

    public function testFindAllReturnedEmpty(): void
    {
        $table = new UserTable(new MockQueryForCanNot());
        $users = $table->findAll();

        self::assertSame([], $users);
    }

    public function testCanFindByName(): void
    {
        $user = $this->table->findByName(TestConstants::USER_NAME);

        self::assertSame($this->fetchResult, $user);
    }

    public function testFindByNameHasEmptyResult(): void
    {
        $user = $this->table->findByName(TestConstants::USER_NAME_UNUSED);

        self::assertSame([], $user);
    }

    public function testCanFindByEmail(): void
    {
        $user = $this->table->findByEMail(TestConstants::USER_EMAIL);

        self::assertSame($this->fetchResult, $user);
    }

    public function testFindByEmailHasEmptyResult(): void
    {
        $user = $this->table->findByEMail(TestConstants::USER_EMAIL_UNUSED);

        self::assertSame([], $user);
    }

    public function testCanFindByToken(): void
    {
        $user = $this->table->findByToken(TestConstants::USER_TOKEN);

        self::assertSame($this->fetchResult, $user);
    }

    public function testFindByTokenHasEmptyResult(): void
    {
        $user = $this->table->findByToken(TestConstants::USER_TOKEN_UNUSED);

        self::assertSame([], $user);
    }
}
