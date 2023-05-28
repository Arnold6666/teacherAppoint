<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Teacher;
use App\Models\Curriculum;

class UpdateTeacherRatings extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-teacher-ratings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        //
        $teachers = Teacher::all();
        foreach($teachers as $teacher){
            $averageStars = Curriculum::where('teacher_id', $teacher->id)->whereNotNull('stars')->avg('stars');
            $commentCount = Curriculum::where('teacher_id', $teacher->id)->whereNotNull('comment')->count();

            $teacher->stars = $averageStars;
            $teacher->comments = $commentCount;
            $teacher->save();
        }
        
        $this->info('教師評分已更新');
    }
}
