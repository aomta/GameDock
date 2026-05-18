<?php

namespace Tests\Feature;

use App\Models\Game;
use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\TestCase;

class PurchaseFlowTest extends TestCase
{
    use RefreshDatabase;

    private function createGame(array $overrides = []): Game
    {
        $title = $overrides['title'] ?? 'Test Game';
        return Game::create(array_merge([
            'title' => $title,
            'slug' => Str::slug($title) . '-' . uniqid(),
            'description' => 'A test game',
            'price' => 29.99,
            'genre' => 'Action',
            'developer' => 'Test Dev',
            'publisher' => 'Test Pub',
            'release_date' => '2024-01-01',
            'active' => true,
        ], $overrides));
    }

    // ─── Cart ────────────────────────────────────────────────────────────────

    public function test_guest_cannot_access_cart()
    {
        $this->get(route('cart.index'))->assertRedirect(route('login'));
    }

    public function test_user_can_add_game_to_cart()
    {
        $user = User::factory()->create();
        $game = $this->createGame();

        $response = $this->actingAs($user)->post(route('cart.store', $game));

        $response->assertRedirect(route('cart.index'));
        $this->assertSame([$game->id => 1], session('cart'));
    }

    public function test_cannot_add_inactive_game_to_cart()
    {
        $user = User::factory()->create();
        $game = $this->createGame(['active' => false]);

        $this->actingAs($user)->post(route('cart.store', $game))->assertNotFound();
    }

    public function test_cannot_add_duplicate_game_to_cart()
    {
        $user = User::factory()->create();
        $game = $this->createGame();

        $this->actingAs($user)->post(route('cart.store', $game));
        $this->actingAs($user)->post(route('cart.store', $game));

        $this->assertCount(1, session('cart'));
    }

    public function test_cannot_add_owned_game_to_cart()
    {
        $user = User::factory()->create();
        $game = $this->createGame();

        $transaction = Transaction::create([
            'user_id' => $user->id,
            'total_amount' => $game->price,
            'status' => 'paid',
        ]);
        $transaction->items()->create([
            'game_id' => $game->id,
            'quantity' => 1,
            'price' => $game->price,
        ]);

        $this->actingAs($user)->post(route('cart.store', $game));

        $this->assertNull(session('cart'));
    }

    public function test_user_can_update_cart_quantity()
    {
        $user = User::factory()->create();
        $game = $this->createGame();

        $this->actingAs($user)->post(route('cart.store', $game));
        $this->actingAs($user)->patch(route('cart.update', $game), ['quantity' => 3]);

        $this->assertSame([$game->id => 3], session('cart'));
    }

    public function test_removing_item_from_cart_sets_quantity_zero_removes_it()
    {
        $user = User::factory()->create();
        $game = $this->createGame();

        $this->actingAs($user)->post(route('cart.store', $game));
        $this->actingAs($user)->patch(route('cart.update', $game), ['quantity' => 0]);

        $this->assertEmpty(session('cart'));
    }

    public function test_user_can_remove_single_cart_item()
    {
        $user = User::factory()->create();
        $game = $this->createGame();

        $this->actingAs($user)->post(route('cart.store', $game));
        $this->actingAs($user)->delete(route('cart.destroy', $game));

        $this->assertEmpty(session('cart'));
    }

    public function test_user_can_clear_cart()
    {
        $user = User::factory()->create();
        $game = $this->createGame();

        $this->actingAs($user)->post(route('cart.store', $game));
        $this->actingAs($user)->post(route('cart.clear'));

        $this->assertEmpty(session('cart'));
    }

    // ─── Checkout ────────────────────────────────────────────────────────────

    public function test_checkout_redirects_when_cart_empty()
    {
        $user = User::factory()->create();

        $this->actingAs($user)->get(route('checkout.create'))
            ->assertRedirect(route('cart.index'));

        $this->actingAs($user)->post(route('checkout.store'), [
            'payment_method' => 'bank_transfer',
        ])->assertRedirect(route('cart.index'));
    }

