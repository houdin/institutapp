<?php

namespace App\Http\Controllers;

use App\Helpers\Auth\Auth;
use App\Models\Module;
use App\Models\Media;
use App\Models\Question;
use App\Models\QuestionsOption;
use App\Models\Test;
use App\Models\TestsResult;
use App\Models\TestsResultsAnswer;
use App\Models\VideoProgress;
use Illuminate\Http\Request;

class ModulesController extends Controller
{

    private $path;

    public function __construct()
    {
    }

    public function show($formation_id, $module_slug)
    {
        $test_result = "";
        $completed_modules = "";
        $module = Module::where('slug', $module_slug)->where('formation_id', $formation_id)->where('published', '=', 1)->first();

        if ($module == "") {
            $module = Test::where('slug', $module_slug)->where('formation_id', $formation_id)->where('published', '=', 1)->firstOrFail();
            $module->full_text = $module->description;

            $test_result = NULL;
            if ($module) {
                $test_result = TestsResult::where('test_id', $module->id)
                    ->where('user_id', \Auth::id())
                    ->first();
            }
        }

        if ((int)config('module_timer') == 0) {
            if ($module->chapterStudents()->where('user_id', \Auth::id())->count() == 0) {
                $module->chapterStudents()->create([
                    'model_type' => get_class($module),
                    'model_id' => $module->id,
                    'user_id' => auth()->user()->id,
                    'formation_id' => $module->formation->id
                ]);
            }
        }

        $formation_modules = $module->formation->modules->pluck('id')->toArray();
        $formation_tests = ($module->formation->tests) ? $module->formation->tests->pluck('id')->toArray() : [];
        $formation_modules = array_merge($formation_modules, $formation_tests);

        $previous_module = $module->formation->formationTimeline()
            ->where('sequence', '<', $module->formationTimeline->sequence)
            ->whereIn('model_id', $formation_modules)
            ->orderBy('sequence', 'desc')
            ->first();

        $next_module = $module->formation->formationTimeline()
            ->whereIn('model_id', $formation_modules)
            ->where('sequence', '>', $module->formationTimeline->sequence)
            ->orderBy('sequence', 'asc')
            ->first();

        $modules = $module->formation->formationTimeline()
            ->whereIn('model_id', $formation_modules)
            ->orderby('sequence', 'asc')
            ->get();



        $purchased_formation = $module->formation->students()->where('user_id', \Auth::id())->count() > 0;
        $test_exists = FALSE;

        if (get_class($module) == 'App\Models\Test') {
            $test_exists = TRUE;
        }

        $completed_modules = \Auth::user()->chapters()
            ->where('formation_id', $module->formation->id)
            ->get()
            ->pluck('model_id')
            ->toArray();

        if (request()->ajax() || request()->api == true) {
            return response()->json([
                'module' => $module,
                'previous_module' => $previous_module,
                'next_module' => $next_module,
                'test_result' => $test_result,
                'purchased_formation' => $purchased_formation,
                'test_exists' => $test_exists,
                'modules' => $modules,
                'completed_modules' => $completed_modules
            ]);
        }

        return view('frontend.formations.module', compact(
            'module',
            'previous_module',
            'next_module',
            'test_result',
            'purchased_formation',
            'test_exists',
            'modules',
            'completed_modules'
        ));
    }

    public function test($module_slug, Request $request)
    {
        $test = Test::where('slug', $module_slug)->firstOrFail();
        $answers = [];
        $test_score = 0;
        foreach ($request->get('questions') as $question_id => $answer_id) {
            $question = Question::find($question_id);
            $correct = QuestionsOption::where('question_id', $question_id)
                ->where('id', $answer_id)
                ->where('correct', 1)->count() > 0;
            $answers[] = [
                'question_id' => $question_id,
                'option_id' => $answer_id,
                'correct' => $correct
            ];
            if ($correct) {
                if ($question->score) {
                    $test_score += $question->score;
                }
            }
            /*
             * Save the answer
             * Check if it is correct and then add points
             * Save all test result and show the points
             */
        }
        $test_result = TestsResult::create([
            'test_id' => $test->id,
            'user_id' => \Auth::id(),
            'test_result' => $test_score,
        ]);
        $test_result->answers()->createMany($answers);


        if ($test->chapterStudents()->where('user_id', \Auth::id())->get()->count() == 0) {
            $test->chapterStudents()->create([
                'model_type' => $test->model_type,
                'model_id' => $test->id,
                'user_id' => auth()->user()->id,
                'formation_id' => $test->formation->id
            ]);
        }

        if (request()->ajax() || request()->api == true) {
            return response()->json([
                'redirect' => 'back',
                'message' => 'Test score: ' . $test_score,
                'result' => $test_result
            ]);
        }


        return back()->with(['message' => 'Test score: ' . $test_score, 'result' => $test_result]);
    }

    public function retest(Request $request)
    {
        $test = TestsResult::where('id', '=', $request->result_id)
            ->where('user_id', '=', auth()->user()->id)
            ->first();
        $test->delete();

        if (request()->ajax() || request()->api == true) {
            return response()->json([
                'redirect' => 'back'
            ]);
        }

        return back();
    }

    public function videoProgress(Request $request)
    {
        $user = auth()->user();
        $video = Media::findOrFail($request->video);
        $video_progress = VideoProgress::where('user_id', '=', $user->id)
            ->where('media_id', '=', $video->id)->first() ?: new VideoProgress();
        $video_progress->media_id = $video->id;
        $video_progress->user_id = $user->id;
        $video_progress->duration = $video_progress->duration ?: round($request->duration, 2);
        $video_progress->progress = round($request->progress, 2);
        if ($video_progress->duration - $video_progress->progress < 5) {
            $video_progress->progress = $video_progress->duration;
            $video_progress->complete = 1;
        }
        $video_progress->save();

        if (request()->ajax() || request()->api == true) {
            return response()->json([
                'video_progress' => $video_progress->progress,
            ]);
        }
        return $video_progress->progress;
    }


    public function formationProgress(Request $request)
    {
        if (\Auth::check()) {
            $module = Module::find($request->model_id);
            if ($module != null) {
                if ($module->chapterStudents()->where('user_id', \Auth::id())->get()->count() == 0) {
                    $module->chapterStudents()->create([
                        'model_type' => $request->model_type,
                        'model_id' => $request->model_id,
                        'user_id' => auth()->user()->id,
                        'formation_id' => $module->formation->id
                    ]);
                    return true;
                }
            }
        }
        return false;
    }

    public function check_result_question(Request $request)
    {
        $question = Question::where('id', $request->question_id)->first();

        $result = $question->isAttempted($request->result_id);
        if (request()->ajax() || request()->api == true) {
            return response()->json([
                'result' => $result,
            ]);
        }
    }

    public function question_option_answered(Request $request)
    {

        $option =
            QuestionsOption::where('id', $request->option_id)->first();

        $answered = $option->answered($request->result_id);

        if (request()->ajax() || request()->api == true) {
            return response()->json([
                'answered' => $answered,
            ]);
        }
    }

    public function media_progress(Request $request)
    {

        $media =
            Media::where('id', $request->media_id)->first();

        $progress = $media->getProgress(auth()->user()->id);

        if (request()->ajax() || request()->api == true) {
            return response()->json([
                'progress' => $progress,
            ]);
        }
    }
}
