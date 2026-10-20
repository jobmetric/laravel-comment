<?php

namespace JobMetric\Comment;

use JobMetric\PackageCore\Exceptions\MigrationFolderNotFoundException;
use JobMetric\PackageCore\PackageCore;
use JobMetric\PackageCore\PackageCoreServiceProvider;

class CommentServiceProvider extends PackageCoreServiceProvider
{
    /**
     * @throws MigrationFolderNotFoundException
     */
    public function configuration(PackageCore $package): void
    {
        $package->name('laravel-comment')
            ->hasConfig()
            ->hasTranslation()
            ->hasMigration();
    }
    /**
     * Register committed business outcome definitions alongside legacy events.
     *
     * @return void
     */
    public function afterBootPackage(): void
    {
        if ($this->app->bound('EventRegistry')) {
            $registry = $this->app->make('EventRegistry');
            $registry->register(\JobMetric\Comment\Events\Comment\CommentStoreCommittedEvent::class);
            $registry->register(\JobMetric\Comment\Events\Comment\CommentUpdateCommittedEvent::class);
            $registry->register(\JobMetric\Comment\Events\Comment\CommentDeleteCommittedEvent::class);
            $registry->register(\JobMetric\Comment\Events\Comment\CommentApproveCommittedEvent::class);
        }
    }
}
