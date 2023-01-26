<?php

namespace Tests\Feature;

use App\Models\Ideas;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IdeasShowPage extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function can_show_ideas_show_pages()
    {
        $ideas = Ideas::factory()->create([
            'title' => 'This is a title',
            'body' => 'This is a body',
            'slug' => 'this-is-a-title',
        ]);
        $response = $this->get(route('ideas.show', ['slug', $ideas->slug]));

        $response->assertSee($ideas->title);
        $response->assertSee($ideas->body);

        $response->assertStatus(200);
    }
}
