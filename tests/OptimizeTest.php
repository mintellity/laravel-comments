<?php

namespace Mintellity\CommentPackage\Tests;

use Orchestra\Testbench\TestCase;

class OptimizeTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return [
            \Mintellity\CommentPackage\CommentServiceProvider::class,
        ];
    }

    /** @test */
    public function it_can_run_optimize_clear_command()
    {
        $this->artisan('optimize:clear')
            ->assertExitCode(0);
    }
}