    public function test_user_can_checkout_with_bank_transfer()
    {
        $user = User::factory()->create();
        $game = $this->createGame();

        $this->actingAs($user)->post(route('cart.store', $game));
        $response = $this->actingAs($user)->post(route('checkout.store'), [
            'payment_method' => 'bank_transfer',
        ]);

        $transaction = Transaction::where('user_id', $user->id)->first();

        $this->assertNotNull($transaction);
        $this->assertSame('pending', $transaction->status);
        $this->assertSame('bank_transfer', $transaction->payment_method);
        $this->assertEquals($game->price, $transaction->total_amount);
        $this->assertCount(1, $transaction->items);
        $this->assertSame($game->id, $transaction->items->first()->game_id);
        $this->assertStringStartsWith('8801', $transaction->payment_code);
        $this->assertEmpty(session('cart'));

        $response->assertRedirect(route('payment.show', $transaction));
    }

    public function test_checkout_with_ewallet()
    {
        $user = User::factory()->create();
        $game = $this->createGame();

        $this->actingAs($user)->post(route('cart.store', $game));
        $this->actingAs($user)->post(route('checkout.store'), [
            'payment_method' => 'ewallet',
        ]);

        $transaction = Transaction::where('user_id', $user->id)->first();
        $this->assertSame('0812-3456-7890', $transaction->payment_code);
    }

    public function test_checkout_with_qris()
    {
        $user = User::factory()->create();
        $game = $this->createGame();

        $this->actingAs($user)->post(route('cart.store', $game));
        $this->actingAs($user)->post(route('checkout.store'), [
            'payment_method' => 'qris',
        ]);

        $transaction = Transaction::where('user_id', $user->id)->first();
        $this->assertStringStartsWith('ID1029000', $transaction->payment_code);
    }

    public function test_checkout_validates_payment_method()
    {
        $user = User::factory()->create();
        $game = $this->createGame();

        $this->actingAs($user)->post(route('cart.store', $game));
        $response = $this->actingAs($user)->post(route('checkout.store'), [
            'payment_method' => 'invalid',
        ]);

        $response->assertSessionHasErrors('payment_method');
    }

    // ─── Payment ─────────────────────────────────────────────────────────────

    public function test_user_can_view_payment_page()
    {
        $user = User::factory()->create();
        $game = $this->createGame();
        $transaction = Transaction::create([
            'user_id' => $user->id,
            'total_amount' => $game->price,
            'status' => 'pending',
            'payment_method' => 'bank_transfer',
            'payment_code' => '8801123456',
        ]);
        $transaction->items()->create([
            'game_id' => $game->id,
            'quantity' => 1,
            'price' => $game->price,
        ]);

        $this->actingAs($user)->get(route('payment.show', $transaction))->assertOk();
    }

    public function test_other_user_cannot_view_payment_page()
    {
        $user = User::factory()->create();
        $other = User::factory()->create();
        $game = $this->createGame();
        $transaction = Transaction::create([
            'user_id' => $user->id,
            'total_amount' => $game->price,
            'status' => 'pending',
            'payment_method' => 'bank_transfer',
        ]);

        $this->actingAs($other)->get(route('payment.show', $transaction))->assertForbidden();
    }

    public function test_paid_transaction_redirects_from_payment_page()
    {
        $user = User::factory()->create();
        $game = $this->createGame();
        $transaction = Transaction::create([
            'user_id' => $user->id,
            'total_amount' => $game->price,
            'status' => 'paid',
            'payment_method' => 'bank_transfer',
        ]);

        $this->actingAs($user)->get(route('payment.show', $transaction))
            ->assertRedirect(route('user.purchase-history.detail', $transaction));
    }

    public function test_user_can_change_payment_method()
    {
        $user = User::factory()->create();
        $game = $this->createGame();
        $transaction = Transaction::create([
            'user_id' => $user->id,
            'total_amount' => $game->price,
            'status' => 'pending',
            'payment_method' => 'bank_transfer',
            'payment_code' => '8801123456',
        ]);

        $this->actingAs($user)->patch(route('payment.updateMethod', $transaction), [
            'payment_method' => 'ewallet',
        ]);

        $transaction->refresh();
        $this->assertSame('ewallet', $transaction->payment_method);
        $this->assertNull($transaction->payment_code);
    }

