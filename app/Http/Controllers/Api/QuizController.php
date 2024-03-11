<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuizController extends Controller
{
  public function index($id)
  {
    $quiz = DB::table('questionbank_quizzes')
      ->join('questionbank', 'questionbank.id',  'questionbank_quizzes.questionbank_id')
      ->join('quizzes', 'quizzes.id', 'questionbank_quizzes.quize_id')
      ->where('quizzes.id', $id)
      ->first();

    $jsonString = $quiz->answers;

    $dataArray = json_decode($jsonString, true);

    $data = [
      'quiz_tittle' => $quiz->title,
      'quiz_duraction' =>  $quiz->dueration,
      'question_data' => [[
        'id' => $quiz->id,
        'question' => $quiz->question,
        'created_at' => $quiz->created_at,
        'answers' => $dataArray,
      ]]
    ];
    return response()->json($data, 200);
  }
}
