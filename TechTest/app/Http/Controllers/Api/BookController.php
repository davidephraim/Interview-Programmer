<?php

namespace App\Http\Controllers\Api;

use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get all books with their associated category
        return response()->json(Book::with('category')->get(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate request
        $validator = Validator::make($request->all(), [
            'book_title' => 'required|regex:/^[A-Za-z0-9 ]+$/',
            'book_author' => 'required|regex:/^[A-Za-z ]+$/',
            'category_id' => 'required|exists:categories,id',
            'year_published' => 'required|integer|between:1990,' . date('Y'),
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Generate book code: BK + categoryCode + 2-digit year + sequence number
        $category = Category::findOrFail($request->category_id);
        $categoryCode = $category->category_code;
        $yearSuffix = substr($request->year_published, -2);

        $bookCount = Book::where('category_id', $category->id)
                         ->whereYear('year_published', $request->year_published)
                         ->count();

        $sequence = str_pad($bookCount + 1, 4, '0', STR_PAD_LEFT);
        $bookCode = 'BK' . $categoryCode . $yearSuffix . $sequence;

        // Create book
        $book = Book::create([
            'book_code' => $bookCode,
            'book_title' => $request->book_title,
            'book_author' => $request->book_author,
            'category_id' => $request->category_id,
            'year_published' => $request->year_published,
        ]);

        return response()->json($book, 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $book = Book::with('category')->find($id);

        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        return response()->json($book, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        $validator = Validator::make($request->all(), [
            'book_title' => 'required|regex:/^[A-Za-z0-9 ]+$/',
            'book_author' => 'required|regex:/^[A-Za-z ]+$/',
            'category_id' => 'required|exists:categories,id',
            'year_published' => 'required|integer|between:1990,' . date('Y'),
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $book->update($request->only([
            'book_title',
            'book_author',
            'category_id',
            'year_published',
        ]));

        return response()->json($book, 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $book = Book::find($id);

        if (!$book) {
            return response()->json(['message' => 'Book not found'], 404);
        }

        $book->delete();

        return response()->json(['message' => 'Book successfully deleted'], 200);
    }
}
