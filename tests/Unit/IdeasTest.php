<?php

namespace Tests\Unit;

use App\Models\Categorie;
use App\Models\Ideas;
use App\Models\Status;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Foundation\Testing\RefreshDatabase;
// use PHPUnit\Framework\TestCase;
use Tests\TestCase;

class IdeasTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function can_show_ideas_on_single_page()
    {
        $user = User::factory()->create();

        $idea = Ideas::factory()->create([
            'user_id' => User::factory(),
            'status_id' => Status::factory(),
            'category_id' => Categorie::factory(),
            'title' => 'Test title',
            'body' => 'Test body',
        ]);

        // $idea->comments()->create([
        //     'user_id' => $user->id,
        //     'body' => 'This is good Post',
        // ]);

        $response = $this->get(route('ideas.show', ['slug' => $idea->slug]));

        $response->assertSuccessful();
        $response->assertSee($idea->title);
        $response->assertSee($idea->body);
        $response->assertSee($idea->created_at->diffForHumans());
        $response->assertSee($idea->category->name);
        $response->assertSee($idea->status->name);
        $response->assertSee($idea->user->name);
        $response->assertSee($idea->comments_count);
        $response->assertSee($idea->votes_count);

        if($idea->has('comments')){
            $response->assertSee($idea->comments->first());
        }

        if($user->id === $idea->user_id){
            $response->assertSee('(me)');
        }
    }

    /** @test */
    public function can_check_if_idea_is_voted_for_by_user()
    {
        $user = User::factory()->create();
        $userB = User::factory()->create();

        $idea = Ideas::factory()->create();

        Vote::factory()->create([
            'idea_id' => $idea->id,
            'user_id' => $user->id,
        ]);

        $this->assertTrue($idea->isVotedByUser($user));
        $this->assertFalse($idea->isVotedByUser($userB));
        $this->assertFalse($idea->isVotedByUser(null));
    }
}
