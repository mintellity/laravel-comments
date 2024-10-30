<?php

namespace Mintellity\Comments\Tests;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\LivewireServiceProvider;
use Mintellity\Comments\CommentServiceProvider;
use Mintellity\Comments\Services\CommentService;
use Orchestra\Testbench\TestCase;
use Livewire\Livewire;
use Mintellity\Comments\Http\Livewire\CommentSection;
use Workbench\App\Models\Dummy;
use Workbench\App\Models\DummyAuthor;

class StoreTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        // Load the migrations
        $this->loadMigrationsFrom(__DIR__ . '/../workbench/database/migrations');

        // Run the migrations
        $this->artisan('migrate', ['--database' => 'sqlite'])->run();
    }

    protected function getPackageProviders($app)
    {
        return [
            CommentServiceProvider::class,
            LivewireServiceProvider::class
        ];
    }

    /** @test */
    public function test_can_store_comment()
    {
        // Create a Dummy/DummyAuthor model instance
        $model = Dummy::factory()->create(['name' => 'Test Dummy']);
        $author = DummyAuthor::factory()->create(['name' => 'Test Author']);

        // Define the comment content
        $commentContent = 'This is a test comment';

        Livewire::test(CommentSection::class)
            ->set('model', $model)
            ->set('author', $author)
            ->set('commentContent', $commentContent)
            ->call('store');

        // Assert that the comment was stored in the database
        $this->assertDatabaseHas('comments', [
            'comment_content' => $commentContent,
            'modelable_id' => $model->id,
            'modelable_type' => get_class($model),
            'userable_id' => $author->id,
            'userable_type' => get_class($author),
        ]);
    }
}
