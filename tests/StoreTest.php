<?php
//
//namespace Mintellity\Comments\Tests;
//
//use Illuminate\Foundation\Testing\RefreshDatabase;
//use Illuminate\Support\Str;
//use Livewire\LivewireServiceProvider;
//use Mintellity\Comments\CommentServiceProvider;
//use Mintellity\Comments\Services\CommentService;
//use Orchestra\Testbench\TestCase;
//use Workbench\App\Models\Dummy;
//use Workbench\App\Models\DummyAuthor;
//
//class StoreTest extends TestCase
//{
//    use RefreshDatabase;
//    public function setUp(): void
//    {
//        parent::setUp();
//
//        $this->loadMigrationsFrom(__DIR__ . '/../workbench/database/migrations');
//        $this->artisan('migrate', ['--database' => 'sqlite'])->run();
//
//        $this->commentService = new CommentService();
//    }
//
//    protected function getPackageProviders($app)
//    {
//        return [
//            CommentServiceProvider::class,
//            LivewireServiceProvider::class
//        ];
//    }
//
//    /** @test */
//    public function test_can_store_comment()
//    {
//        $this->artisan('migrate', ['--database' => 'sqlite'])->run();
//
//        $model = Dummy::create(['name' => 'Test Dummy']);
//        $author = DummyAuthor::create(['name' => 'Test Author']);
//
//        $commentContent = 'This is a test comment';
//
//        $this->commentService->test($model, $author, $commentContent);
//
//        $this->assertDatabaseHas('comments', [
//            'comment_id' => Str::uuid(),
//            'comment_content' => $commentContent,
//            'modelable_id' => $model->dummy_id,
//            'modelable_type' => get_class($model),
//            'userable_id' => $author->dummy_author_id,
//            'userable_type' => get_class($author),
//        ]);
//
////        Comment::create([
////            'comment_id' => 123,
////            'comment_content' => $commentContent,
////            'modelable_id' => $model->id,
////            'modelable_type' => get_class($model),
////            'userable_id' => $author->id,
////            'userable_type' => get_class($author),
////        ]);
//    }
//}


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

    protected $commentService;

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
