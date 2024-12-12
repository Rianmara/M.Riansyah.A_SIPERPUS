<?php

namespace App\Http\Controllers;

use App\Exports\BooksExport;
use App\Imports\BooksImport;
use App\Models\Book;
use App\Models\Bookshelf;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class BookController extends Controller
{
    public function index(){
        $data['books'] = Book::with('bookshelf')->get();
        return view('books.index', $data);
    }

    public function create(){
        $data['bookshelves'] = Bookshelf::get();
        return view('books.create', $data);
    }
    public function edit(string $id){
        $data['bookshelves'] = Bookshelf::get();
        $data['book'] = Book::findOrFail($id);
        return view('books.edit', $data);
    }


    public function store(Request $request){
        $validated = $request->validate([
            'title'=> 'required|max:255',
            'author'=> 'required|max:255',
            'year'=> 'required|integer|max:2024',
            'publisher'=> 'required|max:255',
            'city'=> 'required|max:255',
            'cover'=> 'required',
            'bookshelf_id'=> 'required',
        ]);
        if($request->hasFile('cover')){
            $path = $request->file('cover')->storeAs(
                'public/cover_buku',
                'cover_buku_'.time() . '.' . $request->file('cover')->extension()
            );
            $validated['cover'] = basename($path);
        }
        book::create($validated);

        $notification = array (
            'message' => 'Data buku berhasil di hapus',
            'alert-type' => 'success'
        );
        if($request->save == true) return redirect()->route('book')->with($notification);
        else return redirect()->route('book.create')->with($notification);
    }
    public function update(Request $request, string $id){
        $book = Book::findOrFail($id);
        $validated = $request->validate([
            'title'=> 'required|max:255',
            'author'=> 'required|max:255',
            'year'=> 'required|integer|max:2024',
            'publisher'=> 'required|max:255',
            'city'=> 'required|max:255',
            'cover'=> 'required',
            'bookshelf_id'=> 'required',
        ]);
        if($request->hasFile('cover')){
            if($book->cover != null){
                Storage::delete('public/cover_buku'.$request->old_cover);
            }
            $path = $request->file('cover')->storeAs(
                'public/cover_buku',
                'cover_buku_'.time() . '.' . $request->file('cover')->extension()
            );
            $validated['cover'] = basename($path);
        }
        $book->update($validated);
    
        $notification = array (
            'message' => 'Data buku berhasil di update',
            'alert-type' => 'success'
        );
        return redirect()->route('book')->with($notification);
    }

    public function destroy(string $id){
        $book = Book::findOrFail($id);
        Storage::delete('public/cover_buku'.$book->id);
        $book->delete();

        $notification = array (
            'message' => 'Data buku berhasil di update',
            'alert-type' => 'success'
        );
        
        return redirect()->route('book')->with($notification);
    }

    public function print(){
        $data['books'] = Book::with('bookshelf')->get();
        $pdf = Pdf::loadView('books.print',$data);
        return $pdf->download('book.pdf'); 
    }

    public function export(){
        return Excel::download(new BooksExport, 'books.xlsx');
        
    }

    public function import(Request $request){
        Excel::import(new BooksImport,$request->file('file'));
        $notification = array (
            'message'=> 'Data buku berhasil disimpan',
            'alert-type'=> 'success'
        );
        return redirect()->route('book')->with($notification);
        
    }

    // Controller untuk kelola kode rak buku

    public function managebookshelves(){
        $data['bookshelves'] = Bookshelf::get();
        return view("manage-books.index", $data);
    }

    public function managebookshelves_add(Request $rq){
        $data = $rq->validate([
            "code" => "required",
            "name" => "required",
        ]);
        $bookshelve = Bookshelf::create($data);
        if (!$bookshelve) return redirect()->back()->with("failed", "Update Failed");
        return redirect()->back();
    }
    public function managebookshelves_edit(Request $rq, $id){
        $bookshelve = Bookshelf::findOrFail($id);
        if (!$bookshelve) return redirect()->back()->with("failed", "Update Failed");
        $bookshelve->update([
            "id" => $id,
            "code" => $rq->code,
            "name" => $rq->name,
        ]);
        return redirect()->back();
    }
    public function managebookshelves_delete($id){
        $bookshelve = Bookshelf::findOrFail($id);
        if (!$bookshelve) return redirect()->back()->with("failed", "Update Failed");
        $bookshelve->delete();
        return redirect()->back();
    }

    public function managebookshelves_print(){
        $data['bookshelves'] = Bookshelf::get();
        $pdf = Pdf::loadView('manage-books.print',$data);
        return $pdf->download('bookshelves.pdf'); 
    }
}




    