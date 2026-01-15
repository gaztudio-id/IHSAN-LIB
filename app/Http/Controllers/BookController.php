<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::query();

        // 1. Search (Title/Author)
        if ($request->filled('search')) {
            $term = $request->search;
            $query->where(function($q) use ($term) {
                 $q->where('title', 'like', '%' . $term . '%')
                   ->orWhere('author', 'like', '%' . $term . '%');
            });
        }

        // 2. Filter by Category
        if ($request->filled('category')) {
             $query->where('category', $request->category);
        }

        // 3. Filter by Year
        if ($request->filled('pub_year')) {
             $query->where('year', $request->pub_year);
        }

        // Execute
        $books = $query->latest()->paginate(10)->withQueryString();

        // Filter Data
        $categories = Book::whereNotNull('category')->distinct()->orderBy('category')->pluck('category');
        $years = Book::whereNotNull('year')->distinct()->orderBy('year', 'desc')->pluck('year');

        return view('admin.books.index', compact('books', 'categories', 'years'));
    }

    public function create()
    {
        return view('admin.books.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'author' => 'required',
            'barcode' => 'required|unique:books,barcode', 
            'stock' => 'required|integer',
            'category' => 'required',
            'year' => 'nullable|integer',
            'publisher' => 'nullable|string',
            'shelf_location' => 'nullable|string'
        ]);

        Book::create($request->all());

        return redirect()->route('admin.books.index')->with('success', 'Book created successfully.');
    }

    public function edit(Book $book)
    {
        return view('admin.books.edit', compact('book'));
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required',
            'author' => 'required',
            'barcode' => 'required|unique:books,barcode,'.$book->id,
            'stock' => 'required|integer',
            'category' => 'required',
            'year' => 'nullable|integer',
            'publisher' => 'nullable|string',
            'shelf_location' => 'nullable|string'
        ]);

        $book->update($request->all());

        return redirect()->route('admin.books.index')->with('success', 'Book updated successfully.');
    }

    public function destroy(Book $book)
    {
        $book->delete();
        return redirect()->route('admin.books.index')->with('success', 'Book deleted successfully.');
    }
}