    public function test_cannot_change_payment_method_on_non_pending()
    {
        $user = User::factory()->create();
        $transaction = Transaction::create([
            'user_id' => $user->id,
            'total_amount' => 10,
            'status' => 'paid',
            'payment_method' => 'bank_transfer',
        ]);

        $this->actingAs($user)
            ->from(route('payment.show', $transaction))
            ->patch(route('payment.updateMethod', $transaction), [
                'payment_method' => 'ewallet',
            ]);

        $this->assertSame('bank_transfer', $transaction->fresh()->payment_method);
    }

    public function test_user_can_verify_payment()
    {
        $user = User::factory()->create();
        $game = $this->createGame();
        $transaction = Transaction::create([
            'user_id' => $user->id,
            'total_amount' => $game->price,
            'status' => 'pending',
            'payment_method' => 'bank_transfer',
        ]);

        $this->actingAs($user)->post(route('payment.verify', $transaction));

        $this->assertSame('paid', $transaction->fresh()->status);
        $this->assertEquals(
            'Payment submitted. Waiting for admin confirmation.',
            session('status')
        );
    }

    public function test_other_user_cannot_verify_payment()
    {
        $user = User::factory()->create();
        $other = User::factory()->create();
        $transaction = Transaction::create([
            'user_id' => $user->id,
            'total_amount' => 10,
            'status' => 'pending',
            'payment_method' => 'bank_transfer',
        ]);

        $this->actingAs($other)
            ->post(route('payment.verify', $transaction))
            ->assertForbidden();
    }

    public function test_completed_payment_redirects_verify_to_my_games()
    {
        $user = User::factory()->create();
        $transaction = Transaction::create([
            'user_id' => $user->id,
            'total_amount' => 10,
            'status' => 'paid',
            'payment_method' => 'bank_transfer',
        ]);

        $this->actingAs($user)->post(route('payment.verify', $transaction))
            ->assertRedirect(route('user.my-games'));
    }

    // ─── Library Access ──────────────────────────────────────────────────────

    public function test_my_games_shows_owned_games()
    {
        $user = User::factory()->create();
        $game = $this->createGame();
        $transaction = Transaction::create([
            'user_id' => $user->id,
            'total_amount' => $game->price,
            'status' => 'completed',
        ]);
        $transaction->items()->create([
            'game_id' => $game->id,
            'quantity' => 1,
            'price' => $game->price,
        ]);

        $response = $this->actingAs($user)->get(route('user.my-games'));

        $response->assertOk();
        $response->assertSee($game->title);
    }

    public function test_my_games_excludes_unowned_games()
    {
        $user = User::factory()->create();
        $other = User::factory()->create();
        $game = $this->createGame();
        $transaction = Transaction::create([
            'user_id' => $other->id,
            'total_amount' => $game->price,
            'status' => 'completed',
        ]);
        $transaction->items()->create([
            'game_id' => $game->id,
            'quantity' => 1,
            'price' => $game->price,
        ]);

        $response = $this->actingAs($user)->get(route('user.my-games'));

        $response->assertOk();
        $response->assertDontSee($game->title);
    }

    public function test_my_games_shows_only_completed_transactions()
    {
        $user = User::factory()->create();
        $completedGame = $this->createGame(['title' => 'Completed Game']);
        $paidGame = $this->createGame(['title' => 'Paid Game']);

        $t1 = Transaction::create([
            'user_id' => $user->id,
            'total_amount' => $completedGame->price,
            'status' => 'completed',
        ]);
        $t1->items()->create(['game_id' => $completedGame->id, 'quantity' => 1, 'price' => $completedGame->price]);

        $t2 = Transaction::create([
            'user_id' => $user->id,
            'total_amount' => $paidGame->price,
            'status' => 'paid',
        ]);
        $t2->items()->create(['game_id' => $paidGame->id, 'quantity' => 1, 'price' => $paidGame->price]);

        $response = $this->actingAs($user)->get(route('user.my-games'));

        $response->assertSee('Completed Game');
        $response->assertDontSee('Paid Game');
    }

