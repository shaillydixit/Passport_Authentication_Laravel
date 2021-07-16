<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use App\Models\Author;

class BookController extends Controller
{
    //Create Method - Api
    public function createBook(Request $request)
    {
        //validation
        $request->validate([
            'title' => 'required',
            'book_cost' => 'required'
        ]);
        //create book data
        $book = new Book();
        $book->author_id = auth()->user()->id;
        $book->title = $request->title;
        $book->description = $request->description;
        $book->book_cost = $request->book_cost;
        //save
        $book->save();
        //send response
        return response()->json([
            'status' => 1,
            'message' => 'book created successfully'
        ]);
    }

    //List Method - Api
    public function listBook()
    {
        $books = Book::get();

        return response()->json([
            'status' => 1,
            'message' => 'list of all books',
            'data' => $books
        ]);
    }

    //Author Book Method - Api
    public function authorBook()
    {
        $author_id = auth()->user()->id;
        $books = Author::find($author_id)->books;

        return response()->json([
            'status' => 1,
            'message' => 'author books',
            'data' => $books
        ]);
    }

    //SingleBook Method - Api
    public function singleBook($book_id)
    {
        $author_id = auth()->user()->id;

        if (Book::where([
            'author_id' => $author_id,
            'id' => $book_id
        ])->exists()) {

            $book = Book::find($book_id);

            return response()->json([
                'status' => true,
                'message' => 'Book Details',
                'data' => $book
            ]);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Book does not exist',
            ]);
        }
    }

    //Update Method - Api
    public function updateBook(Request $request, $book_id)
    {
    }

    //Delete Method - Api
    public function deleteBook($book_id)
    {
    }
}
