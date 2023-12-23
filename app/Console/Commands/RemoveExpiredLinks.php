<?php

namespace App\Console\Commands;

use App\Models\Link;
use Illuminate\Console\Command;

class RemoveExpiredLinks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'link:remove-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove all expired links';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $now = now();
        $total = Link::where('expire_at', '<=', $now)->count();

        $this->info("Total link(s) that will be deleted : $total");
        if ($this->confirm('Continue?')) {
            // remove permanently all links that created by anonymous
            // has user that not pro
            Link::query()
                ->where(
                    fn ($q) => $q->whereNull('user_id')
                        ->orWhereHas('user', fn ($user) => $user->where('is_pro', false))
                )
                ->where('expire_at', '<=', $now)
                ->forceDelete();

            // 'move to trash' premium users link
            Link::where('expire_at', '<=', $now)->delete();

            $this->info('Success');
        } else {
            $this->info('Action canceled');
        }

        return Command::SUCCESS;
    }
}
