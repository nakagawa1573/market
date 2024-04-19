<?php

namespace Tests\Feature;

use App\Mail\NotificationEmail;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Mail;

class AdminTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic feature test example.
     */
    public function testAccessAdminSuccess(): void
    {
        $user = User::factory()->create();
        $user->update(['role' => 'admin']);
        $response = $this->actingAs($user)->get('/admin');
        $response->assertViewIs('admin');
    }

    public function testAccessAdminError(): void
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/admin');
        $response->assertStatus(403);
    }

    public function testAccessAdminNotLogin(): void
    {
        $response = $this->get('/admin');
        $response->assertRedirect('/login');
    }

    public function testAdminDeleteSuccessUser()
    {
        $user = User::factory()->create();
        $user->update(['role' => 'admin']);
        $data = [
            'id' => [User::inRandomOrder()->first()->id],
        ];
        $response = $this->actingAs($user)->delete('/admin/delete', $data);
        $this->assertDatabaseMissing('users', $data);
        $response->assertSessionHas('message', 'ユーザーの削除に成功しました');
    }

    public function testAdminDeleteSuccessUsers()
    {
        $userCount = User::all()->count();
        $user = User::factory()->create();
        $user->update(['role' => 'admin']);
        $randomIds = [];
        for ($i=0; $i < rand(1, $userCount); $i++) {
            $randomIds[] = rand(1, $userCount);
        }
        $data = [
            'id' => $randomIds
        ];
        $response = $this->actingAs($user)->delete('/admin/delete', $data);
        foreach ($randomIds as $id) {
            $this->assertDatabaseMissing('users', ['id' => $id]);
        }
        $response->assertSessionHas('message', 'ユーザーの削除に成功しました');
    }

    public function testAdminDeleteError()
    {
        $user = User::factory()->create();
        $data = [
            'id' => [User::inRandomOrder()->first()->id],
        ];
        $response = $this->actingAs($user)->delete('/admin/delete', $data);
        $this->assertDatabaseHas('users', $data);
        $response->assertStatus(403);
    }

    public function testAdminDeleteErrorIdRequired()
    {
        $user = User::factory()->create();
        $data = [
            'id' => null,
        ];
        $response = $this->actingAs($user)->delete('/admin/delete', $data);
        $response->assertSessionHasErrors('id');
    }

    public function testAdminDeleteErrorIdArray()
    {
        $user = User::factory()->create();
        $data = [
            'id' => User::inRandomOrder()->first()->id,
        ];
        $response = $this->actingAs($user)->delete('/admin/delete', $data);
        $response->assertSessionHasErrors('id');
    }

    public function testAdminDeleteErrorIdNumeric()
    {
        $user = User::factory()->create();
        $data = [
            'id' => [User::inRandomOrder()->first()],
        ];
        $response = $this->actingAs($user)->delete('/admin/delete', $data);
        $response->assertSessionHasErrors('id.*');
    }

    public function testAdminDeleteNotLogin()
    {
        $data = [
            'id' => [User::inRandomOrder()->first()->id],
        ];
        $response = $this->delete('/admin/delete', $data);
        $this->assertDatabaseHas('users', $data);
        $response->assertRedirect('/login');
    }

    public function testAdminSendEmailSuccess()
    {
        Mail::fake();
        $user = User::factory()->create();
        $to = User::inRandomOrder()->first();
        $user->update(['role' => 'admin']);
        $data = [
            'id' => [$to->id],
            'subject' => 'test',
            'text' => 'testtest',
        ];
        $response = $this->actingAs($user)->post('/admin/email', $data);
        $response->assertSessionHas('message', 'メールの送信に成功しました');
        Mail::assertSent(NotificationEmail::class, function($mail)use($to){
            return $mail->hasTo($to->email);
        });
    }

    public function testAdminSendEmailsSuccess()
    {
        Mail::fake();
        $userCount = User::count();
        $user = User::factory()->create();
        $user->update(['role' => 'admin']);
        $tos = User::inRandomOrder()->take(rand(1, $userCount))->get();
        $ids = [];
        foreach ($tos as $to) {
            $ids[] = $to->id;
        }
        $data = [
            'id' => $ids,
            'subject' => 'test',
            'text' => 'testtest',
        ];
        $response = $this->actingAs($user)->post('/admin/email', $data);
        $response->assertSessionHas('message', 'メールの送信に成功しました');
        foreach ($tos as $to) {
            Mail::assertSent(NotificationEmail::class, function ($mail) use ($to) {
                return $mail->hasTo($to->email);
            });
        }
    }

    public function testAdminSendEmailError()
    {
        Mail::fake();
        $user = User::factory()->create();
        $to = User::inRandomOrder()->first();
        $data = [
            'id' => [$to->id],
            'subject' => 'test',
            'text' => 'testtest',
        ];
        $response = $this->actingAs($user)->post('/admin/email', $data);
        $response->assertStatus(403);
        Mail::assertNothingSent();
    }

    public function testAdminSendEmailNotLogin()
    {
        Mail::fake();
        $to = User::inRandomOrder()->first();
        $data = [
            'id' => [$to->id],
            'subject' => 'test',
            'text' => 'testtest',
        ];
        $response = $this->post('/admin/email', $data);
        $response->assertRedirect('/login');
        Mail::assertNothingSent();
    }

    public function testAdminSendEmailErrorSubjectRequired()
    {
        Mail::fake();
        $user = User::factory()->create();
        $user->update(['role' => 'admin']);
        $to = User::inRandomOrder()->first();
        $data = [
            'id' => [$to->id],
            'subject' => null,
            'text' => 'testtest',
        ];
        $response = $this->actingAs($user)->post('/admin/email', $data);
        $response->assertSessionHasErrors('subject');
        Mail::assertNothingSent();
    }

    public function testAdminSendEmailErrorTextRequired()
    {
        Mail::fake();
        $user = User::factory()->create();
        $user->update(['role' => 'admin']);
        $to = User::inRandomOrder()->first();
        $data = [
            'id' => [$to->id],
            'subject' => 'test',
            'text' => null,
        ];
        $response = $this->actingAs($user)->post('/admin/email', $data);
        $response->assertSessionHasErrors('text');
        Mail::assertNothingSent();
    }

    public function testAdminSendEmailErrorIdRequired()
    {
        Mail::fake();
        $user = User::factory()->create();
        $user->update(['role' => 'admin']);
        $data = [
            'id' => null,
            'subject' => 'test',
            'text' => 'testtest',
        ];
        $response = $this->actingAs($user)->post('/admin/email', $data);
        $response->assertSessionHasErrors('id');
        Mail::assertNothingSent();
    }

    public function testAdminSendEmailErrorIdArray()
    {
        Mail::fake();
        $user = User::factory()->create();
        $user->update(['role' => 'admin']);
        $to = User::inRandomOrder()->first();
        $data = [
            'id' => $to->id,
            'subject' => 'test',
            'text' => 'testtest',
        ];
        $response = $this->actingAs($user)->post('/admin/email', $data);
        $response->assertSessionHasErrors('id');
        Mail::assertNothingSent();
    }

    public function testAdminSendEmailErrorIdNumeric()
    {
        Mail::fake();
        $user = User::factory()->create();
        $user->update(['role' => 'admin']);
        $to = User::inRandomOrder()->first();
        $data = [
            'id' => [$to->email],
            'subject' => 'test',
            'text' => 'testtest',
        ];
        $response = $this->actingAs($user)->post('/admin/email', $data);
        $response->assertSessionHasErrors('id.*');
        Mail::assertNothingSent();
    }
}
