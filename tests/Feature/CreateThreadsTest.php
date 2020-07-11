<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations;
    use RefreshDatabase;

    /** @test */
    function guests_may_not_crete_threads()
    {   
        $this->withExceptionHandling();

        $this->get('/threads/create')
            ->assertRedirect('/login');

        $this->post('/threads')
            ->assertRedirect('/login');
    }

    /** @test */
    function an_authenticated_user_can_crete_new_forum_threads()
    {
       // Given we have a signed in user
        $this->signIn();

       // When we hit the endpoint to create a new thread
        $thread = create('App\Thread');

        $this->post('/threads', $thread->toArray());

       // Then, when we visit the thread page.
        $this->get($thread->path())
       // We should see the new thread
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    
    }
}
