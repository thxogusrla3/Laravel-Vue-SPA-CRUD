<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $redis = Redis::connection();
        $books = Book::all();
        Redis::set('books', $books);

        $all_book = $redis->get('books');
        return $all_book;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function add(Request $request)
    {
        $redis = Redis::connection();
        $book = Book::create([
            'name' => $request->input('name'),
            'author' => $request->input('author')
        ]);
        
        $redis->append('books', $book);
        return response()->json("add success");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(
        Request $request, 
        $id
    ){
        $book=Book::find($id);    
        $book->update($request->all());

        return response()->json('update success');
    }

    // edit book
    public function edit($id)
    {
        $book = Book::find($id);
        return response()->json($book);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $book = Book::find($id);
        $book->delete();
        Redis::set('books', $book);
        return response()->json("delete success");
    }

}
