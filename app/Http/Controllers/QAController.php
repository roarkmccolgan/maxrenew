<?php

namespace App\Http\Controllers;

use App\Notifications\QuestionAsked;
use App\Product;
use App\QA;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class QAController extends Controller
{
    public function create(Request $request){
        $product = Product::findOrFail($request->input('product_id'));
        $question = new QA([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'comment' => $request->input('comment'),
            'parent_id' => NULL,
        ]);

        $product->questions()->save($question);

        Notification::route('mail', 'roarkmccolgan@gmail.com')
            ->notify(new QuestionAsked($product,$question,$request->input('name'),$request->input('email')));
        
        $data = [
            'question' => $question,
        ];
        if($request->wantsJson()){
            return collect($data);
        }
    }
    public function answerQuestion(Request $request){
        if(Auth::check()){
            $user = Auth::user()->getUserInfo();
            if($user['http://maxrenew.co.za/is_admin']){
                $question = QA::findOrFail($request->input('question_id'));
                $answer = new QA([
                    'product_id' => $question->product_id,
                    'name' => $user['nickname'],
                    'email' => $user['email'],
                    'comment' => $request->input('comment'),
                ]);
                $question->answers()->save($answer);
                
                $data = [
                    'question' => $answer,
                ];
                if($request->wantsJson()){
                    return collect($data);
                }
            }
        }
        abort(403, 'You are not authorized to answer questions.');
    }
}
