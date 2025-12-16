<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\Borrow;
use App\Models\Patron;
use App\Models\Category;
use App\Models\Penalty;
use App\Models\SystemSetting; // Needed for dynamic rules
use Carbon\Carbon;

class LibraryController extends Controller
{
    // ================= PATRON FEATURES =================

    public function index()
    {
        $books = Book::where('availability_status', 'available')->with('category')->get();
        $patrons = Patron::where('account_status', 'active')->get();
        return view('catalog', compact('books', 'patrons'));
    }

    public function storeRequest(Request $request)
    {
        $request->validate(['book_id' => 'required', 'patron_id' => 'required']);

        Borrow::create([
            'book_id' => $request->book_id,
            'patron_id' => $request->patron_id,
            'borrow_date' => Carbon::now(),
            // Due date will be set upon approval
            'status' => 'pending'
        ]);

        $book = Book::find($request->book_id);
        $book->availability_status = 'pending_approval';
        $book->save();

        return redirect('/')->with('success', 'Borrow request submitted!');
    }

    // View History for a specific Patron
    public function patronHistory(Request $request)
    {
        $patrons = Patron::all();
        $selectedPatron = null;
        $myBorrows = [];

        if ($request->has('patron_id')) {
            $selectedPatron = Patron::find($request->patron_id);
            if ($selectedPatron) {
                $myBorrows = Borrow::where('patron_id', $selectedPatron->patron_id)
                                   ->with('book')
                                   ->orderBy('borrow_id', 'desc')
                                   ->get();
            }
        }

        return view('patron_history', compact('patrons', 'selectedPatron', 'myBorrows'));
    }

    // Rule: Patron can extend due date
    public function extendDueDate($borrow_id)
    {
        $borrow = Borrow::find($borrow_id);
        
        if ($borrow->status !== 'active') {
            return back()->with('warning', 'Only active loans can be extended.');
        }

        if (Carbon::now()->gt(Carbon::parse($borrow->due_date))) {
            return back()->with('warning', 'Cannot extend overdue books. Please return and pay penalty.');
        }

        // Extend by 7 days (or could make this dynamic too)
        $borrow->due_date = Carbon::parse($borrow->due_date)->addDays(7);
        $borrow->save();

        return back()->with('success', 'Due date extended by 7 days.');
    }

    // ================= LIBRARIAN FEATURES =================

    public function adminDashboard(Request $request)
    {
        $pendingRequests = Borrow::where('status', 'pending')->with(['book', 'patron'])->get();
        $activeLoans = Borrow::where('status', 'active')->with(['book', 'patron'])->get();
        
        // Search Logic for History
        $query = Borrow::where('status', 'returned')->with(['book', 'patron']);

        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('patron', function($q) use ($search) {
                $q->where('first_name', 'like', "%$search%")->orWhere('last_name', 'like', "%$search%");
            })->orWhereHas('book', function($q) use ($search) {
                $q->where('title', 'like', "%$search%");
            });
        }

        $history = $query->orderBy('borrow_id', 'desc')->take(20)->get();

        return view('librarian', compact('pendingRequests', 'activeLoans', 'history'));
    }

    // THIS IS THE MISSING METHOD
    public function approveRequest($borrow_id)
    {
        $borrow = Borrow::find($borrow_id);
        
        // GET DYNAMIC SETTING: Loan Duration (Default to 7 if missing)
        $duration = SystemSetting::where('setting_key', 'loan_duration_days')->value('setting_value') ?? 7;

        $borrow->status = 'active';
        $borrow->borrow_date = Carbon::now();
        $borrow->due_date = Carbon::now()->addDays((int)$duration); 
        $borrow->librarian_id = 1; // Simulating a logged-in librarian (ID 1)
        $borrow->save();

        $book = Book::find($borrow->book_id);
        $book->availability_status = 'borrowed';
        $book->save();

        return redirect('/librarian')->with('success', "Request Approved. Loan duration: $duration days.");
    }

    public function declineRequest($borrow_id)
    {
        $borrow = Borrow::find($borrow_id);
        
        // Reset Book Status
        $book = Book::find($borrow->book_id);
        $book->availability_status = 'available';
        $book->save();

        $borrow->delete();

        return redirect('/librarian')->with('warning', 'Request Declined and removed.');
    }

    public function returnBook($borrow_id)
    {
        $borrow = Borrow::find($borrow_id);
        $dueDate = Carbon::parse($borrow->due_date);
        $returnDate = Carbon::now();
        $isOverdue = $returnDate->greaterThan($dueDate);

        $borrow->return_date = $returnDate;
        $borrow->status = 'returned';
        $borrow->save();

        $book = Book::find($borrow->book_id);
        $book->availability_status = 'available';
        $book->save();

        if ($isOverdue) {
            // GET DYNAMIC SETTING: Penalty Amount
            $penaltyPerDay = SystemSetting::where('setting_key', 'penalty_per_day')->value('setting_value') ?? 10;
            
            $daysOverdue = $returnDate->diffInDays($dueDate);
            $fineAmount = $daysOverdue * (float)$penaltyPerDay; 

            Penalty::create([
                'borrow_id' => $borrow_id,
                'amount' => $fineAmount,
                'date_applied' => $returnDate,
                'remarks' => "Overdue by $daysOverdue days"
            ]);
            return redirect('/librarian')->with('warning', "Returned Late! Penalty of $fineAmount applied.");
        }

        return redirect('/librarian')->with('success', 'Book returned successfully.');
    }

    // ================= BOOK MANAGEMENT (CRUD) =================

    public function bookIndex()
    {
        $books = Book::with('category')->get();
        return view('books.index', compact('books'));
    }

    public function createBook()
    {
        $categories = Category::all();
        return view('books.create', compact('categories'));
    }

    public function storeBook(Request $request)
    {
        $request->validate(['title' => 'required', 'category_id' => 'required']);
        Book::create($request->all());
        return redirect()->route('books.index')->with('success', 'Book added successfully.');
    }

    public function editBook($id)
    {
        $book = Book::find($id);
        $categories = Category::all();
        return view('books.edit', compact('book', 'categories'));
    }

    public function updateBook(Request $request, $id)
    {
        $book = Book::find($id);
        $book->update($request->all());
        return redirect()->route('books.index')->with('success', 'Book updated.');
    }

    public function destroyBook($id)
    {
        $activeLoan = Borrow::where('book_id', $id)->whereIn('status', ['active', 'pending'])->exists();

        if ($activeLoan) {
            return back()->with('warning', 'Cannot delete book. It is currently borrowed or requested.');
        }

        Book::destroy($id);
        return redirect()->route('books.index')->with('success', 'Book deleted.');
    }
}