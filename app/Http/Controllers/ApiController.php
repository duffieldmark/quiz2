<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Quiz;

class ApiController extends Controller
{
    public function getAllQuizzes() {
        $quizzes = Quiz::get()->toJson(JSON_PRETTY_PRINT);
        return response($quizzes, 200);
    }

    public function createQuiz(Request $request) {
        $quiz = new Quiz;
        $quiz->quiz_title = $request->quiz_title;
        $quiz->save();

        return response()->json(["message" => "Quiz created"], 201);
    }

    public function getQuiz($id) {
        if (Quiz::where('id', $id)->exists()) {
            $quiz = Quiz::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
            return response($quiz, 200);
        }
        return response()->json([
            "message" => "Quiz not found"
        ], 404);

    }

    public function updateQuiz(Request $request, $id) {
        if (Quiz::where('id', $id)->exists()) {
            $quiz = Quiz::find($id);
            $quiz->quiz_title = is_null($request->quiz_title) ? $quiz->quiz_title : $request->quiz_title;
            $quiz->save();

            return response()->json([
                "message" => "Quiz updated successfully"
            ], 200);
            } else {
            return response()->json([
                "message" => "Quiz not updated"
            ], 404);

        }
    }

    public function deleteQuiz ($id) {
        if(Quiz::where('id', $id)->exists()) {
            $quiz = Quiz::find($id);
            $quiz->delete();
            $relatedQuestions = Quiz\Question::where('quiz_id', $id);
            $relatedQuestions->delete();

            return response()->json([
                "message" => "Quiz deleted"
            ],202);
        } else {
            return response()->json([
                "message" => "Quiz not found"
            ], 404);
        }
    }

    // Questions logic
    public function getAllQuestions() {
        $questions = Quiz\Question::all();
        return $questions;
    }

    public function updateQuestion(Request $request, $id) {
        if(Quiz\Question::where('id', $id)->exists()) {
            $question = Quiz\Question::find($id);
            $question->quiz_id = is_null($request->quiz_id) ? $question->quiz_id : $request->quiz_id;
            $question->question_text = is_null($request->question_text) ? $question->question_text : $request->question_text;
            $question->question_answer_a = is_null($request->question_answer_a) ? $question->question_answer_a : $request->question_answer_a;
            $question->question_answer_b = is_null($request->question_answer_b) ? $question->question_answer_b : $request->question_answer_b;
            $question->question_answer_c = is_null($request->question_answer_c) ? $question->question_answer_c : $request->question_answer_c;
            $question->question_answer_d = is_null($request->question_answer_d) ? NULL : $request->question_answer_d;
            $question->question_answer_e = is_null($request->question_answer_e) ? NULL : $request->question_answer_e;
            $question->question_correct_answer = is_null($request->question_correct_answer) ? $question->question_correct_answer : $request->question_correct_answer;
            $question->save();

            return response()->json([
                "message" => "Question updated successfully"
            ], 200);
            } else {
            return response()->json([
                "message" => "Question not updated"
            ], 404);
        }
    }

    // public function deleteAnswer(Request $request, $id, $answer) {
    //     if(Quiz\Question::where('id', $id)->exists()) {
    //         $question = Quiz\Question::find($id);
    //         // $question->quiz_id = is_null($request->quiz_id) ? $question->quiz_id : $request->quiz_id;
    //         // $question->question_text = is_null($request->question_text) ? $question->question_text : $request->question_text;
    //         if ($answer == 'a'){
    //             $question->question_answer_a = NULL;
    //         }
    //         if ($answer == 'b'){
    //             $question->question_answer_b = NULL;
    //         }
    //         // Have a proper look at this...


    //         // $question->question_answer_b = is_null($request->question_answer_b) ? $question->question_answer_b : $request->question_answer_b;
    //         // $question->question_answer_c = is_null($request->question_answer_c) ? $question->question_answer_c : $request->question_answer_c;
    //         // $question->question_answer_d = is_null($request->question_answer_d) ? $question->question_answer_d : $request->question_answer_d;
    //         // $question->question_answer_e = is_null($request->question_answer_e) ? $question->question_answer_e : $request->question_answer_e;
    //         // $question->question_correct_answer = is_null($request->question_correct_answer) ? $question->question_correct_answer : $request->question_correct_answer;
    //         $question->save();

    //         return response()->json([
    //             "message" => "Answer deleted successfully"
    //         ], 200);
    //         } else {
    //         return response()->json([
    //             "message" => "Answer not deleted"
    //         ], 404);
    //     }

    // }

    public function deleteQuestion ($id) {
        if(Quiz\Question::where('id', $id)->exists()) {
            $question = Quiz\Question::find($id);
            $question->delete();

            return response()->json([
                "message" => "Question deleted"
            ],202);
        } else {
            return response()->json([
                "message" => "Question not found"
            ], 404);
        }
    }

    public function addQuestion (Request $request) {
        $question = new Quiz\Question;
        $question->quiz_id = $request->quiz_id;
        $question->question_text = $request->question_text;
        $question->question_answer_a = $request->question_answer_a;
        $question->question_answer_b = $request->question_answer_b;
        $question->question_answer_c = $request->question_answer_c;
        $question->question_answer_d = $request->question_answer_d;
        $question->question_answer_e = $request->question_answer_e;
        $question->question_correct_answer = $request->question_correct_answer;
        $question->save();

        return response()->json(["message" => "Question created"], 201);
    }
}
