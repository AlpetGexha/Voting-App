<?php

namespace Tests\Unit;

use App\Http\Livewire\Idea\Create;
use App\Http\Livewire\Idea\Ideas as IdeaIdeas;
use App\Models\Categorie;
use App\Models\Ideas;
use App\Models\Status;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Livewire;
use PhpOffice\PhpSpreadsheet\Calculation\Category;
use Tests\TestCase;

class IdeasCreatedTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function create_idea_form_does_not_show_when_logged_out()
    {
        $response = $this->get(route('ideas.ideas'));

        $response->assertSuccessful();
        $response->assertSee('Please login to create an idea.');
        $response->assertDontSee('Let us know what you would like and we will take a look over!', false);
    }

    /** @test */
    public function can_main_page_see_create_ideas_livewire_component()
    {
        $this->actingAs(User::factory()->create())
            ->get(route('ideas.ideas'))
            ->assertSeeLivewire('idea.create');
    }
    /** @test */
    public function create_idea_form_validation_works()
    {
        Livewire::actingAs(User::factory()->create())
            ->test(CreateIdea::class)
            ->set('title', '')
            ->set('body', '')
            ->set('category', '')
            ->call('createIdea', '')
            ->assertHasErrors(['title', 'category', 'description'])
            ->assertSee('The title field is required');
    }

    /** @test */
    public function can_user_create_ideas_on_right_way()
    {
        $user = User::factory()->create();
        $categore = Categorie::factory()->create();
        $satus = Status::factory()->create([
            'name' => 'open',
        ]);

        Livewire::actingAs($user)
            ->test(Create::class)
            ->set('title', 'My good title is hit')
            ->set('body', 'Pem doket sot kerka nuk jom')
            ->set('category', $categore->id)
            ->call('create');

        // $this->assertTrue(IdeaIdeas::whereTitle('My good title is hit')->exists());

        $respose = $this->actingAs($user)->get(route('ideas.ideas'));
        $respose->assertSuccessful();
        // $respose->assertSee('My good title is hit');
        // $respose->assertSee('Pem doket sot kerka nuk jom');

        $this->assertDatabaseHas('ideas', [
            'title' => 'My good title is hit'
        ]);

        $this->assertDatabaseHas('votes', [
            'user_id' => $user->id,
            'ideas_id' => 1
        ]);
    }

    /** @test */
    public function can_ideas_work_with_same_title_and_different_slug()
    {
        $this->withoutExceptionHandling();

        $user = User::factory()->create();

        $categoryOne = Categorie::factory()->create();

        $statusOpen = Status::factory()->create(['name' => 'Open']);

        // Create First
        Livewire::actingAs($user)
            ->test(Create::class)
            ->set('title', 'My First Idea Ever')
            ->set('category', $categoryOne->id)
            ->set('body', 'This is my first idea')
            ->call('create');

        // Check if Ideas Exist
        $this->assertDatabaseHas('ideas', [
            'title' => 'My First Idea Ever',
            'slug' => 'my-first-idea-ever'
        ]);

        // remove Rate Limit
        RateLimiter::clear('send-idea' . $user->id);
        // forgot RateLimiter


        // Create Second Ideas
        Livewire::actingAs($user)
            ->test(Create::class)
            ->set('title', 'My First Idea Ever')
            ->set('category', $categoryOne->id)
            ->set('body', 'This is my first idea')
            ->call('create');

            // check if function sluggable is on Ideas Model
            $ideasModel = new Ideas();

            $this->assertTrue(method_exists($ideasModel, 'sluggable'));

            // $this->assertDatabaseHas('ideas', [
            //     'title' => 'My First Idea Ever',
            //     'slug' => 'my-first-idea-ever-1'
            // ]);

        // dd(Ideas::all());
    }
}
