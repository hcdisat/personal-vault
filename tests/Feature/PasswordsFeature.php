<?php

namespace Tests\Feature;

use App\Http\RoutesInfo\V1\PasswordInfo;
use App\Models\Password;
use Illuminate\Support\Collection;
use Tests\TestCase;

class PasswordsFeature extends TestCase
{
    protected const PASSWORD_BASE = self::ROOT_URI . '/passwords';
    protected const PASSWORD_SHOW = self::PASSWORD_BASE . '/:id';

    /**
    * @test
    */
    public function should_not_list_all_passwords_at_index(): void
    {
        $response = $this->getJson(self::PASSWORD_BASE);
        $response->assertUnauthorized();
    }

    /**
    * @test
    */
    public function should_list_all_user_passwords(): void
    {
        $this->loginUser();
        $this->createPasswords(10);

        $response = $this->getJson(self::PASSWORD_BASE);
        $response->assertOk();

        $data = $response->getOriginalContent()['data'];
        $this->assertCount(10, $data);
    }

    /**
    * @test
    */
    public function it_should_not_show_a_password_record_not_logged_in(): void
    {
        $url = $this->getUriById(88);
        $response = $this->getJson($url);

        $response->assertSeeText('Not authorized');
    }

    /**
    * @test
    */
    public function it_should_show_a_password_record(): void
    {
        $this->loginUser();
        $this->createPasswords(1);

        $response = $this->getJson($this->getUriById(1));

        $response->assertOk();
        $response->assertSeeText('**************');
        $response->assertSeeText('created_at');
    }

    /**
    * @test
    */
    public function it_should_update_a_password(): void
    {
        $this->loginUser();
        $password = $this->createPasswords(1)->first();
        $uri = $this->getUriById($password->id);

        $response = $this->putJson($uri, [
            PasswordInfo::Username => 'hcdisat',
            PasswordInfo::Name => 'Updated Name'
        ]);

        $response->assertOk();
        $response->assertSeeText('hcdisat');
        $response->assertSeeText('Updated Name');
    }

    /**
    * @test
    */
    public function it_should_store_a_password(): void
    {
        $this->loginUser();

        /** @var Password $notSavedPassword */
        $notSavedPassword = factory(Password::class)->make();

        $response = $this->postJson(self::PASSWORD_BASE, [
            PasswordInfo::Name => $notSavedPassword->name,
            PasswordInfo::Website => $notSavedPassword->website,
            PasswordInfo::Username => $notSavedPassword->username,
            PasswordInfo::Value => $notSavedPassword->value,
            PasswordInfo::Note => $notSavedPassword->note
        ]);

        $response->assertCreated();
        $response->assertSeeText($notSavedPassword->name);
        $response->assertSeeText($notSavedPassword->website);
        $response->assertSeeText($notSavedPassword->username);
        $response->assertSeeText($notSavedPassword->note);
    }

    /**
    * @test
    */
    public function it_should_delete_a_password(): void
    {
        $this->loginUser();
        $id = $this->createPasswords(1)->first()->id;

        $response = $this->deleteJson($this->getUriById($id));

        $response->assertNoContent();
    }

    /**
     * @param int $id
     * @return string|string[]
     */
    protected function getUriById(int $id)
    {
        return str_replace(
            ':id',
            $id,
            self::PASSWORD_SHOW
        );
    }

    /**
     * @param int $amount
     * @return Password|Password[]|Collection
     */
    protected function createPasswords(int $amount)
    {
        return factory(Password::class, $amount)->create();
    }
}