    public function test_my_games_returns_distinct_games()
    {
        $user = User::factory()->create();
        $game = $this->createGame();

        $t1 = Transaction::create([
            'user_id' => $user->id,
            'total_amount' => $game->price,
            'status' => 'completed',
        ]);
        $t1->items()->create(['game_id' => $game->id, 'quantity' => 1, 'price' => $game->price]);

        $t2 = Transaction::create([
            'user_id' => $user->id,
            'total_amount' => $game->price,
            'status' => 'completed',
        ]);
        $t2->items()->create(['game_id' => $game->id, 'quantity' => 1, 'price' => $game->price]);

        $response = $this->actingAs($user)->get(route('user.my-games'));

        $response->assertOk();
        $this->assertStringContainsString($game->title, $response->content());
    }

    public function test_purchase_history_shows_transactions()
    {
        $user = User::factory()->create();
        $game = $this->createGame();
        $transaction = Transaction::create([
            'user_id' => $user->id,
            'total_amount' => $game->price,
            'status' => 'pending',
        ]);
        $transaction->items()->create([
            'game_id' => $game->id,
            'quantity' => 1,
            'price' => $game->price,
        ]);

        $response = $this->actingAs($user)->get(route('user.purchase-history.index'));

        $response->assertOk();
    }

    public function test_other_user_cannot_view_purchase_detail()
    {
        $user = User::factory()->create();
        $other = User::factory()->create();
        $game = $this->createGame();
        $transaction = Transaction::create([
            'user_id' => $user->id,
            'total_amount' => $game->price,
            'status' => 'paid',
        ]);

        $this->actingAs($other)
            ->get(route('user.purchase-history.detail', $transaction))
            ->assertForbidden();
    }

    public function test_other_user_cannot_download_receipt()
    {
        $user = User::factory()->create();
        $other = User::factory()->create();
        $game = $this->createGame();
        $transaction = Transaction::create([
            'user_id' => $user->id,
            'total_amount' => $game->price,
            'status' => 'paid',
        ]);

        $this->actingAs($other)
            ->get(route('user.purchase-history.receipt', $transaction))
            ->assertForbidden();
    }

    // ─── Full Lifecycle ──────────────────────────────────────────────────────

    public function test_complete_purchase_lifecycle()
    {
        $user = User::factory()->create();
        $game = $this->createGame([
            'title' => 'Lifecycle Game',
            'price' => 49.99,
        ]);

        // 1. Add to cart
        $this->actingAs($user)->post(route('cart.store', $game));
        $this->assertNotEmpty(session('cart'));

        // 2. Checkout
        $this->actingAs($user)->post(route('checkout.store'), [
            'payment_method' => 'bank_transfer',
        ]);
        $transaction = Transaction::where('user_id', $user->id)->first();
        $this->assertNotNull($transaction);
        $this->assertEmpty(session('cart'));

        // 3. View payment page
        $this->actingAs($user)->get(route('payment.show', $transaction))->assertOk();

        // 4. Simulate admin confirming payment
        $transaction->update(['status' => 'completed']);

        // 5. Verify library access
        $response = $this->actingAs($user)->get(route('user.my-games'));
        $response->assertSee('Lifecycle Game');

        // 6. Verify purchase history
        $this->actingAs($user)->get(route('user.purchase-history.index'))->assertOk();
        $this->actingAs($user)->get(route('user.purchase-history.detail', $transaction))->assertOk();
    }

    public function test_complete_purchase_lifecycle_with_qris()
    {
        $user = User::factory()->create();
        $game = $this->createGame(['title' => 'QRIS Game']);

        $this->actingAs($user)->post(route('cart.store', $game));
        $this->actingAs($user)->post(route('checkout.store'), [
            'payment_method' => 'qris',
        ]);

        $transaction = Transaction::where('user_id', $user->id)->first();
        $this->assertStringStartsWith('ID1029000', $transaction->payment_code);

        $transaction->update(['status' => 'completed']);

        $response = $this->actingAs($user)->get(route('user.my-games'));
        $response->assertSee('QRIS Game');
    }
}
